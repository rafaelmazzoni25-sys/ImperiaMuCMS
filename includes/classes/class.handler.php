<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Handler
{
    private $_dB = NULL;
    private $_dB2 = NULL;
    public function __construct(dB $dB, dB $dB2 = NULL)
    {
        $this->_dB = $dB;
        $this->_dB2 = check_value($dB2) ? $dB2 : NULL;
        $this->loadInfo();
    }
    private function loadInfo()
    {
        if (!check_value($_GET["dev"])) {
            return NULL;
        }
        if ($_GET["dev"] != "ok") {
            return NULL;
        }
        debug("version: 1.0.0");
        debug("files: " . config("server_files", true));
        debug("plugins: " . config("plugins_system_enable", true));
    }
    public function loadPage()
    {
        global $config;
        global $lang;
        global $custom;
        global $common;
        global $tSettings;
        $handler = $this;
        $dB = $this->_dB;
        $dB2 = $this->_dB2;
        $this->loadLanguage();
        if (defined("access") && access) {
            if (!$this->templateExists($config["website_template"])) {
                throw new Exception("The chosen template cannot be loaded (" . $config["website_template"] . ").");
            }
            include __PATH_TEMPLATES__ . $config["website_template"] . "/index.php";
            if (isLoggedIn() && canAccessAdminCP($_SESSION["username"])) {
                echo "<a href=\"" . __PATH_ADMINCP_HOME__ . "\" class=\"admincp-button\" target=\"_blank\">AdminCP</a>";
            }
            if (isLoggedIn() && canAccessGMCP($_SESSION["username"])) {
                echo "<a href=\"" . __PATH_GMCP_HOME__ . "\" class=\"gmcp-button\" target=\"_blank\">GMCP</a>";
            }
        }
    }
    private function languageExists($language)
    {
        if (file_exists(__PATH_LANGUAGES__ . $language . "/language.php")) {
            return true;
        }
        return false;
    }
    private function templateExists($template)
    {
        if (file_exists(__PATH_TEMPLATES__ . $template . "/index.php")) {
            return true;
        }
        return false;
    }
    private function loadLanguage()
    {
        global $config;
        global $lang;
        $loadLanguage = check_value($_SESSION["language_display"]) ? $_SESSION["language_display"] : $config["language_default"];
        $loadLanguage = config("language_switch_active", true) ? $loadLanguage : $config["language_default"];
        if (!$this->languageExists($loadLanguage)) {
            throw new Exception("The chosen language cannot be loaded (" . $loadLanguage . ").");
        }
        include __PATH_LANGUAGES__ . $loadLanguage . "/language.php";
    }
    public function loadModule($page = "news", $subpage = "home")
    {
        global $config;
        global $lang;
        global $custom;
        global $common;
        global $mconfig;
        global $tSettings;
        $handler = $this;
        $dB = $this->_dB;
        $dB2 = $this->_dB2;
        $page = $this->cleanRequest($page);
        $subpage = $this->cleanRequest($subpage);
        $this->loadLanguage();
        $request = explode("/", $_GET["request"]);
        if (is_array($request)) {
            $i = 0;
            while ($i < count($request)) {
                if (check_value($request[$i])) {
                    if (check_value($request[$i + 1])) {
                        $_GET[$request[$i]] = filter_var($request[$i + 1], FILTER_SANITIZE_STRING);
                    } else {
                        $_GET[$request[$i]] = NULL;
                    }
                }
                $i++;
                $i++;
            }
        }
        if (!check_value($page)) {
            $page = "news";
        }
        if (!check_value($subpage)) {
            if ($this->moduleExists($page)) {
                @loadModuleConfigs($page);
                include __PATH_MODULES__ . $page . ".php";
            } else {
                $this->module404();
            }
        } else {
            switch ($page) {
                case "news":
                    if ($this->moduleExists($page)) {
                        @loadModuleConfigs($page);
                        include __PATH_MODULES__ . $page . ".php";
                    } else {
                        $this->module404();
                    }
                    break;
                default:
                    $path = $page . "/" . $subpage;
                    if ($this->moduleExists($path)) {
                        $cnf = $page . "." . $subpage;
                        @loadModuleConfigs($cnf);
                        include __PATH_MODULES__ . $path . ".php";
                    } else {
                        $this->module404();
                    }
            }
        }
    }
    private function cleanRequest($string)
    {
        return preg_replace("/[^a-zA-Z0-9\\s\\/\\-\\_]/", "", $string);
    }
    private function moduleExists($page)
    {
        if (file_exists(__PATH_MODULES__ . $page . ".php")) {
            return true;
        }
        return false;
    }
    private function module404()
    {
        $errorPage = file_get_contents(__PATH_INCLUDES__ . "error.html");
        echo str_replace("{ERROR_MESSAGE}", "404", $errorPage);
        exit;
    }
    public function loadAdminCPModule($module = "home")
    {
        global $config;
        global $custom;
        global $common;
        global $handler;
        global $mconfig;
        global $gconfig;
        $dB = $this->_dB;
        $dB2 = $this->_dB2;
        $module = check_value($module) ? $module : "home";
        if ($this->admincpmoduleExists($module)) {
            $adminAccessLevel = config("admins", true);
            $accessLevel = $adminAccessLevel[$_SESSION["username"]];
            $modulesAccessLevel = config("admincp_modules_access", true);
            if (is_array($modulesAccessLevel)) {
                $moduleCheck = $module . ".php";
                if (array_key_exists($moduleCheck, $modulesAccessLevel)) {
                    if ($modulesAccessLevel[$moduleCheck] <= $accessLevel) {
                        include __PATH_ADMINCP_MODULES__ . $module . ".php";
                    } else {
                        message("error", "You do not have access to this module.");
                    }
                } else {
                    if (array_key_exists($module, $modulesAccessLevel)) {
                        if ($modulesAccessLevel[$module] <= $accessLevel) {
                            include __PATH_ADMINCP_MODULES__ . $module . ".php";
                        } else {
                            message("error", "You do not have access to this module.");
                        }
                    } else {
                        include __PATH_ADMINCP_MODULES__ . $module . ".php";
                    }
                }
            }
        } else {
            message("error", "INVALID MODULE");
        }
    }
    private function admincpmoduleExists($page)
    {
        if (file_exists(__PATH_ADMINCP_MODULES__ . $page . ".php")) {
            return true;
        }
        return false;
    }
    public function loadGMCPModule($module = "home")
    {
        global $config;
        global $custom;
        global $common;
        global $handler;
        global $mconfig;
        global $gconfig;
        $dB = $this->_dB;
        $dB2 = $this->_dB2;
        $module = check_value($module) ? $module : "home";
        if ($this->gmcpmoduleExists($module)) {
            $gmAccessLevel = config("gamemasters", true);
            $accessLevel = $gmAccessLevel[$_SESSION["username"]];
            $modulesAccessLevel = config("gmcp_modules_access", true);
            if (is_array($modulesAccessLevel)) {
                $moduleCheck = $module . ".php";
                if (array_key_exists($moduleCheck, $modulesAccessLevel)) {
                    if ($modulesAccessLevel[$moduleCheck] <= $accessLevel) {
                        include __PATH_GMCP_MODULES__ . $module . ".php";
                    } else {
                        message("error", "You do not have access to this module.");
                    }
                } else {
                    if (array_key_exists($module, $modulesAccessLevel)) {
                        if ($modulesAccessLevel[$module] <= $accessLevel) {
                            include __PATH_GMCP_MODULES__ . $module . ".php";
                        } else {
                            message("error", "You do not have access to this module.");
                        }
                    } else {
                        include __PATH_GMCP_MODULES__ . $module . ".php";
                    }
                }
            }
        } else {
            message("error", "INVALID MODULE");
        }
    }
    private function gmcpmoduleExists($page)
    {
        if (file_exists(__PATH_GMCP_MODULES__ . $page . ".php")) {
            return true;
        }
        return false;
    }
    public function printHeader()
    {
        $meta = ["<meta charset=\"utf-8\" />", $this->displayTitle(), "<meta name=\"generator\" content=\"ImperiaMuCMS " . __IMPERIAMUCMS_VERSION__ . "\" />", "<meta name=\"description\" content=\"" . config("website_meta_description", true) . "\" />", "<meta name=\"keywords\" content=\"" . config("website_meta_keywords", true) . "\" />", "<link rel=\"shortcut icon\" href=\"" . __PATH_TEMPLATE__ . "favicon.ico\" />"];
        return "\n" . implode("\n", $meta);
    }
    private function displayTitle()
    {
        if ($_REQUEST["subpage"] == NULL) {
            if (lang("breadcrumb_" . $_REQUEST["page"], true) != NULL) {
                return "<title>" . lang("website_title_alt", true) . lang("breadcrumb_" . $_REQUEST["page"], true) . "</title>";
            }
            return "<title>" . lang("website_title_alt", true) . ucwords(str_replace("_", " ", str_replace("-", " ", $_REQUEST["page"]))) . "</title>";
        }
        if (lang("breadcrumb_" . $_REQUEST["page"], true) != NULL && lang("breadcrumb_" . $_REQUEST["page"] . "_" . $_REQUEST["subpage"], true) != NULL) {
            if ($_REQUEST["page"] == "donation" && $_REQUEST["subpage"] == "manualdonation") {
                $gateway = substr($_REQUEST["request"], strpos($_REQUEST["request"], "/") + 1);
                return "<title>" . lang("website_title_alt", true) . lang("breadcrumb_" . $_REQUEST["page"], true) . " - " . ucwords($gateway) . "</title>";
            }
            return "<title>" . lang("website_title_alt", true) . lang("breadcrumb_" . $_REQUEST["page"], true) . " - " . lang("breadcrumb_" . $_REQUEST["page"] . "_" . $_REQUEST["subpage"], true) . "</title>";
        }
        if (lang("breadcrumb_" . $_REQUEST["page"], true) != NULL) {
            return "<title>" . lang("website_title_alt", true) . lang("breadcrumb_" . $_REQUEST["page"], true) . " - " . ucwords(str_replace("_", " ", str_replace("-", " ", $_REQUEST["subpage"]))) . "</title>";
        }
        if (lang("breadcrumb_" . $_REQUEST["page"] . "_" . $_REQUEST["subpage"], true) != NULL) {
            return "<title>" . lang("website_title_alt", true) . ucwords(str_replace("_", " ", str_replace("-", " ", $_REQUEST["page"]))) . " - " . lang("breadcrumb_" . $_REQUEST["page"] . "_" . $_REQUEST["subpage"], true) . "</title>";
        }
    }
    public function switchLanguage($language)
    {
        if (!check_value($language)) {
            return NULL;
        }
        if (!$this->languageExists($language)) {
            return NULL;
        }
        $_SESSION["language_display"] = $language;
        return true;
    }
    public function imperiamucmsPowered()
    {
        $General = new xGeneral();
        if (!$General->isCopyrightRemoval()) {
            echo "<style>\r\n            .footer-holder {\r\n                width: 100%;\r\n                height: 124px;\r\n                margin: 0px 0 0 0\r\n            }\r\n    \r\n            .bot-foot-border {\r\n                width: 100%;\r\n                height: 50px;\r\n                position: absolute;\r\n                top: 102px;\r\n                background: #0f0c0b;\r\n                box-shadow: 0 0 3px rgba(0, 0, 0, 1), 0 0 0 1px rgba(0, 0, 0, 1), inset 0 0 6px rgba(0, 0, 0, .7), inset 0 0 3px rgba(255, 255, 255, .2);\r\n                z-index: 1;\r\n                text-align: center;\r\n                -webkit-box-sizing: border-box;\r\n                -moz-box-sizing: border-box;\r\n                box-sizing: border-box;\r\n                padding: 7px 0 0 0;\r\n                font-family: 'Ebrima';\r\n                font-size: 11px;\r\n                font-weight: bold;\r\n                color: #4a4035;\r\n                text-transform: uppercase;\r\n                text-shadow: 0 0 5px rgba(0, 0, 0, .5), 1px 1px 1px rgba(0, 0, 0, .45)\r\n            }\r\n    \r\n            .bot-foot-border a {\r\n                color: #d29f4e;\r\n            }\r\n    \r\n            .bot-foot-border a:hover {\r\n                color: #AFAFAF;\r\n            }\r\n            </style>";
            if (config("show_version", true)) {
                echo "<div style=\"padding:10px;\">" . lang("global_module_12", true) . " <a href=\"" . __IMPERIAMUCMS_LICENSE_SERVER__ . "\" target=\"_blank\">&nbsp;ImperiaMuCMS </a>" . __IMPERIAMUCMS_VERSION__ . "</div>";
            } else {
                echo "<div style=\"padding:10px;\">" . lang("global_module_12", true) . " <a href=\"" . __IMPERIAMUCMS_LICENSE_SERVER__ . "\" target=\"_blank\">&nbsp;ImperiaMuCMS</a></div>";
            }
        }
    }
    public function imperiamucmsPoweredResponsive()
    {
        $General = new xGeneral();
        if (!$General->isCopyrightRemoval()) {
            echo "\r\n            <div class=\"row\">\r\n                <div class=\"col-md-12 imperiamucms-copy\">\r\n                    <span>" . lang("global_module_12", true) . " <a href=\"" . __IMPERIAMUCMS_LICENSE_SERVER__ . "\"><b>ImperiaMuCMS</b></a>";
            if (config("show_version", true)) {
                echo "&nbsp;" . __IMPERIAMUCMS_VERSION__;
            }
            echo "</span>\r\n                </div>\r\n            </div>";
        }
    }
    public function imperiamucmsPoweredLight()
    {
        $General = new xGeneral();
        if (!$General->isCopyrightRemoval()) {
            echo "<style>\r\n            h1.imperiamucms {height:42px;font:normal 12px/1.2 Arial, 'Segoe UI', 'Lucida Sans Unicode', 'Lucida Grande', Tahoma, sans-serif;color:#888;background:#dfdfdf;}\r\n            h1.imperiamucms span {display:block;width:1120px;margin:0 auto;padding:14px 0 0 20px;}\r\n            </style>";
            if (config("show_version", true)) {
                echo "<h1 class=\"imperiamucms\">\r\n                    <span style=\"text-align: center;\">\r\n                        <div>" . lang("global_module_12", true) . " <a href=\"" . __IMPERIAMUCMS_LICENSE_SERVER__ . "\"><b>ImperiaMuCMS</b></a> " . __IMPERIAMUCMS_VERSION__ . "</div>\r\n                    </span>\r\n                </h1>";
            } else {
                echo "<h1 class=\"imperiamucms\">\r\n                    <span style=\"text-align: center;\">\r\n                        <div>" . lang("global_module_12", true) . " <a href=\"" . __IMPERIAMUCMS_LICENSE_SERVER__ . "\"><b>ImperiaMuCMS</b></a></div>\r\n                    </span>\r\n                </h1>";
            }
        }
    }
    public function imperiamucmsPoweredWarforge()
    {
        $General = new xGeneral();
        if (!$General->isCopyrightRemoval()) {
            echo "<style>\r\n            .footer-holder {\r\n                width: 100%;\r\n                height: 124px;\r\n                margin: 0px 0 0 0\r\n            }\r\n    \r\n            .bot-foot-border {\r\n                width: 100%;\r\n                height: 50px;\r\n                top: 102px;\r\n                background: #0f0c0b;\r\n                box-shadow: 0 0 3px rgba(0, 0, 0, 1), 0 0 0 1px rgba(0, 0, 0, 1), inset 0 0 6px rgba(0, 0, 0, .7), inset 0 0 3px rgba(255, 255, 255, .2);\r\n                z-index: 1;\r\n                text-align: center;\r\n                -webkit-box-sizing: border-box;\r\n                -moz-box-sizing: border-box;\r\n                box-sizing: border-box;\r\n                padding: 7px 0 0 0;\r\n                font-family: 'Ebrima';\r\n                font-size: 11px;\r\n                font-weight: bold;\r\n                color: #4a4035;\r\n                text-transform: uppercase;\r\n                text-shadow: 0 0 5px rgba(0, 0, 0, .5), 1px 1px 1px rgba(0, 0, 0, .45)\r\n            }\r\n    \r\n            .bot-foot-border a {\r\n                color: #FF8C00;\r\n            }\r\n    \r\n            .bot-foot-border a:hover {\r\n                color: #AFAFAF;\r\n            }\r\n            </style>";
            if (config("show_version", true)) {
                echo "<div style=\"padding:10px;\">" . lang("global_module_12", true) . " <a href=\"" . __IMPERIAMUCMS_LICENSE_SERVER__ . "\" target=\"_blank\">&nbsp;ImperiaMuCMS </a>" . __IMPERIAMUCMS_VERSION__ . "</div>";
            } else {
                echo "<div style=\"padding:10px;\">" . lang("global_module_12", true) . " <a href=\"" . __IMPERIAMUCMS_LICENSE_SERVER__ . "\" target=\"_blank\">&nbsp;ImperiaMuCMS</a></div>";
            }
        }
    }
    private function usercpmoduleExists($page)
    {
        if (file_exists(__PATH_MODULES_USERCP__ . $page . ".php")) {
            return true;
        }
        return false;
    }
}

?>