<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "<h2>Template Settings</h2>";
if ($config["website_template"] == "imperiamucms") {
    function saveChanges()
    {
        foreach ($_POST as $setting) {
            if (!check_value($setting)) {
                message("error", "Missing data (complete all fields).");
                return NULL;
            }
        }
        $xmlPath = __PATH_MODULE_CONFIGS__ . "template.config.xml";
        $xml = simplexml_load_file($xmlPath);
        $xml->slider = $_POST["slider"];
        $xml->changelogs = $_POST["changelogs"];
        $xml->changelogs_limit = $_POST["changelogs_limit"];
        $xml->characters_rankings = $_POST["characters_rankings"];
        $xml->characters_rankings_default = $_POST["characters_rankings_default"];
        $xml->guilds_rankings = $_POST["guilds_rankings"];
        $xml->server_max_online = $_POST["server_max_online"];
        $xml->countdown_position = $_POST["countdown_position"];
        $save = $xml->asXML($xmlPath);
        if ($save) {
            message("success", "Settings successfully saved.");
        } else {
            message("error", "There has been an error while saving changes.");
        }
    }
    if (check_value($_POST["submit_changes"])) {
        saveChanges();
    }
    loadModuleConfigs("template.config");
    echo "\n    <form action=\"\" method=\"post\">\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\n            <tr>\n                <th>Show Slider<br/><span>Show/hide slider on home page.</span></th>\n                <td>\n                    ";
    enabledisableCheckboxes("slider", mconfig("slider"), "Show", "Hide");
    echo "                </td>\n            </tr>\n            <tr>\n                <th>Show Changeslogs<br/><span>Show/hide changelogs on home page.</span></th>\n                <td>\n                    ";
    enabledisableCheckboxes("changelogs", mconfig("changelogs"), "Show", "Hide");
    echo "                </td>\n            </tr>\n            <tr>\n                <th>Changelogs Limit<br/><span>Limit of changelogs to be displayed on home page.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"changelogs_limit\" value=\"";
    echo mconfig("changelogs_limit");
    echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Show Characters Rankings<br/><span>Show/hide characters rankings on home page.</span></th>\n                <td>\n                    ";
    enabledisableCheckboxes("characters_rankings", mconfig("characters_rankings"), "Show", "Hide");
    echo "                </td>\n            </tr>\n            <tr>\n                <th>Default Characters Rankings<br/><span>Choose default characters rankings on home page.</span></th>\n                <td>\n                    <select name=\"characters_rankings_default\" class=\"form-control\">\n                        ";
    if (mconfig("characters_rankings_default") == "general") {
        echo "<option value=\"general\" selected=\"selected\">General</option>";
    } else {
        echo "<option value=\"general\">General</option>";
    }
    if (mconfig("characters_rankings_default") == "monthly") {
        echo "<option value=\"monthly\" selected=\"selected\">Monthly</option>";
    } else {
        echo "<option value=\"monthly\">Monthly</option>";
    }
    if (mconfig("characters_rankings_default") == "weekly") {
        echo "<option value=\"weekly\" selected=\"selected\">Weekly</option>";
    } else {
        echo "<option value=\"weekly\">Weekly</option>";
    }
    if (mconfig("characters_rankings_default") == "daily") {
        echo "<option value=\"daily\" selected=\"selected\">Daily</option>";
    } else {
        echo "<option value=\"daily\">Daily</option>";
    }
    echo "                    </select>\n                </td>\n            </tr>\n            <tr>\n                <th>Show Guilds Rankings<br/><span>Show/hide guilds rankings on home page.</span></th>\n                <td>\n                    ";
    enabledisableCheckboxes("guilds_rankings", mconfig("guilds_rankings"), "Show", "Hide");
    echo "                </td>\n            </tr>\n            <tr>\n                <th>Max. Online Players<br/><span>Limit of players connected on your server.</span></th>\n                <td>\n                    <input class=\"form-control\" type=\"text\" name=\"server_max_online\" value=\"";
    echo mconfig("server_max_online");
    echo "\"/>\n                </td>\n            </tr>\n            <tr>\n                <th>Countdown Position<br/><span>Applies only if countdown is active.</span></th>\n                <td>\n                    <select name=\"countdown_position\" class=\"form-control\">\n                        ";
    if (mconfig("countdown_position") == "center") {
        echo "<option value=\"center\" selected=\"selected\">Center</option>";
    } else {
        echo "<option value=\"center\">Center</option>";
    }
    if (mconfig("countdown_position") == "left") {
        echo "<option value=\"left\" selected=\"selected\">Left</option>";
    } else {
        echo "<option value=\"left\">Left</option>";
    }
    if (mconfig("countdown_position") == "right") {
        echo "<option value=\"right\" selected=\"selected\">Right</option>";
    } else {
        echo "<option value=\"right\">Right</option>";
    }
    echo "                    </select>\n                </td>\n            </tr>\n            <tr>\n                <td colspan=\"2\">\n                    <input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/>\n                </td>\n            </tr>\n        </table>\n    </form>\n\n    ";
} else {
    message("error", "Template Settings function is available only for \"imperiamucms\" template.");
}

?>