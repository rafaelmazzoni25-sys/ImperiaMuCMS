<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("arkawar")) {
    echo "    <h2>Arka War Settings</h2>\r\n    ";
    function saveChanges()
    {
        
        foreach ($_POST as $setting) {
            if (!check_value($setting)) {
                message("error", "Missing data (complete all fields).");
                return NULL;
            }
        }
        $xmlPath = __PATH_MODULE_CONFIGS__ . "arkawar.xml";
        $xml = simplexml_load_file($xmlPath);
        if (isset($_POST["monday"])) {
            $_POST["monday"] = 1;
        } else {
            $_POST["monday"] = 0;
        }
        if (isset($_POST["tuesday"])) {
            $_POST["tuesday"] = 1;
        } else {
            $_POST["tuesday"] = 0;
        }
        if (isset($_POST["wednesday"])) {
            $_POST["wednesday"] = 1;
        } else {
            $_POST["wednesday"] = 0;
        }
        if (isset($_POST["thursday"])) {
            $_POST["thursday"] = 1;
        } else {
            $_POST["thursday"] = 0;
        }
        if (isset($_POST["friday"])) {
            $_POST["friday"] = 1;
        } else {
            $_POST["friday"] = 0;
        }
        if (isset($_POST["saturday"])) {
            $_POST["saturday"] = 1;
        } else {
            $_POST["saturday"] = 0;
        }
        if (isset($_POST["sunday"])) {
            $_POST["sunday"] = 1;
        } else {
            $_POST["sunday"] = 0;
        }
        $xml->active = $_POST["active"];
        $xml->monday = $_POST["monday"];
        $xml->tuesday = $_POST["tuesday"];
        $xml->wednesday = $_POST["wednesday"];
        $xml->thursday = $_POST["thursday"];
        $xml->friday = $_POST["friday"];
        $xml->saturday = $_POST["saturday"];
        $xml->sunday = $_POST["sunday"];
        $xml->event_hour = $_POST["event_hour"];
        $xml->event_minute = $_POST["event_minute"];
        $xml->gm_reg = $_POST["gm_reg"];
        $xml->gmemb_reg = $_POST["gmemb_reg"];
        $xml->prog_wait = $_POST["prog_wait"];
        $xml->party_wait = $_POST["party_wait"];
        $xml->battle = $_POST["battle"];
        $xml->channel_close = $_POST["channel_close"];
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
    loadModuleConfigs("arkawar");
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Event Days<br/><span>Use value from Data/Events/ArcaBattle/IGC_ArcaBattle.xml - ActiveDay</span></th>\r\n                <td>\r\n                    ";
    if (mconfig("monday") == 1) {
        $mondayChecked = "checked=\"checked\"";
    }
    if (mconfig("tuesday") == 1) {
        $tuesdayChecked = "checked=\"checked\"";
    }
    if (mconfig("wednesday") == 1) {
        $wednesdayChecked = "checked=\"checked\"";
    }
    if (mconfig("thursday") == 1) {
        $thursdayChecked = "checked=\"checked\"";
    }
    if (mconfig("friday") == 1) {
        $fridayChecked = "checked=\"checked\"";
    }
    if (mconfig("saturday") == 1) {
        $saturdayChecked = "checked=\"checked\"";
    }
    if (mconfig("sunday") == 1) {
        $sundayChecked = "checked=\"checked\"";
    }
    echo "                    <input type=\"checkbox\" name=\"monday\" value=\"1\" ";
    echo $mondayChecked;
    echo "/> Monday\r\n                    <input type=\"checkbox\" name=\"tuesday\" value=\"2\" ";
    echo $tuesdayChecked;
    echo "/> Tuesday\r\n                    <input type=\"checkbox\" name=\"wednesday\" value=\"3\" ";
    echo $wednesdayChecked;
    echo "/> Wednesday\r\n                    <input type=\"checkbox\" name=\"thursday\" value=\"4\" ";
    echo $thursdayChecked;
    echo "/> Thursday\r\n                    <input type=\"checkbox\" name=\"friday\" value=\"5\" ";
    echo $fridayChecked;
    echo "/> Friday\r\n                    <input type=\"checkbox\" name=\"saturday\" value=\"6\" ";
    echo $saturdayChecked;
    echo "/> Saturday\r\n                    <input type=\"checkbox\" name=\"sunday\" value=\"7\" ";
    echo $sundayChecked;
    echo "/> Sunday\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Event Start<br/><span>Use value from Data/Events/ArcaBattle/IGC_ArcaBattle.xml - Schedule</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"event_hour\" value=\"";
    echo mconfig("event_hour");
    echo "\" style=\"display: inline; width: 150px\"/> = Hour<br/>\r\n                    <input class=\"form-control\" type=\"text\" name=\"event_minute\" value=\"";
    echo mconfig("event_minute");
    echo "\" style=\"display: inline; width: 150px\"/> = Minute\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Guild Master Registration Duration<br/><span>Use value from Data/Events/ArcaBattle/IGC_ArcaBattle.xml - MasterRegTime</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"gm_reg\" value=\"";
    echo mconfig("gm_reg");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Guild Members Registration Duration<br/><span>Use value from Data/Events/ArcaBattle/IGC_ArcaBattle.xml - MemberRegTime</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"gmemb_reg\" value=\"";
    echo mconfig("gmemb_reg");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Notice of entry Guilds Duration<br/><span>Use value from Data/Events/ArcaBattle/IGC_ArcaBattle.xml - ProgressWait</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"prog_wait\" value=\"";
    echo mconfig("prog_wait");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Waiting in a Safe Zone Duration<br/><span>Use value from Data/Events/ArcaBattle/IGC_ArcaBattle.xml - PartyWait</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"party_wait\" value=\"";
    echo mconfig("party_wait");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Arka War Battle Duration<br/><span>Use value from Data/Events/ArcaBattle/IGC_ArcaBattle.xml - Duration</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"battle\" value=\"";
    echo mconfig("battle");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Channel Close Duration<br/><span>Use value from Data/Events/ArcaBattle/IGC_ArcaBattle.xml - ChannelClose</span></th>\r\n                <td>\r\n                    <input class=\"form-control\" type=\"text\" name=\"channel_close\" value=\"";
    echo mconfig("channel_close");
    echo "\"/>\r\n                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    ";
}

?>