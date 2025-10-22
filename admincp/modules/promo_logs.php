<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Promo Codes Logs</h1>\r";
try {
    $logs = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_PROMO_LOGS ORDER BY id DESC");
    if (!is_array($logs)) {
        throw new Exception("There are no promo logs in the database.");
    }
    echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
    $Market = new Market();
    $Items = new Items();
    echo "<table id=\"promo_logs\" class=\"table table-condensed table-hover\"><thead><tr><th>Code</th><th>AccountID</th><th>Reward</th><th>Date</th></tr></thead><tbody>";
    foreach ($logs as $thisLog) {
        $codeData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_PROMO WHERE code = ?", [$thisLog["code"]]);
        if ($codeData["reward_type"] == 4 || $codeData["reward_type"] == 5 || $codeData["reward_type"] == 6) {
            $itemInfo = $Items->ItemInfo($thisLog["reward"]);
            $luck = "";
            $skill = "";
            $option = "";
            $exl = "";
            $ancsetopt = "";
            if ($itemInfo["level"]) {
                $itemInfo["level"] = " +" . $itemInfo["level"];
            } else {
                $itemInfo["level"] = NULL;
            }
            if ($itemInfo["luck"]) {
                $luck = "<br><font color=#9aadd5>" . $itemInfo["luck"] . "</font>";
            }
            if ($itemInfo["skill"]) {
                $skill = "<br><font color=#9aadd5>" . $itemInfo["skill"] . "</font>";
            }
            if ($itemInfo["opt"]) {
                $option = "<font color=#9aadd5>" . $itemInfo["opt"] . "</font>";
            }
            if ($itemInfo["exl"]) {
                $exl = "<font color=#4d668d>" . str_replace("^^", "<br>", $itemInfo["exl"]) . "</font>";
            }
            if ($itemInfo["ancsetopt"]) {
                $ancsetopt = "<font color=#9aadd5>" . str_replace("^^", "<br>", $itemInfo["ancsetopt"]) . "</font>";
            }
            $showReward = "<td style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br>Serial: " . $itemInfo["sn2"] . $itemInfo["sn"] . "</font><br><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</td>";
        } else {
            $showReward = "<td>" . $thisLog["reward"] . "</td>";
        }
        echo "<tr>";
        echo "<td>" . $thisLog["code"] . "</td>";
        echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($thisLog["AccountID"])) . "\">" . $thisLog["AccountID"] . "</a></td>";
        echo $showReward;
        echo "<td>" . date($config["time_date_format"], strtotime($thisLog["date"])) . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} catch (Exception $ex) {
    message("error", $ex->getMessage());
}

?>