namespace LicenseServer;

using System;
using System.Collections.Generic;
using System.Drawing;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Text.Json;
using System.Windows.Forms;
using System.Threading;
using System.Threading.Tasks;

public sealed class MainForm : Form
{
    private readonly string _configPath;
    private readonly LicenseStore _store;
    private readonly Logger _logger;
    private LicenseConfig _config;

    private const string UiLogCategory = "Interface";
    private const string ConfigLogCategory = "Configuração";
    private const string UsersLogCategory = "Usuários";

    private readonly ListBox _usersList = new();
    private readonly Button _addUserButton = new();
    private readonly Button _removeUserButton = new();

    private readonly TextBox _nameText = new();
    private readonly TextBox _identifierText = new();
    private readonly TextBox _coreKeyText = new();
    private readonly TextBox _coreUsageText = new();
    private readonly ComboBox _coreStatusCombo = new();
    private readonly DateTimePicker _coreExpiresPicker = new();
    private readonly TextBox _corePurchaseNameText = new();
    private readonly TextBox _coreCustomFieldsText = new();

    private readonly ListView _modulesList = new();
    private readonly TextBox _moduleKeyText = new();
    private readonly TextBox _moduleUsageText = new();
    private readonly ComboBox _moduleStatusCombo = new();
    private readonly DateTimePicker _moduleExpiresPicker = new();
    private readonly TextBox _modulePurchaseNameText = new();
    private readonly TextBox _moduleCustomFieldsText = new();

    private readonly TextBox _prefixesText = new();
    private readonly TextBox _defaultFieldsText = new();

    private readonly Button _saveButton = new();
    private readonly Button _reloadButton = new();
    private readonly Button _restartButton = new();

    private readonly TextBox _logText = new();
    private readonly StatusStrip _statusStrip = new();
    private readonly ToolStripStatusLabel _statusLabel = new();

    private readonly List<string> _activePrefixes = new();

    private LicenseUser? _selectedUser;
    private ModuleItemContext? _selectedModule;
    private bool _loadingConfig;
    private bool _loadingUser;
    private bool _loadingModule;
    private bool _isDirty;

    private LicenseHttpServer? _server;
    private CancellationTokenSource? _serverCts;
    private Task? _serverTask;

    private readonly GroupBox _userGroup = new();
    private readonly GroupBox _modulesGroup = new();

    public MainForm(string configPath, LicenseConfig config, LicenseStore store, Logger logger)
    {
        _configPath = configPath;
        _config = config;
        _store = store;
        _logger = logger ?? throw new ArgumentNullException(nameof(logger));

        Text = "ImperiaMuCMS License Server";
        MinimumSize = new Size(1100, 720);
        StartPosition = FormStartPosition.CenterScreen;
        DoubleBuffered = true;
        Font = new Font("Segoe UI", 9f, FontStyle.Regular, GraphicsUnit.Point);
        BackColor = Color.FromArgb(245, 248, 250);
        ForeColor = Color.FromArgb(33, 37, 41);

        InitializeLayout();
        LoadConfigurationIntoForm();
        PopulateUsers();

        _logger.EntryWritten += OnLogEntryWritten;

        foreach (var entry in _logger.GetEntries())
        {
            AppendLogEntry(entry);
        }

        _logger.LogInformation(
            "Interface carregada.",
            UiLogCategory,
            new Dictionary<string, string?>
            {
                ["config.path"] = _configPath,
                ["usuarios"] = _config.Users.Count.ToString(CultureInfo.InvariantCulture)
            });

        if (_usersList.Items.Count > 0)
        {
            _usersList.SelectedIndex = 0;
        }

        Shown += (_, _) => StartServer();
        FormClosing += OnFormClosing;
    }

    private void InitializeLayout()
    {
        SuspendLayout();

        _usersList.Dock = DockStyle.Fill;
        _usersList.DisplayMember = nameof(LicenseUser.DisplayName);
        _usersList.BorderStyle = BorderStyle.None;
        _usersList.IntegralHeight = false;
        _usersList.BackColor = Color.White;
        _usersList.SelectedIndexChanged += OnSelectedUserChanged;

        _addUserButton.Text = "Adicionar";
        StyleAccentButton(_addUserButton, Color.FromArgb(0, 123, 255));
        _addUserButton.Click += (_, _) => AddUser();

        _removeUserButton.Text = "Remover";
        StyleAccentButton(_removeUserButton, Color.FromArgb(220, 53, 69));
        _removeUserButton.Click += (_, _) => RemoveUser();

        var leftButtons = new FlowLayoutPanel
        {
            Dock = DockStyle.Fill,
            FlowDirection = FlowDirection.LeftToRight,
            AutoSize = true,
            AutoSizeMode = AutoSizeMode.GrowAndShrink,
            WrapContents = false,
            Padding = new Padding(0, 8, 0, 0),
            Margin = new Padding(0)
        };
        leftButtons.Controls.AddRange(new Control[] { _addUserButton, _removeUserButton });

        var leftLayout = new TableLayoutPanel
        {
            Dock = DockStyle.Fill,
            RowCount = 3,
            ColumnCount = 1,
            Padding = new Padding(0),
            Margin = new Padding(0)
        };
        leftLayout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        leftLayout.RowStyles.Add(new RowStyle(SizeType.Percent, 100f));
        leftLayout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        leftLayout.Controls.Add(new Label
        {
            Text = "Usuários",
            Dock = DockStyle.Fill,
            Padding = new Padding(0, 0, 0, 8),
            Font = new Font(Font, FontStyle.Bold),
            ForeColor = ForeColor
        }, 0, 0);
        leftLayout.Controls.Add(_usersList, 0, 1);
        leftLayout.Controls.Add(leftButtons, 0, 2);

        var mainSplit = new SplitContainer
        {
            Dock = DockStyle.Fill,
            SplitterDistance = 300,
            FixedPanel = FixedPanel.Panel1,
            SplitterWidth = 6,
            BackColor = Color.FromArgb(235, 238, 243)
        };
        mainSplit.Panel1MinSize = 280;
        mainSplit.Panel1.Padding = new Padding(12);
        mainSplit.Panel2.Padding = new Padding(12);
        mainSplit.Panel1.BackColor = Color.Transparent;
        mainSplit.Panel2.BackColor = Color.Transparent;

        var leftContainer = CreateCardPanel(new Padding(16));
        leftContainer.Controls.Add(leftLayout);
        mainSplit.Panel1.Controls.Add(leftContainer);

        _userGroup.Text = "Licença principal";
        _modulesGroup.Text = "Módulos";

        ConfigureUserGroup();
        ConfigureModulesGroup();

        var serverGroup = new GroupBox { Text = "Servidor", Dock = DockStyle.Fill };
        ConfigureServerGroup(serverGroup);

        var logGroup = new GroupBox { Text = "Logs", Dock = DockStyle.Fill };
        ConfigureLogGroup(logGroup);

        ApplyGroupBoxTheme(_userGroup);
        ApplyGroupBoxTheme(_modulesGroup);
        ApplyGroupBoxTheme(serverGroup);
        ApplyGroupBoxTheme(logGroup);

        _userGroup.MinimumSize = new Size(0, 220);
        _modulesGroup.MinimumSize = new Size(0, 260);
        serverGroup.MinimumSize = new Size(0, 160);
        logGroup.MinimumSize = new Size(0, 160);

        _saveButton.Text = "Salvar";
        StyleAccentButton(_saveButton, Color.FromArgb(40, 167, 69));
        _saveButton.Enabled = false;
        _saveButton.Click += (_, _) => SaveConfiguration();

        _reloadButton.Text = "Recarregar";
        StyleAccentButton(_reloadButton, Color.FromArgb(23, 162, 184));
        _reloadButton.Click += (_, _) => ReloadConfiguration();

        _restartButton.Text = "Reiniciar servidor";
        StyleAccentButton(_restartButton, Color.FromArgb(108, 117, 125));
        _restartButton.Click += (_, _) => RestartServer();

        var buttonPanel = new FlowLayoutPanel
        {
            AutoSize = true,
            AutoSizeMode = AutoSizeMode.GrowAndShrink,
            FlowDirection = FlowDirection.LeftToRight,
            WrapContents = false,
            Dock = DockStyle.None,
            Anchor = AnchorStyles.Top | AnchorStyles.Right,
            Margin = new Padding(0, 16, 0, 0)
        };
        buttonPanel.Controls.AddRange(new Control[] { _saveButton, _reloadButton, _restartButton });

        var rightLayout = new TableLayoutPanel
        {
            Dock = DockStyle.Top,
            AutoSize = true,
            AutoSizeMode = AutoSizeMode.GrowAndShrink,
            ColumnCount = 1,
            RowCount = 5,
            Padding = new Padding(0),
            Margin = new Padding(0)
        };
        rightLayout.ColumnStyles.Clear();
        rightLayout.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f));
        rightLayout.RowStyles.Clear();
        rightLayout.RowCount = 5;
        for (var i = 0; i < rightLayout.RowCount; i++)
        {
            rightLayout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        }

        rightLayout.Controls.Add(_userGroup, 0, 0);
        rightLayout.Controls.Add(_modulesGroup, 0, 1);
        rightLayout.Controls.Add(serverGroup, 0, 2);
        rightLayout.Controls.Add(logGroup, 0, 3);
        rightLayout.Controls.Add(buttonPanel, 0, 4);

        var rightContainer = CreateCardPanel(new Padding(20, 16, 20, 16))
        {
            AutoScroll = true,
            AutoScrollMargin = new Size(0, 16)
        };
        rightContainer.Controls.Add(rightLayout);
        AttachScrollSupport(rightContainer, rightLayout);
        mainSplit.Panel2.Controls.Add(rightContainer);

        _statusLabel.Text = "Pronto";
        _statusStrip.Items.Add(_statusLabel);
        _statusLabel.Margin = new Padding(0, 3, 0, 2);
        _statusLabel.ForeColor = Color.FromArgb(73, 80, 87);

        _statusStrip.SizingGrip = false;
        _statusStrip.GripStyle = ToolStripGripStyle.Hidden;
        _statusStrip.BackColor = Color.White;
        _statusStrip.Padding = new Padding(12, 4, 12, 4);

        Controls.Add(mainSplit);
        Controls.Add(_statusStrip);

        _statusStrip.Dock = DockStyle.Bottom;

        ResumeLayout(false);
        PerformLayout();
    }

    private void ConfigureUserGroup()
    {
        var layout = new TableLayoutPanel
        {
            Dock = DockStyle.Fill,
            ColumnCount = 2,
            RowCount = 7,
            Padding = new Padding(12, 8, 12, 12),
            Margin = new Padding(0)
        };
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Absolute, 160));
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f));

        _nameText.Dock = DockStyle.Fill;
        StyleInputControl(_nameText);
        _nameText.TextChanged += (_, _) => UpdateUserName();

        _identifierText.Dock = DockStyle.Fill;
        StyleInputControl(_identifierText);
        _identifierText.TextChanged += (_, _) => UpdateIdentifier();

        _coreKeyText.Dock = DockStyle.Fill;
        StyleInputControl(_coreKeyText);
        _coreKeyText.TextChanged += (_, _) => UpdateCoreKey();

        _coreUsageText.Dock = DockStyle.Fill;
        StyleInputControl(_coreUsageText);
        _coreUsageText.TextChanged += (_, _) => UpdateCoreUsage();

        _coreStatusCombo.Dock = DockStyle.Fill;
        _coreStatusCombo.Items.AddRange(new object[] { "ACTIVE", "INACTIVE", "SUSPENDED" });
        _coreStatusCombo.DropDownStyle = ComboBoxStyle.DropDown;
        StyleInputControl(_coreStatusCombo);
        _coreStatusCombo.TextChanged += (_, _) => UpdateCoreStatus();

        _coreExpiresPicker.Dock = DockStyle.Fill;
        _coreExpiresPicker.Format = DateTimePickerFormat.Custom;
        _coreExpiresPicker.CustomFormat = "dd/MM/yyyy HH:mm";
        _coreExpiresPicker.MinDate = new DateTime(2000, 1, 1);
        _coreExpiresPicker.MaxDate = new DateTime(2100, 12, 31);
        StyleInputControl(_coreExpiresPicker);
        _coreExpiresPicker.ValueChanged += (_, _) => UpdateCoreExpires();

        _corePurchaseNameText.Dock = DockStyle.Fill;
        StyleInputControl(_corePurchaseNameText);
        _corePurchaseNameText.TextChanged += (_, _) => UpdateCorePurchaseName();

        _coreCustomFieldsText.Dock = DockStyle.Fill;
        _coreCustomFieldsText.Multiline = true;
        _coreCustomFieldsText.ScrollBars = ScrollBars.Vertical;
        _coreCustomFieldsText.Height = 80;
        _coreCustomFieldsText.MinimumSize = new Size(0, 80);
        StyleInputControl(_coreCustomFieldsText);
        _coreCustomFieldsText.TextChanged += (_, _) => UpdateCoreCustomFields();

        layout.Controls.Add(CreateFieldLabel("Nome"), 0, 0);
        layout.Controls.Add(_nameText, 1, 0);
        layout.Controls.Add(CreateFieldLabel("Identificador / Email"), 0, 1);
        layout.Controls.Add(_identifierText, 1, 1);
        layout.Controls.Add(CreateFieldLabel("License Key"), 0, 2);
        layout.Controls.Add(_coreKeyText, 1, 2);
        layout.Controls.Add(CreateFieldLabel("Usage ID"), 0, 3);
        layout.Controls.Add(_coreUsageText, 1, 3);
        layout.Controls.Add(CreateFieldLabel("Status"), 0, 4);
        layout.Controls.Add(_coreStatusCombo, 1, 4);
        layout.Controls.Add(CreateFieldLabel("Expira em"), 0, 5);
        layout.Controls.Add(_coreExpiresPicker, 1, 5);
        layout.Controls.Add(CreateFieldLabel("Nome da compra"), 0, 6);
        layout.Controls.Add(_corePurchaseNameText, 1, 6);

        layout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        layout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        layout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        layout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        layout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        layout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        layout.RowStyles.Add(new RowStyle(SizeType.AutoSize));

        layout.RowCount += 1;
        layout.RowStyles.Add(new RowStyle(SizeType.Percent, 100f));
        layout.Controls.Add(CreateFieldLabel("Campos personalizados (um por linha)"), 0, 7);
        layout.Controls.Add(_coreCustomFieldsText, 1, 7);
        layout.SetColumnSpan(_coreCustomFieldsText, 1);

        _userGroup.Dock = DockStyle.Fill;
        _userGroup.Controls.Add(layout);
    }

    private void ConfigureModulesGroup()
    {
        var split = new SplitContainer
        {
            Dock = DockStyle.Fill,
            SplitterDistance = 320,
            SplitterWidth = 6,
            BorderStyle = BorderStyle.None,
            BackColor = Color.FromArgb(245, 248, 250)
        };
        split.Panel1MinSize = 220;
        split.Panel1.Padding = new Padding(0, 0, 12, 0);
        split.Panel2.Padding = new Padding(12, 0, 0, 0);
        split.Panel2.AutoScroll = true;
        split.Panel2.AutoScrollMargin = new Size(0, 12);
        split.Panel1.BackColor = Color.White;
        split.Panel2.BackColor = Color.White;

        split.HandleCreated += (_, _) => EnsureModulesSplitSizing(split);
        split.SizeChanged += (_, _) => EnsureModulesSplitSizing(split);
        EnsureModulesSplitSizing(split);

        _modulesList.Dock = DockStyle.Fill;
        _modulesList.View = View.Details;
        _modulesList.CheckBoxes = true;
        _modulesList.FullRowSelect = true;
        _modulesList.HideSelection = false;
        _modulesList.HeaderStyle = ColumnHeaderStyle.Nonclickable;
        _modulesList.BorderStyle = BorderStyle.None;
        _modulesList.BackColor = Color.White;
        _modulesList.Margin = new Padding(0);
        _modulesList.Columns.Add("Módulo", 180);
        _modulesList.Columns.Add("Chave", 120);
        _modulesList.ItemCheck += OnModuleItemCheck;
        _modulesList.SelectedIndexChanged += OnSelectedModuleChanged;

        split.Panel1.Controls.Add(_modulesList);

        var layout = new TableLayoutPanel
        {
            Dock = DockStyle.Fill,
            ColumnCount = 2,
            Padding = new Padding(12, 8, 12, 12),
            Margin = new Padding(0)
        };
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Absolute, 160));
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f));
        layout.RowCount = 6;

        _moduleKeyText.Dock = DockStyle.Fill;
        StyleInputControl(_moduleKeyText);
        _moduleKeyText.TextChanged += (_, _) => UpdateModuleKey();

        _moduleUsageText.Dock = DockStyle.Fill;
        StyleInputControl(_moduleUsageText);
        _moduleUsageText.TextChanged += (_, _) => UpdateModuleUsage();

        _moduleStatusCombo.Dock = DockStyle.Fill;
        _moduleStatusCombo.Items.AddRange(new object[] { "ACTIVE", "INACTIVE", "SUSPENDED" });
        _moduleStatusCombo.DropDownStyle = ComboBoxStyle.DropDown;
        StyleInputControl(_moduleStatusCombo);
        _moduleStatusCombo.TextChanged += (_, _) => UpdateModuleStatus();

        _moduleExpiresPicker.Dock = DockStyle.Fill;
        _moduleExpiresPicker.Format = DateTimePickerFormat.Custom;
        _moduleExpiresPicker.CustomFormat = "dd/MM/yyyy HH:mm";
        _moduleExpiresPicker.MinDate = new DateTime(2000, 1, 1);
        _moduleExpiresPicker.MaxDate = new DateTime(2100, 12, 31);
        StyleInputControl(_moduleExpiresPicker);
        _moduleExpiresPicker.ValueChanged += (_, _) => UpdateModuleExpires();

        _modulePurchaseNameText.Dock = DockStyle.Fill;
        StyleInputControl(_modulePurchaseNameText);
        _modulePurchaseNameText.TextChanged += (_, _) => UpdateModulePurchaseName();

        _moduleCustomFieldsText.Dock = DockStyle.Fill;
        _moduleCustomFieldsText.Multiline = true;
        _moduleCustomFieldsText.ScrollBars = ScrollBars.Vertical;
        _moduleCustomFieldsText.Height = 80;
        _moduleCustomFieldsText.MinimumSize = new Size(0, 80);
        StyleInputControl(_moduleCustomFieldsText);
        _moduleCustomFieldsText.TextChanged += (_, _) => UpdateModuleCustomFields();

        layout.RowStyles.Clear();
        for (var i = 0; i < 5; i++)
        {
            layout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        }
        layout.RowStyles.Add(new RowStyle(SizeType.Percent, 100f));

        layout.Controls.Add(CreateFieldLabel("Chave"), 0, 0);
        layout.Controls.Add(_moduleKeyText, 1, 0);
        layout.Controls.Add(CreateFieldLabel("Usage ID"), 0, 1);
        layout.Controls.Add(_moduleUsageText, 1, 1);
        layout.Controls.Add(CreateFieldLabel("Status"), 0, 2);
        layout.Controls.Add(_moduleStatusCombo, 1, 2);
        layout.Controls.Add(CreateFieldLabel("Expira em"), 0, 3);
        layout.Controls.Add(_moduleExpiresPicker, 1, 3);
        layout.Controls.Add(CreateFieldLabel("Nome da compra"), 0, 4);
        layout.Controls.Add(_modulePurchaseNameText, 1, 4);
        layout.Controls.Add(CreateFieldLabel("Campos personalizados"), 0, 5);
        layout.Controls.Add(_moduleCustomFieldsText, 1, 5);

        split.Panel2.Controls.Add(layout);
        AttachScrollSupport(split.Panel2, layout);

        _modulesGroup.Dock = DockStyle.Fill;
        _modulesGroup.Controls.Add(split);
    }

    private static void EnsureModulesSplitSizing(SplitContainer split)
    {
        const int desiredPanel2Min = 280;
        const int desiredDistance = 320;

        var totalWidth = split.Width;
        if (totalWidth <= split.Panel1MinSize + split.SplitterWidth)
        {
            split.Panel2MinSize = 0;
            return;
        }

        var availableForPanel2 = Math.Max(0, totalWidth - split.Panel1MinSize - split.SplitterWidth);
        var panel2Min = Math.Min(desiredPanel2Min, availableForPanel2);
        if (split.Panel2MinSize != panel2Min)
        {
            split.Panel2MinSize = panel2Min;
        }

        var maxDistance = totalWidth - split.Panel2MinSize - split.SplitterWidth;
        if (maxDistance <= split.Panel1MinSize)
        {
            split.SplitterDistance = split.Panel1MinSize;
            return;
        }

        var target = Math.Max(desiredDistance, split.Panel1MinSize);
        var clamped = Math.Min(Math.Max(target, split.Panel1MinSize), maxDistance);

        if (split.SplitterDistance != clamped)
        {
            split.SplitterDistance = clamped;
        }
    }

    private void ConfigureServerGroup(GroupBox group)
    {
        var layout = new TableLayoutPanel
        {
            Dock = DockStyle.Fill,
            ColumnCount = 2,
            Padding = new Padding(12, 8, 12, 12),
            Margin = new Padding(0)
        };
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Absolute, 160));
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f));

        _prefixesText.Dock = DockStyle.Fill;
        _prefixesText.Multiline = true;
        _prefixesText.ScrollBars = ScrollBars.Vertical;
        StyleInputControl(_prefixesText);
        _prefixesText.TextChanged += (_, _) => MarkDirty();

        _defaultFieldsText.Dock = DockStyle.Fill;
        _defaultFieldsText.Multiline = true;
        _defaultFieldsText.ScrollBars = ScrollBars.Vertical;
        StyleInputControl(_defaultFieldsText);
        _defaultFieldsText.TextChanged += (_, _) => MarkDirty();

        layout.RowStyles.Add(new RowStyle(SizeType.Percent, 50f));
        layout.RowStyles.Add(new RowStyle(SizeType.Percent, 50f));

        layout.Controls.Add(CreateFieldLabel("URLs (um por linha)"), 0, 0);
        layout.Controls.Add(_prefixesText, 1, 0);
        layout.Controls.Add(CreateFieldLabel("Campos padrão (um por linha)"), 0, 1);
        layout.Controls.Add(_defaultFieldsText, 1, 1);

        group.Controls.Add(layout);
    }

    private void ConfigureLogGroup(GroupBox group)
    {
        _logText.Dock = DockStyle.Fill;
        _logText.Multiline = true;
        _logText.ReadOnly = true;
        _logText.ScrollBars = ScrollBars.Vertical;
        _logText.Font = new Font(FontFamily.GenericMonospace, 9f);
        _logText.BorderStyle = BorderStyle.None;
        _logText.BackColor = Color.FromArgb(248, 249, 250);
        _logText.ForeColor = Color.FromArgb(52, 58, 64);
        _logText.Margin = new Padding(0);

        group.Controls.Add(_logText);
    }

    private static Panel CreateCardPanel(Padding padding)
    {
        var panel = new Panel
        {
            Dock = DockStyle.Fill,
            Padding = padding,
            BackColor = Color.White,
            Margin = new Padding(0)
        };

        panel.Paint += CardPanelOnPaint;
        panel.Resize += (_, _) => panel.Invalidate();

        return panel;
    }

    private static void AttachScrollSupport(ScrollableControl container, Control content)
    {
        if (container is null)
        {
            throw new ArgumentNullException(nameof(container));
        }

        if (content is null)
        {
            throw new ArgumentNullException(nameof(content));
        }

        container.AutoScroll = true;

        void UpdateScroll()
        {
            var clientWidth = container.ClientSize.Width;
            if (clientWidth <= 0)
            {
                clientWidth = container.Width;
            }

            var availableWidth = Math.Max(1, clientWidth - container.Padding.Horizontal);
            var preferred = content.GetPreferredSize(new Size(availableWidth, 0));
            var requiredHeight = Math.Max(preferred.Height, content.MinimumSize.Height);
            container.AutoScrollMinSize = new Size(0, Math.Max(0, requiredHeight + container.Padding.Vertical));
        }

        container.Resize += (_, _) => UpdateScroll();
        content.ControlAdded += (_, _) => UpdateScroll();
        content.ControlRemoved += (_, _) => UpdateScroll();
        content.SizeChanged += (_, _) => UpdateScroll();
        content.Layout += (_, _) => UpdateScroll();

        if (!container.IsHandleCreated)
        {
            container.HandleCreated += (_, _) => UpdateScroll();
        }

        if (!content.IsHandleCreated)
        {
            content.HandleCreated += (_, _) => UpdateScroll();
        }

        UpdateScroll();
    }

    private static void CardPanelOnPaint(object? sender, PaintEventArgs e)
    {
        if (sender is not Panel panel)
        {
            return;
        }

        var rect = panel.ClientRectangle;
        if (rect.Width <= 0 || rect.Height <= 0)
        {
            return;
        }

        rect.Width -= 1;
        rect.Height -= 1;

        using var pen = new Pen(Color.FromArgb(223, 228, 234));
        e.Graphics.DrawRectangle(pen, rect);
    }

    private static void StyleAccentButton(Button button, Color backgroundColor)
    {
        button.AutoSize = true;
        button.AutoSizeMode = AutoSizeMode.GrowAndShrink;
        button.FlatStyle = FlatStyle.Flat;
        button.FlatAppearance.BorderSize = 0;
        button.FlatAppearance.MouseOverBackColor = ControlPaint.Light(backgroundColor);
        button.FlatAppearance.MouseDownBackColor = ControlPaint.Dark(backgroundColor);
        button.BackColor = backgroundColor;
        button.ForeColor = Color.White;
        button.Margin = new Padding(4);
        button.Padding = new Padding(12, 6, 12, 6);
        button.UseVisualStyleBackColor = false;
        button.Cursor = Cursors.Hand;
    }

    private static void ApplyGroupBoxTheme(GroupBox group)
    {
        group.Padding = new Padding(12, 28, 12, 12);
        group.Margin = new Padding(0, 0, 0, 12);
        group.BackColor = Color.White;
        group.ForeColor = Color.FromArgb(52, 58, 64);
    }

    private static void StyleInputControl(Control control)
    {
        control.Margin = new Padding(0, 4, 0, 4);

        switch (control)
        {
            case TextBoxBase textBox:
                textBox.BorderStyle = BorderStyle.FixedSingle;
                textBox.BackColor = Color.White;
                textBox.ForeColor = Color.FromArgb(52, 58, 64);
                break;
            case ComboBox comboBox:
                comboBox.FlatStyle = FlatStyle.Standard;
                comboBox.Margin = new Padding(0, 4, 0, 4);
                comboBox.ForeColor = Color.FromArgb(52, 58, 64);
                break;
            case DateTimePicker picker:
                picker.Margin = new Padding(0, 4, 0, 4);
                break;
        }
    }

    private Label CreateFieldLabel(string text)
    {
        return new Label
        {
            Text = text,
            AutoSize = true,
            TextAlign = ContentAlignment.MiddleLeft,
            Margin = new Padding(0, 6, 8, 6),
            ForeColor = Color.FromArgb(73, 80, 87),
            Font = new Font(Font, FontStyle.Regular)
        };
    }

    private void PopulateUsers()
    {
        _loadingConfig = true;
        _usersList.BeginUpdate();
        _usersList.Items.Clear();
        foreach (var user in _config.Users)
        {
            _usersList.Items.Add(user);
        }
        _usersList.EndUpdate();
        _loadingConfig = false;
        UpdateUserSelection();
    }

    private void LoadConfigurationIntoForm()
    {
        _loadingConfig = true;
        _prefixesText.Text = string.Join(Environment.NewLine, _config.Prefixes);
        _defaultFieldsText.Text = string.Join(Environment.NewLine, TrimTrailingEmpty(_config.DefaultCustomFields));
        _loadingConfig = false;
    }

    private void UpdateUserSelection()
    {
        if (_usersList.SelectedItem is LicenseUser user)
        {
            LoadUser(user);
        }
        else
        {
            _selectedUser = null;
            ClearUserFields();
        }
    }

    private void LoadUser(LicenseUser user)
    {
        _selectedUser = user;
        _loadingUser = true;

        _nameText.Text = user.Name;
        _identifierText.Text = user.Identifier;

        var core = user.CoreLicense;
        _coreKeyText.Text = core.Key;
        _coreUsageText.Text = core.UsageId;
        _coreStatusCombo.Text = core.Status;
        _corePurchaseNameText.Text = core.PurchaseName;
        _coreExpiresPicker.Value = FromUnixTime(core.Expires);
        _coreCustomFieldsText.Text = string.Join(Environment.NewLine, TrimTrailingEmpty(core.CustomFields));

        PopulateModules(user);

        _loadingUser = false;
        UpdateUserControlsEnabled();
    }

    private void PopulateModules(LicenseUser user)
    {
        _loadingUser = true;
        _modulesList.BeginUpdate();
        _modulesList.Items.Clear();

        foreach (var definition in _config.Modules)
        {
            var assignment = user.Modules.FirstOrDefault(m =>
                string.Equals(m.ModuleId, definition.Id, StringComparison.OrdinalIgnoreCase));

            var item = new ListViewItem(definition.DisplayName)
            {
                Checked = assignment is not null,
                Tag = new ModuleItemContext(definition, assignment)
            };
            item.SubItems.Add(assignment?.Key ?? string.Empty);

            _modulesList.Items.Add(item);
        }

        _modulesList.EndUpdate();
        _loadingUser = false;
        _selectedModule = null;
        ClearModuleFields();
    }

    private void ClearUserFields()
    {
        _loadingUser = true;
        _nameText.Text = string.Empty;
        _identifierText.Text = string.Empty;
        _coreKeyText.Text = string.Empty;
        _coreUsageText.Text = string.Empty;
        _coreStatusCombo.Text = string.Empty;
        _corePurchaseNameText.Text = string.Empty;
        _coreCustomFieldsText.Text = string.Empty;
        _modulesList.Items.Clear();
        _loadingUser = false;
        UpdateUserControlsEnabled();
    }

    private void UpdateUserControlsEnabled()
    {
        var hasUser = _selectedUser is not null;
        _userGroup.Enabled = hasUser;
        _modulesGroup.Enabled = hasUser;
    }

    private void OnSelectedUserChanged(object? sender, EventArgs e)
    {
        if (_loadingConfig)
        {
            return;
        }

        UpdateUserSelection();
    }

    private void AddUser()
    {
        var suffix = GenerateSuffix();
        var user = new LicenseUser
        {
            Name = $"Usuário {_config.Users.Count + 1}",
            Identifier = $"user{_config.Users.Count + 1}@example.com",
            CoreLicense = new LicenseEntry
            {
                Key = $"IMPERIA-CORE-{suffix}",
                PurchaseName = "ImperiaMuCMS Premium Package",
                Status = "ACTIVE",
                UsageId = $"CORE-{suffix}",
                Expires = DateTimeOffset.UtcNow.AddYears(2).ToUnixTimeSeconds(),
                CustomFields = new List<string>(_config.DefaultCustomFields)
            }
        };

        _config.Users.Add(user);
        PopulateUsers();
        _usersList.SelectedItem = user;
        MarkDirty();
        _logger.LogInformation(
            "Usuário criado pela interface.",
            UsersLogCategory,
            new Dictionary<string, string?>
            {
                ["usuario.nome"] = user.Name,
                ["usuario.identificador"] = user.Identifier,
                ["licenca.principal"] = user.CoreLicense.Key
            });
        UpdateStatus("Usuário criado.");
    }

    private void RemoveUser()
    {
        if (_selectedUser is null)
        {
            return;
        }

        var confirm = MessageBox.Show(
            $"Remover {_selectedUser.DisplayName}?", "Confirmação",
            MessageBoxButtons.YesNo, MessageBoxIcon.Question);
        if (confirm != DialogResult.Yes)
        {
            return;
        }

        var index = _usersList.SelectedIndex;
        var removedUser = _selectedUser;
        _config.Users.Remove(_selectedUser);
        PopulateUsers();

        if (_usersList.Items.Count > 0)
        {
            _usersList.SelectedIndex = Math.Min(index, _usersList.Items.Count - 1);
        }

        MarkDirty();
        _logger.LogInformation(
            "Usuário removido pela interface.",
            UsersLogCategory,
            new Dictionary<string, string?>
            {
                ["usuario.nome"] = removedUser?.DisplayName,
                ["usuario.identificador"] = removedUser?.Identifier
            });
        UpdateStatus("Usuário removido.");
    }

    private void UpdateUserName()
    {
        if (_loadingUser || _selectedUser is null)
        {
            return;
        }

        _selectedUser.Name = _nameText.Text.Trim();
        MarkDirty();
        _usersList.Refresh();
    }

    private void UpdateIdentifier()
    {
        if (_loadingUser || _selectedUser is null)
        {
            return;
        }

        _selectedUser.Identifier = _identifierText.Text.Trim();
        MarkDirty();
    }

    private void UpdateCoreKey()
    {
        if (_loadingUser || _selectedUser is null)
        {
            return;
        }

        _selectedUser.CoreLicense.Key = _coreKeyText.Text.Trim();
        MarkDirty();
    }

    private void UpdateCoreUsage()
    {
        if (_loadingUser || _selectedUser is null)
        {
            return;
        }

        _selectedUser.CoreLicense.UsageId = _coreUsageText.Text.Trim();
        MarkDirty();
    }

    private void UpdateCoreStatus()
    {
        if (_loadingUser || _selectedUser is null)
        {
            return;
        }

        _selectedUser.CoreLicense.Status = _coreStatusCombo.Text.Trim();
        MarkDirty();
    }

    private void UpdateCoreExpires()
    {
        if (_loadingUser || _selectedUser is null)
        {
            return;
        }

        _selectedUser.CoreLicense.Expires = ToUnixTime(_coreExpiresPicker.Value);
        MarkDirty();
    }

    private void UpdateCorePurchaseName()
    {
        if (_loadingUser || _selectedUser is null)
        {
            return;
        }

        _selectedUser.CoreLicense.PurchaseName = _corePurchaseNameText.Text.Trim();
        MarkDirty();
    }

    private void UpdateCoreCustomFields()
    {
        if (_loadingUser || _selectedUser is null)
        {
            return;
        }

        var fields = ParseCustomFields(_coreCustomFieldsText.Text);
        _selectedUser.CoreLicense.CustomFields = fields.Count == 0 ? null : fields;
        MarkDirty();
    }

    private void OnModuleItemCheck(object? sender, ItemCheckEventArgs e)
    {
        if (_loadingUser || _selectedUser is null)
        {
            return;
        }

        var item = _modulesList.Items[e.Index];
        if (item.Tag is not ModuleItemContext context)
        {
            return;
        }

        if (e.NewValue == CheckState.Checked)
        {
            if (context.Assignment is null)
            {
                context.Assignment = CreateAssignment(context.Definition, _selectedUser);
                _selectedUser.Modules.Add(context.Assignment);
            }

            item.SubItems[1].Text = context.Assignment.Key;
        }
        else
        {
            if (context.Assignment is not null)
            {
                _selectedUser.Modules.Remove(context.Assignment);
                context.Assignment = null;
            }

            item.SubItems[1].Text = string.Empty;
            if (_selectedModule == context)
            {
                _selectedModule = null;
                ClearModuleFields();
            }
        }

        MarkDirty();
    }

    private void OnSelectedModuleChanged(object? sender, EventArgs e)
    {
        if (_loadingUser)
        {
            return;
        }

        if (_modulesList.SelectedItems.Count == 0)
        {
            _selectedModule = null;
            ClearModuleFields();
            return;
        }

        var context = _modulesList.SelectedItems[0].Tag as ModuleItemContext;
        _selectedModule = context;
        LoadModule(context);
    }

    private void LoadModule(ModuleItemContext? context)
    {
        _loadingModule = true;

        if (context?.Assignment is null)
        {
            _moduleKeyText.Text = string.Empty;
            _moduleUsageText.Text = string.Empty;
            _moduleStatusCombo.Text = string.Empty;
            _moduleExpiresPicker.Value = DateTime.Now;
            _modulePurchaseNameText.Text = string.Empty;
            _moduleCustomFieldsText.Text = string.Empty;
            EnableModuleEditors(false);
        }
        else
        {
            EnableModuleEditors(true);
            _moduleKeyText.Text = context.Assignment.Key;
            _moduleUsageText.Text = context.Assignment.UsageId;
            _moduleStatusCombo.Text = context.Assignment.Status;
            _moduleExpiresPicker.Value = FromUnixTime(context.Assignment.Expires);
            _modulePurchaseNameText.Text = context.Assignment.PurchaseName;
            _moduleCustomFieldsText.Text = string.Join(Environment.NewLine, TrimTrailingEmpty(context.Assignment.CustomFields));
        }

        _loadingModule = false;
    }

    private void ClearModuleFields()
    {
        _loadingModule = true;
        _moduleKeyText.Text = string.Empty;
        _moduleUsageText.Text = string.Empty;
        _moduleStatusCombo.Text = string.Empty;
        _moduleExpiresPicker.Value = DateTime.Now;
        _modulePurchaseNameText.Text = string.Empty;
        _moduleCustomFieldsText.Text = string.Empty;
        EnableModuleEditors(false);
        _loadingModule = false;
    }

    private void EnableModuleEditors(bool enabled)
    {
        _moduleKeyText.Enabled = enabled;
        _moduleUsageText.Enabled = enabled;
        _moduleStatusCombo.Enabled = enabled;
        _moduleExpiresPicker.Enabled = enabled;
        _modulePurchaseNameText.Enabled = enabled;
        _moduleCustomFieldsText.Enabled = enabled;
    }

    private void UpdateModuleKey()
    {
        if (_loadingModule || _selectedModule?.Assignment is null)
        {
            return;
        }

        _selectedModule.Assignment.Key = _moduleKeyText.Text.Trim();
        UpdateModuleListEntry();
        MarkDirty();
    }

    private void UpdateModuleUsage()
    {
        if (_loadingModule || _selectedModule?.Assignment is null)
        {
            return;
        }

        _selectedModule.Assignment.UsageId = _moduleUsageText.Text.Trim();
        MarkDirty();
    }

    private void UpdateModuleStatus()
    {
        if (_loadingModule || _selectedModule?.Assignment is null)
        {
            return;
        }

        _selectedModule.Assignment.Status = _moduleStatusCombo.Text.Trim();
        MarkDirty();
    }

    private void UpdateModuleExpires()
    {
        if (_loadingModule || _selectedModule?.Assignment is null)
        {
            return;
        }

        _selectedModule.Assignment.Expires = ToUnixTime(_moduleExpiresPicker.Value);
        MarkDirty();
    }

    private void UpdateModulePurchaseName()
    {
        if (_loadingModule || _selectedModule?.Assignment is null)
        {
            return;
        }

        _selectedModule.Assignment.PurchaseName = _modulePurchaseNameText.Text.Trim();
        MarkDirty();
    }

    private void UpdateModuleCustomFields()
    {
        if (_loadingModule || _selectedModule?.Assignment is null)
        {
            return;
        }

        var fields = ParseCustomFields(_moduleCustomFieldsText.Text);
        _selectedModule.Assignment.CustomFields = fields.Count == 0 ? null : fields;
        MarkDirty();
    }

    private void UpdateModuleListEntry()
    {
        if (_modulesList.SelectedItems.Count == 0)
        {
            return;
        }

        var item = _modulesList.SelectedItems[0];
        if (item.Tag is ModuleItemContext context && context.Assignment is not null)
        {
            item.SubItems[1].Text = context.Assignment.Key;
        }
    }

    private void SaveConfiguration()
    {
        try
        {
            var prefixes = ParseLines(_prefixesText.Text);
            if (prefixes.Count == 0)
            {
                MessageBox.Show("Informe ao menos uma URL.", "Validação", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            var defaults = ParseCustomFields(_defaultFieldsText.Text);
            if (defaults.Count == 0)
            {
                MessageBox.Show("Informe ao menos um campo padrão.", "Validação", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            _config.Prefixes = prefixes;
            _config.DefaultCustomFields = defaults;

            var json = JsonSerializer.Serialize(_config, LicenseConfig.JsonOptions);
            File.WriteAllText(_configPath, json, Encoding.UTF8);

            _store.Update(_config);
            _activePrefixes.Clear();
            _activePrefixes.AddRange(prefixes);
            _isDirty = false;
            _saveButton.Enabled = false;
            _logger.LogInformation("Configuração salva.", ConfigLogCategory, BuildConfigurationMetadata());
            UpdateStatus("Configuração salva.");

            RestartServer();
        }
        catch (Exception ex)
        {
            _logger.LogError("Falha ao salvar configuração.", ConfigLogCategory, ex);
            MessageBox.Show($"Falha ao salvar: {ex.Message}", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
        }
    }

    private void ReloadConfiguration()
    {
        if (_isDirty)
        {
            var result = MessageBox.Show(
                "Descartar alterações não salvas?",
                "Recarregar",
                MessageBoxButtons.YesNo,
                MessageBoxIcon.Question);
            if (result != DialogResult.Yes)
            {
                return;
            }
        }

        try
        {
            if (!File.Exists(_configPath))
            {
                _config = LicenseConfig.CreateDefault();
            }
            else
            {
                using var stream = File.OpenRead(_configPath);
                _config = JsonSerializer.Deserialize<LicenseConfig>(stream, LicenseConfig.JsonOptions)
                          ?? LicenseConfig.CreateDefault();
            }

            _store.Update(_config);
            _isDirty = false;
            _saveButton.Enabled = false;
            LoadConfigurationIntoForm();
            PopulateUsers();
            RestartServer();
            _logger.LogInformation("Configuração recarregada do disco.", ConfigLogCategory, BuildConfigurationMetadata());
            UpdateStatus("Configuração recarregada.");
        }
        catch (Exception ex)
        {
            _logger.LogError("Falha ao recarregar configuração.", ConfigLogCategory, ex);
            MessageBox.Show($"Falha ao recarregar: {ex.Message}", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
        }
    }

    private void StartServer()
    {
        StopServer();

        try
        {
            var metadata = BuildPrefixMetadata(_config.Prefixes);
            _logger.LogInformation("Solicitando inicialização do servidor HTTP.", UiLogCategory, metadata);

            _server = new LicenseHttpServer(_config.Prefixes, _store, _logger);
            var serverInstance = _server;
            var cts = new CancellationTokenSource();
            _serverCts = cts;
            _activePrefixes.Clear();
            _activePrefixes.AddRange(_config.Prefixes);
            _serverTask = serverInstance.RunAsync(cts.Token);
            var scheduler = SynchronizationContext.Current is not null
                ? TaskScheduler.FromCurrentSynchronizationContext()
                : TaskScheduler.Current;
            _serverTask.ContinueWith(task => OnServerTaskCompleted(task, cts, serverInstance), CancellationToken.None, TaskContinuationOptions.None, scheduler);
            UpdateStatus("Servidor iniciado.");
        }
        catch (Exception ex)
        {
            _logger.LogError(
                "Falha ao iniciar o servidor HTTP.",
                UiLogCategory,
                ex,
                BuildPrefixMetadata(_config.Prefixes));
            UpdateStatus("Falha ao iniciar servidor.");
        }
    }

    private void RestartServer()
    {
        _logger.LogInformation("Reiniciando servidor HTTP.", UiLogCategory);
        StopServer();
        StartServer();
    }

    private void StopServer()
    {
        if (_server is not null)
        {
            _logger.LogInformation("Solicitando parada do servidor HTTP.", UiLogCategory);
        }

        var cts = _serverCts;
        var task = _serverTask;
        try
        {
            cts?.Cancel();
            _server?.Stop();
        }
        catch
        {
            // ignore
        }
        finally
        {
            _server = null;
            _serverCts = null;
            _serverTask = null;

            if (task is null)
            {
                cts?.Dispose();
            }
        }
    }

    private void OnServerTaskCompleted(Task task, CancellationTokenSource? cts, LicenseHttpServer? server)
    {
        try
        {
            if (task.IsFaulted)
            {
                var message = ExtractTaskErrorMessage(task.Exception);
                var metadata = BuildPrefixMetadata(_activePrefixes);
                var errorMessage = string.IsNullOrWhiteSpace(message)
                    ? "Servidor finalizado com erro desconhecido."
                    : $"Servidor finalizado com erro: {message}";
                _logger.LogError(errorMessage, UiLogCategory, task.Exception, metadata);
                UpdateStatus("Servidor parado (erro).");
                return;
            }

            if (task.IsCanceled)
            {
                _logger.LogInformation("Servidor finalizado: cancelado.", UiLogCategory, BuildPrefixMetadata(_activePrefixes));
            }
            else
            {
                _logger.LogInformation("Servidor finalizado com sucesso.", UiLogCategory, BuildPrefixMetadata(_activePrefixes));
            }

            UpdateStatus("Servidor parado.");
        }
        finally
        {
            if (ReferenceEquals(_serverTask, task))
            {
                _serverTask = null;
            }

            if (ReferenceEquals(_serverCts, cts))
            {
                _serverCts = null;
            }

            if (ReferenceEquals(_server, server))
            {
                _server = null;
            }

            cts?.Dispose();
        }
    }

    private static string ExtractTaskErrorMessage(AggregateException? exception)
    {
        if (exception is null)
        {
            return string.Empty;
        }

        var inner = exception.Flatten().InnerExceptions.FirstOrDefault();
        return inner?.Message ?? exception.Message;
    }

    private void OnFormClosing(object? sender, FormClosingEventArgs e)
    {
        if (_isDirty)
        {
            var result = MessageBox.Show(
                "Deseja salvar as alterações antes de sair?",
                "Sair",
                MessageBoxButtons.YesNoCancel,
                MessageBoxIcon.Question);

            if (result == DialogResult.Cancel)
            {
                e.Cancel = true;
                return;
            }

            if (result == DialogResult.Yes)
            {
                SaveConfiguration();
            }
        }

        _logger.LogInformation("Interface encerrada pelo usuário.", UiLogCategory);
        StopServer();
    }

    private void OnLogEntryWritten(object? sender, LogEntryEventArgs e)
    {
        if (InvokeRequired)
        {
            BeginInvoke(new Action<LogEntry>(AppendLogEntry), e.Entry);
            return;
        }

        AppendLogEntry(e.Entry);
    }

    private void AppendLogEntry(LogEntry entry)
    {
        if (IsDisposed)
        {
            return;
        }

        var text = entry.ToDisplayString();

        const int maxCharacters = 60000;
        if (_logText.TextLength + text.Length > maxCharacters)
        {
            var removeLength = (_logText.TextLength + text.Length) - maxCharacters;
            _logText.Select(0, Math.Min(removeLength, _logText.TextLength));
            _logText.SelectedText = string.Empty;
        }

        _logText.AppendText(text);
        _logText.SelectionStart = _logText.TextLength;
        _logText.ScrollToCaret();
    }

    private IReadOnlyDictionary<string, string?> BuildConfigurationMetadata()
    {
        var metadata = new Dictionary<string, string?>
        {
            ["arquivo"] = _configPath,
            ["usuarios"] = _config.Users.Count.ToString(CultureInfo.InvariantCulture),
            ["prefixos"] = (_config.Prefixes?.Count ?? 0).ToString(CultureInfo.InvariantCulture)
        };

        if (_config.Prefixes is { Count: > 0 })
        {
            for (var index = 0; index < _config.Prefixes.Count; index++)
            {
                metadata[$"prefixo[{index}]"] = _config.Prefixes[index];
            }
        }

        return metadata;
    }

    private static IReadOnlyDictionary<string, string?> BuildPrefixMetadata(IReadOnlyList<string>? prefixes)
    {
        var metadata = new Dictionary<string, string?>
        {
            ["prefixos"] = (prefixes?.Count ?? 0).ToString(CultureInfo.InvariantCulture)
        };

        if (prefixes is not null)
        {
            for (var index = 0; index < prefixes.Count; index++)
            {
                metadata[$"prefixo[{index}]"] = prefixes[index];
            }
        }

        return metadata;
    }

    private void MarkDirty()
    {
        if (_loadingConfig)
        {
            return;
        }

        if (_isDirty)
        {
            return;
        }

        _isDirty = true;
        _saveButton.Enabled = true;
        UpdateStatus("Alterações pendentes.");
    }

    private void UpdateStatus(string message)
    {
        if (InvokeRequired)
        {
            BeginInvoke(new Action<string>(UpdateStatus), message);
            return;
        }

        _statusLabel.Text = message;
    }

    private static List<string> ParseCustomFields(string text)
    {
        var list = ParseLines(text);
        while (list.Count > 0 && string.IsNullOrWhiteSpace(list[^1]))
        {
            list.RemoveAt(list.Count - 1);
        }

        return list;
    }

    private static List<string> ParseLines(string text)
    {
        return text.Replace("\r", string.Empty)
            .Split(new[] { '\n' }, StringSplitOptions.RemoveEmptyEntries)
            .Select(line => line.Trim())
            .Where(line => !string.IsNullOrEmpty(line))
            .ToList();
    }

    private static List<string> TrimTrailingEmpty(List<string>? values)
    {
        if (values is null)
        {
            return new List<string>();
        }

        var list = values.ToList();
        while (list.Count > 0 && string.IsNullOrWhiteSpace(list[^1]))
        {
            list.RemoveAt(list.Count - 1);
        }

        return list;
    }

    private static DateTime FromUnixTime(long value)
    {
        if (value <= 0)
        {
            return DateTime.Now;
        }

        try
        {
            return DateTimeOffset.FromUnixTimeSeconds(value).LocalDateTime;
        }
        catch
        {
            return DateTime.Now;
        }
    }

    private static long ToUnixTime(DateTime value)
    {
        return new DateTimeOffset(value).ToUnixTimeSeconds();
    }

    private static string GenerateSuffix()
    {
        return Guid.NewGuid().ToString("N", CultureInfo.InvariantCulture)[..8].ToUpperInvariant();
    }

    private static string BuildSuffix(LicenseUser user)
    {
        var source = !string.IsNullOrWhiteSpace(user.Identifier) ? user.Identifier : user.Name;
        if (string.IsNullOrWhiteSpace(source))
        {
            return GenerateSuffix();
        }

        var normalized = new string(source.Where(char.IsLetterOrDigit).ToArray());
        if (string.IsNullOrWhiteSpace(normalized))
        {
            return GenerateSuffix();
        }

        normalized = normalized.ToUpperInvariant();
        return normalized.Length > 12 ? normalized[..12] : normalized;
    }

    private static string AppendSuffix(string value, string suffix)
    {
        if (string.IsNullOrWhiteSpace(value))
        {
            return suffix;
        }

        return value.EndsWith(suffix, StringComparison.OrdinalIgnoreCase)
            ? value
            : $"{value}-{suffix}";
    }

    private LicenseModuleAssignment CreateAssignment(LicenseModuleDefinition definition, LicenseUser user)
    {
        var suffix = BuildSuffix(user);
        var keyBase = string.IsNullOrWhiteSpace(definition.DefaultKey)
            ? $"MODULE-{definition.Id.ToUpperInvariant()}"
            : definition.DefaultKey;
        var usageBase = string.IsNullOrWhiteSpace(definition.DefaultUsageId)
            ? $"{definition.Id.ToUpperInvariant()}-USAGE"
            : definition.DefaultUsageId;

        return new LicenseModuleAssignment
        {
            ModuleId = definition.Id,
            Key = AppendSuffix(keyBase, suffix),
            UsageId = AppendSuffix(usageBase, suffix),
            Status = "ACTIVE",
            PurchaseName = definition.PurchaseName ?? definition.DisplayName,
            Expires = user.CoreLicense?.Expires > 0
                ? user.CoreLicense.Expires
                : DateTimeOffset.UtcNow.AddYears(1).ToUnixTimeSeconds()
        };
    }

    protected override void Dispose(bool disposing)
    {
        if (disposing)
        {
            _logger.EntryWritten -= OnLogEntryWritten;
        }

        base.Dispose(disposing);
    }

    private sealed class ModuleItemContext
    {
        public ModuleItemContext(LicenseModuleDefinition definition, LicenseModuleAssignment? assignment)
        {
            Definition = definition;
            Assignment = assignment;
        }

        public LicenseModuleDefinition Definition { get; }

        public LicenseModuleAssignment? Assignment { get; set; }
    }
}
