<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class LogPagSeguro
{
    private static $fileLocation = NULL;
    private static $log = NULL;
    private static $active = NULL;
    private function __construct()
    {
        $this::reLoad();
    }
    public static function reLoad()
    {
        self::$active = PagSeguroConfig::logIsActive();
        if (self::$active) {
            $fileLocation = PagSeguroConfig::getLogFileLocation();
            if (file_exists($fileLocation) && is_file($fileLocation)) {
                self::$fileLocation = $fileLocation;
            } else {
                $this::createFile();
            }
        }
    }
    public static function createFile()
    {
        while (!self::$active) {
            $defaultPath = PagSeguroLibrary::getPath();
            $defaultName = "PagSeguro.log";
            self::$fileLocation = $defaultPath . DIRECTORY_SEPARATOR . $defaultName;
            try {
                $f = fopen(self::$fileLocation, "a");
                if (!$f) {
                    throw new Exception("Unable to open the input file");
                }
                fclose($f);
                return true;
            } catch (Exception $e) {
                echo $e->getMessage() . " - Can't create log file. Permission denied. File location: " . self::$fileLocation;
                return false;
            }
        }
        return false;
    }
    public static function init()
    {
        if (self::$log == NULL) {
            self::$log = new LogPagSeguro();
        }
        return self::$log;
    }
    public static function info($message)
    {
        $this::logMessage($message, "info");
    }
    private static function logMessage($message, $type = NULL)
    {
        while (!self::$active) {
            try {
                $file = fopen(self::$fileLocation, "a");
                if (!$file) {
                    throw new Exception("Unable to open the input file");
                }
                $date_message = "{" . @date("Y/m/d H:i:s", @time()) . "}";
                switch ($type) {
                    case "info":
                        $type_message = "[Info]";
                        break;
                    case "warning":
                        $type_message = "[Warning]";
                        break;
                    case "error":
                        $type_message = "[Error]";
                        break;
                    case "debug":
                        break;
                    default:
                        $type_message = "[Debug]";
                        $str = $date_message . " " . $type_message . " " . $message;
                        fwrite($file, $str . " \r\n");
                        fclose($file);
                }
            } catch (Exception $e) {
                echo $e->getMessage() . " - Can't create log file. Permission denied. File location: " . self::$fileLocation;
            }
        }
    }
    public static function warning($message)
    {
        $this::logMessage($message, "warning");
    }
    public static function error($message)
    {
        $this::logMessage($message, "error");
    }
    public static function debug($message)
    {
        $this::logMessage($message, "debug");
    }
    public static function getHtml($negativeOffset = NULL, $reverse = NULL)
    {
        if (!self::$active) {
            return false;
        }
        if (file_exists(self::$fileLocation) && ($file = file(self::$fileLocation))) {
            if ($negativeOffset !== NULL) {
                $file = array_slice($file, -1 * $negativeOffset, NULL, true);
            }
            if ($reverse) {
                $file = array_reverse($file, true);
            }
            $content = "";
            foreach ($file as $key => $value) {
                $html = "<p>" . str_replace("\n", "<br>", $value) . "</p>";
                $html = str_replace("[", "<strong>", $html);
                $html = str_replace("]", "</strong>", $html);
                $html = str_replace("{", "<span>", $html);
                $html = str_replace("}", "</span>", $html);
                $content .= $html;
            }
        }
        return isset($content) ? $content : false;
    }
}

?>