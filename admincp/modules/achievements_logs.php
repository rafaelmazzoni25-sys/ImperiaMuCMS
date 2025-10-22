<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">Achievements Logs</h1>\r\n";
$logs = $dB->query_fetch("SELECT TOP 100 * FROM IMPERIAMUCMS_ACHIEVEMENTS_LOGS ORDER BY id DESC");
echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
$Market = new Market();
$Items = new Items();
if (is_array($logs)) {
    echo "<table id=\"webshop_logs\" class=\"table display\"><thead><tr><th>Date</th><th>AccountID</th><th>Name</th><th>Achievement UID</th><th>Achievement Stage</th><th>Reward</th></tr></thead><tbody>";
    foreach ($logs as $thisLog) {
        $isItems = strpos($thisLog["reward"], ";");
        if ($isItems) {
            $items = explode(";", $thisLog["reward"]);
            $reward = "";
            $i = 1;
            foreach ($items as $thisItem) {
                $itemInfo = $Items->ItemInfo($thisItem);
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
                $reward .= "<span style=\"cursor: pointer;\" onmouseover=\"Tip('<center><img src=" . $itemInfo["thumb"] . "><br /><font color=yellow><br>Serial: " . $itemInfo["sn2"] . $itemInfo["sn"] . "</font><br><font color=white><br>Durability: " . $itemInfo["dur"] . "</font><br><font color=#FF99CC>" . $itemInfo["jog"] . "</font><font color=FFCC00>" . $itemInfo["harm"] . "</font><br>" . $option . " " . $luck . " " . $skill . " " . $exl . " <br>" . $ancsetopt . "<br><font color=#4d668d>" . $itemInfo["socket"] . "</font><br><br><span class=itemTooltipClassReq>" . $itemInfo["classReq"] . "</span></center>', TITLEFONTCOLOR, '" . $itemInfo["color"] . "',TITLE,'" . addslashes($itemInfo["name"]) . $itemInfo["level"] . "',TITLEBGCOLOR,'" . $itemInfo["anco"] . "')\" onmouseout=\"UnTip()\">" . $itemInfo["name"] . "</span>";
                $i++;
                if ($i < count($items)) {
                    if (2000 < strlen($reward)) {
                        $reward .= ",<br>";
                    } else {
                        $reward .= ", ";
                    }
                }
            }
        } else {
            $reward = $thisLog["reward"];
        }
        echo "<tr>";
        echo "<td>" . date($config["time_date_format_logs"], strtotime($thisLog["date"])) . "</td>";
        echo "<td>" . $thisLog["AccountID"] . "</td>";
        echo "<td>" . $common->replaceHtmlSymbols($thisLog["Name"]) . "</td>";
        echo "<td>" . $thisLog["achiev_uid"] . "</td>";
        echo "<td>" . $thisLog["achiev_stage"] . "</td>";
        echo "<td>" . $reward . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
}

?>