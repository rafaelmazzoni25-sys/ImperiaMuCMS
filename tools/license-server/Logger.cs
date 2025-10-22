namespace LicenseServer;

using System;
using System.Collections.Generic;
using System.Globalization;
using System.IO;
using System.Linq;
using System.Text;

public enum LogLevel
{
    Trace = 0,
    Debug = 1,
    Information = 2,
    Warning = 3,
    Error = 4,
    Critical = 5
}

public sealed class LogEntry
{
    public LogEntry(
        DateTimeOffset timestamp,
        LogLevel level,
        string category,
        string message,
        Exception? exception,
        IReadOnlyDictionary<string, string?> metadata)
    {
        Timestamp = timestamp;
        Level = level;
        Category = category;
        Message = message;
        Exception = exception;
        Metadata = metadata;
    }

    public DateTimeOffset Timestamp { get; }

    public LogLevel Level { get; }

    public string Category { get; }

    public string Message { get; }

    public Exception? Exception { get; }

    public IReadOnlyDictionary<string, string?> Metadata { get; }

    public string ToDisplayString()
    {
        var builder = new StringBuilder();
        builder.Append('[').Append(Timestamp.LocalDateTime.ToString("HH:mm:ss", CultureInfo.InvariantCulture)).Append("] ");
        builder.Append('[').Append(GetLevelDisplayName(Level)).Append(']');

        if (!string.IsNullOrWhiteSpace(Category))
        {
            builder.Append('[').Append(Category).Append(']');
        }

        builder.Append(' ').Append(Message);

        if (Metadata.Count > 0)
        {
            builder.Append(" { ");
            var isFirst = true;
            foreach (var pair in Metadata)
            {
                if (!isFirst)
                {
                    builder.Append(", ");
                }

                builder.Append(pair.Key).Append('=').Append(pair.Value);
                isFirst = false;
            }

            builder.Append(" }");
        }

        if (Exception is not null)
        {
            builder.Append(" :: ").Append(Exception.GetType().Name).Append(':').Append(' ').Append(Exception.Message);
        }

        builder.AppendLine();
        return builder.ToString();
    }

    public string ToFileString()
    {
        var builder = new StringBuilder();
        builder.Append('[').Append(Timestamp.ToString("O", CultureInfo.InvariantCulture)).Append("] ");
        builder.Append('[').Append(GetLevelDisplayName(Level)).Append(']');

        if (!string.IsNullOrWhiteSpace(Category))
        {
            builder.Append('[').Append(Category).Append(']');
        }

        builder.Append(' ').Append(Message);

        if (Metadata.Count > 0)
        {
            builder.Append(" { ");
            var isFirst = true;
            foreach (var pair in Metadata)
            {
                if (!isFirst)
                {
                    builder.Append(", ");
                }

                builder.Append(pair.Key).Append('=').Append(pair.Value);
                isFirst = false;
            }

            builder.Append(" }");
        }

        return builder.ToString();
    }

    private static string GetLevelDisplayName(LogLevel level)
        => level switch
        {
            LogLevel.Trace => "TRACE",
            LogLevel.Debug => "DEBUG",
            LogLevel.Information => "INFO",
            LogLevel.Warning => "WARN",
            LogLevel.Error => "ERROR",
            LogLevel.Critical => "CRITICAL",
            _ => level.ToString().ToUpperInvariant()
        };
}

public sealed class LogEntryEventArgs : EventArgs
{
    public LogEntryEventArgs(LogEntry entry)
    {
        Entry = entry;
    }

    public LogEntry Entry { get; }
}

internal interface ILogSink
{
    void Write(LogEntry entry);
}

internal sealed class FileLogSink : ILogSink, IDisposable
{
    private readonly object _syncRoot = new();
    private readonly StreamWriter _writer;

    public FileLogSink(string filePath)
    {
        Directory.CreateDirectory(Path.GetDirectoryName(filePath)!);
        _writer = new StreamWriter(new FileStream(filePath, FileMode.Append, FileAccess.Write, FileShare.Read))
        {
            AutoFlush = true
        };
    }

    public void Write(LogEntry entry)
    {
        lock (_syncRoot)
        {
            _writer.WriteLine(entry.ToFileString());
            if (entry.Exception is not null)
            {
                _writer.WriteLine(entry.Exception);
            }
        }
    }

    public void Dispose()
    {
        lock (_syncRoot)
        {
            _writer.Dispose();
        }
    }
}

public sealed class Logger : IDisposable
{
    private readonly object _syncRoot = new();
    private readonly List<LogEntry> _entries = new();
    private readonly List<ILogSink> _sinks = new();

    public Logger(int maxEntries = 5000)
    {
        MaxEntries = Math.Max(100, maxEntries);
    }

    public int MaxEntries { get; }

    public event EventHandler<LogEntryEventArgs>? EntryWritten;

    public void RegisterSink(ILogSink sink)
    {
        if (sink is null)
        {
            throw new ArgumentNullException(nameof(sink));
        }

        lock (_syncRoot)
        {
            _sinks.Add(sink);
        }
    }

    public IReadOnlyList<LogEntry> GetEntries()
    {
        lock (_syncRoot)
        {
            return _entries.ToArray();
        }
    }

    public void Log(
        LogLevel level,
        string message,
        string category = "Geral",
        Exception? exception = null,
        IReadOnlyDictionary<string, string?>? metadata = null)
    {
        if (string.IsNullOrWhiteSpace(message))
        {
            return;
        }

        var metadataSnapshot = metadata is null
            ? new Dictionary<string, string?>(StringComparer.OrdinalIgnoreCase)
            : new Dictionary<string, string?>(metadata, StringComparer.OrdinalIgnoreCase);

        var entry = new LogEntry(DateTimeOffset.Now, level, category, message, exception, metadataSnapshot);

        List<ILogSink> sinksSnapshot;
        EventHandler<LogEntryEventArgs>? handler;

        lock (_syncRoot)
        {
            _entries.Add(entry);
            if (_entries.Count > MaxEntries)
            {
                var removeCount = _entries.Count - MaxEntries;
                _entries.RemoveRange(0, removeCount);
            }

            sinksSnapshot = _sinks.ToList();
            handler = EntryWritten;
        }

        foreach (var sink in sinksSnapshot)
        {
            sink.Write(entry);
        }

        handler?.Invoke(this, new LogEntryEventArgs(entry));
    }

    public void LogTrace(string message, string category = "Geral", IReadOnlyDictionary<string, string?>? metadata = null)
        => Log(LogLevel.Trace, message, category, null, metadata);

    public void LogDebug(string message, string category = "Geral", IReadOnlyDictionary<string, string?>? metadata = null)
        => Log(LogLevel.Debug, message, category, null, metadata);

    public void LogInformation(string message, string category = "Geral", IReadOnlyDictionary<string, string?>? metadata = null)
        => Log(LogLevel.Information, message, category, null, metadata);

    public void LogWarning(string message, string category = "Geral", IReadOnlyDictionary<string, string?>? metadata = null)
        => Log(LogLevel.Warning, message, category, null, metadata);

    public void LogError(string message, string category = "Geral", Exception? exception = null, IReadOnlyDictionary<string, string?>? metadata = null)
        => Log(LogLevel.Error, message, category, exception, metadata);

    public void LogCritical(string message, string category = "Geral", Exception? exception = null, IReadOnlyDictionary<string, string?>? metadata = null)
        => Log(LogLevel.Critical, message, category, exception, metadata);

    public void Dispose()
    {
        List<ILogSink> sinksSnapshot;

        lock (_syncRoot)
        {
            sinksSnapshot = _sinks.ToList();
            _sinks.Clear();
            _entries.Clear();
        }

        foreach (var sink in sinksSnapshot)
        {
            if (sink is IDisposable disposable)
            {
                disposable.Dispose();
            }
        }
    }
}
