namespace LicenseServer;

using System.Drawing;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Text.Json;
using System.Windows.Forms;

public sealed class MainForm : Form
{
    private readonly string _configPath;
    private readonly LicenseStore _store;
    private LicenseConfig _config;

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

    public MainForm(string configPath, LicenseConfig config, LicenseStore store)
    {
        _configPath = configPath;
        _config = config;
        _store = store;

        Text = "ImperiaMuCMS License Server";
        MinimumSize = new Size(1100, 720);
        StartPosition = FormStartPosition.CenterScreen;

        InitializeLayout();
        LoadConfigurationIntoForm();
        PopulateUsers();

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
        _usersList.SelectedIndexChanged += OnSelectedUserChanged;

        _addUserButton.Text = "Adicionar";
        _addUserButton.AutoSize = true;
        _addUserButton.Click += (_, _) => AddUser();

        _removeUserButton.Text = "Remover";
        _removeUserButton.AutoSize = true;
        _removeUserButton.Click += (_, _) => RemoveUser();

        var leftButtons = new FlowLayoutPanel
        {
            Dock = DockStyle.Fill,
            FlowDirection = FlowDirection.LeftToRight,
            AutoSize = true
        };
        leftButtons.Controls.AddRange(new Control[] { _addUserButton, _removeUserButton });

        var leftLayout = new TableLayoutPanel
        {
            Dock = DockStyle.Fill,
            RowCount = 3,
            ColumnCount = 1
        };
        leftLayout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        leftLayout.RowStyles.Add(new RowStyle(SizeType.Percent, 100f));
        leftLayout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        leftLayout.Controls.Add(new Label { Text = "Usuários", Dock = DockStyle.Fill, Padding = new Padding(0, 0, 0, 4) }, 0, 0);
        leftLayout.Controls.Add(_usersList, 0, 1);
        leftLayout.Controls.Add(leftButtons, 0, 2);

        var mainSplit = new SplitContainer
        {
            Dock = DockStyle.Fill,
            SplitterDistance = 260,
            FixedPanel = FixedPanel.Panel1
        };
        mainSplit.Panel1.Controls.Add(leftLayout);

        _userGroup.Text = "Licença principal";
        _modulesGroup.Text = "Módulos";

        ConfigureUserGroup();
        ConfigureModulesGroup();

        var serverGroup = new GroupBox { Text = "Servidor", Dock = DockStyle.Fill };
        ConfigureServerGroup(serverGroup);

        var logGroup = new GroupBox { Text = "Logs", Dock = DockStyle.Fill };
        ConfigureLogGroup(logGroup);

        _saveButton.Text = "Salvar";
        _saveButton.AutoSize = true;
        _saveButton.Enabled = false;
        _saveButton.Click += (_, _) => SaveConfiguration();

        _reloadButton.Text = "Recarregar";
        _reloadButton.AutoSize = true;
        _reloadButton.Click += (_, _) => ReloadConfiguration();

        _restartButton.Text = "Reiniciar servidor";
        _restartButton.AutoSize = true;
        _restartButton.Click += (_, _) => RestartServer();

        var buttonPanel = new FlowLayoutPanel
        {
            Dock = DockStyle.Fill,
            FlowDirection = FlowDirection.LeftToRight,
            AutoSize = true
        };
        buttonPanel.Controls.AddRange(new Control[] { _saveButton, _reloadButton, _restartButton });

        var rightLayout = new TableLayoutPanel
        {
            Dock = DockStyle.Fill,
            ColumnCount = 1,
            RowCount = 5,
            Padding = new Padding(4)
        };
        rightLayout.RowStyles.Add(new RowStyle(SizeType.Absolute, 220));
        rightLayout.RowStyles.Add(new RowStyle(SizeType.Absolute, 240));
        rightLayout.RowStyles.Add(new RowStyle(SizeType.Absolute, 170));
        rightLayout.RowStyles.Add(new RowStyle(SizeType.Percent, 100f));
        rightLayout.RowStyles.Add(new RowStyle(SizeType.AutoSize));

        rightLayout.Controls.Add(_userGroup, 0, 0);
        rightLayout.Controls.Add(_modulesGroup, 0, 1);
        rightLayout.Controls.Add(serverGroup, 0, 2);
        rightLayout.Controls.Add(logGroup, 0, 3);
        rightLayout.Controls.Add(buttonPanel, 0, 4);

        mainSplit.Panel2.Controls.Add(rightLayout);

        _statusLabel.Text = "Pronto";
        _statusStrip.Items.Add(_statusLabel);

        Controls.Add(mainSplit);
        Controls.Add(_statusStrip);

        _statusStrip.Dock = DockStyle.Bottom;

        ResumeLayout(true);
    }

    private void ConfigureUserGroup()
    {
        var layout = new TableLayoutPanel
        {
            Dock = DockStyle.Fill,
            ColumnCount = 2,
            RowCount = 7,
            Padding = new Padding(8)
        };
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Absolute, 160));
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f));

        _nameText.Dock = DockStyle.Fill;
        _nameText.TextChanged += (_, _) => UpdateUserName();

        _identifierText.Dock = DockStyle.Fill;
        _identifierText.TextChanged += (_, _) => UpdateIdentifier();

        _coreKeyText.Dock = DockStyle.Fill;
        _coreKeyText.TextChanged += (_, _) => UpdateCoreKey();

        _coreUsageText.Dock = DockStyle.Fill;
        _coreUsageText.TextChanged += (_, _) => UpdateCoreUsage();

        _coreStatusCombo.Dock = DockStyle.Fill;
        _coreStatusCombo.Items.AddRange(new object[] { "ACTIVE", "INACTIVE", "SUSPENDED" });
        _coreStatusCombo.DropDownStyle = ComboBoxStyle.DropDown;
        _coreStatusCombo.TextChanged += (_, _) => UpdateCoreStatus();

        _coreExpiresPicker.Dock = DockStyle.Fill;
        _coreExpiresPicker.Format = DateTimePickerFormat.Custom;
        _coreExpiresPicker.CustomFormat = "dd/MM/yyyy HH:mm";
        _coreExpiresPicker.MinDate = new DateTime(2000, 1, 1);
        _coreExpiresPicker.MaxDate = new DateTime(2100, 12, 31);
        _coreExpiresPicker.ValueChanged += (_, _) => UpdateCoreExpires();

        _corePurchaseNameText.Dock = DockStyle.Fill;
        _corePurchaseNameText.TextChanged += (_, _) => UpdateCorePurchaseName();

        _coreCustomFieldsText.Dock = DockStyle.Fill;
        _coreCustomFieldsText.Multiline = true;
        _coreCustomFieldsText.ScrollBars = ScrollBars.Vertical;
        _coreCustomFieldsText.Height = 80;
        _coreCustomFieldsText.TextChanged += (_, _) => UpdateCoreCustomFields();

        layout.Controls.Add(new Label { Text = "Nome", AutoSize = true, TextAlign = ContentAlignment.MiddleLeft }, 0, 0);
        layout.Controls.Add(_nameText, 1, 0);
        layout.Controls.Add(new Label { Text = "Identificador / Email", AutoSize = true, TextAlign = ContentAlignment.MiddleLeft }, 0, 1);
        layout.Controls.Add(_identifierText, 1, 1);
        layout.Controls.Add(new Label { Text = "License Key", AutoSize = true, TextAlign = ContentAlignment.MiddleLeft }, 0, 2);
        layout.Controls.Add(_coreKeyText, 1, 2);
        layout.Controls.Add(new Label { Text = "Usage ID", AutoSize = true, TextAlign = ContentAlignment.MiddleLeft }, 0, 3);
        layout.Controls.Add(_coreUsageText, 1, 3);
        layout.Controls.Add(new Label { Text = "Status", AutoSize = true, TextAlign = ContentAlignment.MiddleLeft }, 0, 4);
        layout.Controls.Add(_coreStatusCombo, 1, 4);
        layout.Controls.Add(new Label { Text = "Expira em", AutoSize = true, TextAlign = ContentAlignment.MiddleLeft }, 0, 5);
        layout.Controls.Add(_coreExpiresPicker, 1, 5);
        layout.Controls.Add(new Label { Text = "Nome da compra", AutoSize = true, TextAlign = ContentAlignment.MiddleLeft }, 0, 6);
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
        layout.Controls.Add(new Label { Text = "Campos personalizados (um por linha)", AutoSize = true, TextAlign = ContentAlignment.MiddleLeft }, 0, 7);
        layout.Controls.Add(_coreCustomFieldsText, 1, 7);
        TableLayoutPanel.SetColumnSpan(_coreCustomFieldsText, 1);

        _userGroup.Dock = DockStyle.Fill;
        _userGroup.Controls.Add(layout);
    }

    private void ConfigureModulesGroup()
    {
        var split = new SplitContainer
        {
            Dock = DockStyle.Fill,
            SplitterDistance = 320
        };

        _modulesList.Dock = DockStyle.Fill;
        _modulesList.View = View.Details;
        _modulesList.CheckBoxes = true;
        _modulesList.FullRowSelect = true;
        _modulesList.HideSelection = false;
        _modulesList.HeaderStyle = ColumnHeaderStyle.Nonclickable;
        _modulesList.Columns.Add("Módulo", 180);
        _modulesList.Columns.Add("Chave", 120);
        _modulesList.ItemCheck += OnModuleItemCheck;
        _modulesList.SelectedIndexChanged += OnSelectedModuleChanged;

        split.Panel1.Controls.Add(_modulesList);

        var layout = new TableLayoutPanel
        {
            Dock = DockStyle.Fill,
            ColumnCount = 2,
            Padding = new Padding(8)
        };
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Absolute, 160));
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f));

        _moduleKeyText.Dock = DockStyle.Fill;
        _moduleKeyText.TextChanged += (_, _) => UpdateModuleKey();

        _moduleUsageText.Dock = DockStyle.Fill;
        _moduleUsageText.TextChanged += (_, _) => UpdateModuleUsage();

        _moduleStatusCombo.Dock = DockStyle.Fill;
        _moduleStatusCombo.Items.AddRange(new object[] { "ACTIVE", "INACTIVE", "SUSPENDED" });
        _moduleStatusCombo.DropDownStyle = ComboBoxStyle.DropDown;
        _moduleStatusCombo.TextChanged += (_, _) => UpdateModuleStatus();

        _moduleExpiresPicker.Dock = DockStyle.Fill;
        _moduleExpiresPicker.Format = DateTimePickerFormat.Custom;
        _moduleExpiresPicker.CustomFormat = "dd/MM/yyyy HH:mm";
        _moduleExpiresPicker.MinDate = new DateTime(2000, 1, 1);
        _moduleExpiresPicker.MaxDate = new DateTime(2100, 12, 31);
        _moduleExpiresPicker.ValueChanged += (_, _) => UpdateModuleExpires();

        _modulePurchaseNameText.Dock = DockStyle.Fill;
        _modulePurchaseNameText.TextChanged += (_, _) => UpdateModulePurchaseName();

        _moduleCustomFieldsText.Dock = DockStyle.Fill;
        _moduleCustomFieldsText.Multiline = true;
        _moduleCustomFieldsText.ScrollBars = ScrollBars.Vertical;
        _moduleCustomFieldsText.Height = 80;
        _moduleCustomFieldsText.TextChanged += (_, _) => UpdateModuleCustomFields();

        layout.RowStyles.Clear();
        for (var i = 0; i < 6; i++)
        {
            layout.RowStyles.Add(new RowStyle(SizeType.AutoSize));
        }
        layout.RowStyles.Add(new RowStyle(SizeType.Percent, 100f));

        layout.Controls.Add(new Label { Text = "Chave", AutoSize = true }, 0, 0);
        layout.Controls.Add(_moduleKeyText, 1, 0);
        layout.Controls.Add(new Label { Text = "Usage ID", AutoSize = true }, 0, 1);
        layout.Controls.Add(_moduleUsageText, 1, 1);
        layout.Controls.Add(new Label { Text = "Status", AutoSize = true }, 0, 2);
        layout.Controls.Add(_moduleStatusCombo, 1, 2);
        layout.Controls.Add(new Label { Text = "Expira em", AutoSize = true }, 0, 3);
        layout.Controls.Add(_moduleExpiresPicker, 1, 3);
        layout.Controls.Add(new Label { Text = "Nome da compra", AutoSize = true }, 0, 4);
        layout.Controls.Add(_modulePurchaseNameText, 1, 4);
        layout.Controls.Add(new Label { Text = "Campos personalizados", AutoSize = true }, 0, 5);
        layout.Controls.Add(_moduleCustomFieldsText, 1, 5);

        split.Panel2.Controls.Add(layout);

        _modulesGroup.Dock = DockStyle.Fill;
        _modulesGroup.Controls.Add(split);
    }

    private void ConfigureServerGroup(GroupBox group)
    {
        var layout = new TableLayoutPanel
        {
            Dock = DockStyle.Fill,
            ColumnCount = 2,
            Padding = new Padding(8)
        };
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Absolute, 160));
        layout.ColumnStyles.Add(new ColumnStyle(SizeType.Percent, 100f));

        _prefixesText.Dock = DockStyle.Fill;
        _prefixesText.Multiline = true;
        _prefixesText.ScrollBars = ScrollBars.Vertical;
        _prefixesText.TextChanged += (_, _) => MarkDirty();

        _defaultFieldsText.Dock = DockStyle.Fill;
        _defaultFieldsText.Multiline = true;
        _defaultFieldsText.ScrollBars = ScrollBars.Vertical;
        _defaultFieldsText.TextChanged += (_, _) => MarkDirty();

        layout.RowStyles.Add(new RowStyle(SizeType.Percent, 50f));
        layout.RowStyles.Add(new RowStyle(SizeType.Percent, 50f));

        layout.Controls.Add(new Label { Text = "URLs (um por linha)", AutoSize = true }, 0, 0);
        layout.Controls.Add(_prefixesText, 1, 0);
        layout.Controls.Add(new Label { Text = "Campos padrão (um por linha)", AutoSize = true }, 0, 1);
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

        group.Controls.Add(_logText);
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
        _config.Users.Remove(_selectedUser);
        PopulateUsers();

        if (_usersList.Items.Count > 0)
        {
            _usersList.SelectedIndex = Math.Min(index, _usersList.Items.Count - 1);
        }

        MarkDirty();
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
            UpdateStatus("Configuração salva.");

            RestartServer();
        }
        catch (Exception ex)
        {
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
            UpdateStatus("Configuração recarregada.");
        }
        catch (Exception ex)
        {
            MessageBox.Show($"Falha ao recarregar: {ex.Message}", "Erro", MessageBoxButtons.OK, MessageBoxIcon.Error);
        }
    }

    private void StartServer()
    {
        StopServer();

        try
        {
            _server = new LicenseHttpServer(_config.Prefixes, _store, LogMessage);
            _serverCts = new CancellationTokenSource();
            _activePrefixes.Clear();
            _activePrefixes.AddRange(_config.Prefixes);
            _serverTask = _server.RunAsync(_serverCts.Token);
            _serverTask.ContinueWith(t =>
            {
                if (t.Exception != null)
                {
                    LogMessage($"Servidor finalizado: {t.Exception.InnerException?.Message ?? t.Exception.Message}");
                }
            }, TaskScheduler.Default);
            UpdateStatus("Servidor iniciado.");
        }
        catch (Exception ex)
        {
            LogMessage($"Falha ao iniciar servidor: {ex.Message}");
            UpdateStatus("Falha ao iniciar servidor.");
        }
    }

    private void RestartServer()
    {
        StopServer();
        StartServer();
    }

    private void StopServer()
    {
        try
        {
            _serverCts?.Cancel();
            _server?.Stop();
        }
        catch
        {
            // ignore
        }
        finally
        {
            _server = null;
            _serverCts?.Dispose();
            _serverCts = null;
            _serverTask = null;
        }
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

        StopServer();
    }

    private void LogMessage(string message)
    {
        if (InvokeRequired)
        {
            BeginInvoke(new Action<string>(LogMessage), message);
            return;
        }

        var text = $"[{DateTime.Now:HH:mm:ss}] {message}{Environment.NewLine}";
        _logText.AppendText(text);
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
