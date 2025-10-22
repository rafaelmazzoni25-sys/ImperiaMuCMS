<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!(include_once "../includes/imperiamucms.php")) {
    throw new Exception("Could not load ImperiaMuCMS.");
}
if (!(include_once __PATH_ADMINCP_INC__ . "functions.php")) {
    throw new Exception("Could not load AdminCP functions.");
}
if (!isLoggedIn()) {
    redirect();
}
if (!canAccessAdminCP($_SESSION["username"])) {
    redirect();
}
if (isset($_GET["data"])) {
    $logPageData = logPages();
    $data = json_decode(base64_decode($_GET["data"]));
    $data = arrayCastRecursive($data);
    $pageName = $data["name"];
    $logs = $dB->query_fetch($data["query"]);
    $exportData = [];
    $logsData = [];
    $Market = new Market();
    $Items = new Items();
    $Promo = new Promo();
    $logCounter = 0;
    foreach ($logs as $thisRow) {
        $i = 0;
        while ($i < count($logPageData[$pageName]["columns"])) {
            if ($logPageData[$pageName]["columns"][$i]["type"] == "date") {
                $logsData[$logCounter][$logPageData[$pageName]["columns"][$i]["title"]] = date("Y-m-d H:i:s", strtotime($thisRow[$logPageData[$pageName]["columns"][$i]["name"]]));
            } else {
                if ($logPageData[$pageName]["columns"][$i]["type"] == "text") {
                    $logsData[$logCounter][$logPageData[$pageName]["columns"][$i]["title"]] = $thisRow[$logPageData[$pageName]["columns"][$i]["name"]];
                } else {
                    if ($logPageData[$pageName]["columns"][$i]["type"] == "items") {
                        $rewardItems = explode(",", $thisRow[$logPageData[$pageName]["columns"][$i]["name"]]);
                        foreach ($rewardItems as $thisItem) {
                            $itemData = explode(":", $thisItem);
                            $itemHex = $itemData[0];
                            $itemInfo = $Items->ItemInfo($itemHex);
                            $easytoyou_decoder_beta_not_finish .= $itemInfo["name"] . ";";
                        }
                    } else {
                        if ($logPageData[$pageName]["columns"][$i]["type"] == "amount") {
                            if (0 < $thisRow[$logPageData[$pageName]["columns"][$i]["name"]]) {
                                $logsData[$logCounter][$logPageData[$pageName]["columns"][$i]["title"]] = $thisRow[$logPageData[$pageName]["columns"][$i]["name"]] . " " . $Promo->getCurrencyName($thisRow[$logPageData[$pageName]["columns"][$i + 1]["name"]]);
                            } else {
                                $logsData[$logCounter][$logPageData[$pageName]["columns"][$i]["title"]] = "";
                            }
                            $i++;
                        }
                    }
                }
            }
            $i++;
        }
        $logCounter++;
    }
    $exportData["data"] = $logsData;
    $exportData["filename"] = $pageName . "_" . date("Y-m-d-H-i-s", time());
    $exportData["delimeter"] = ",";
    $exportData["enclosure"] = "\"";
    export_data_to_csv($exportData["data"], $exportData["filename"], $exportData["delimeter"], $exportData["enclosure"]);
}
function arrayCastRecursive($array)
{
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = arrayCastRecursive($value);
            }
            if ($value instanceof stdClass) {
                $array[$key] = arrayCastRecursive($easytoyou_decoder_beta_not_finish);
            }
        }
    }
    if ($array instanceof stdClass) {
        return arrayCastRecursive($easytoyou_decoder_beta_not_finish);
    }
    return $array;
}

?>