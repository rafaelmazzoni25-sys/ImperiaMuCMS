<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$file_name = basename(__FILE__);
$dir_path = str_replace("\\", "/", dirname(dirname(__FILE__))) . "/";
include $dir_path . "includes/imperiamucms.php";
include __PATH_LANGUAGES__ . $config["language_default"] . "/language.php";
loadModuleConfigs("usercp.market");
if (mconfig("active") && mconfig("remove_items")) {
    $olderThan = date("Y-m-d H:i:s", time() - mconfig("remove_items_days") * 86400);
    $marketItems = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MARKET WHERE start_date < ? AND is_sold = ?", [$olderThan, 0]);
    foreach ($marketItems as $item) {
        if ($item["price_type"] == "platinum") {
            $price_type = 1;
        } else {
            if ($item["price_type"] == "gold") {
                $price_type = 2;
            } else {
                if ($item["price_type"] == "silver") {
                    $price_type = 4;
                } else {
                    if ($item["price_type"] == "WCoinC" || $item["price_type"] == "WCoin") {
                        $price_type = 8;
                    } else {
                        if ($item["price_type"] == "GoblinPoint") {
                            $price_type = 9;
                        } else {
                            if ($item["price_type"] == "zen") {
                                $price_type = 10;
                            } else {
                                if ($item["price_type"] == "bless") {
                                    $price_type = 11;
                                } else {
                                    if ($item["price_type"] == "soul") {
                                        $price_type = 12;
                                    } else {
                                        if ($item["price_type"] == "life") {
                                            $price_type = 13;
                                        } else {
                                            if ($item["price_type"] == "chaos") {
                                                $price_type = 14;
                                            } else {
                                                if ($item["price_type"] == "harmony") {
                                                    $price_type = 15;
                                                } else {
                                                    if ($item["price_type"] == "creation") {
                                                        $price_type = 16;
                                                    } else {
                                                        if ($item["price_type"] == "guardian") {
                                                            $price_type = 17;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $date = date("Y-m-d H:i:s", time());
        if ($item["Extend"] == "1") {
            $update3 = $dB->query("UPDATE IMPERIAMUCMS_MARKET SET Extend = 0 WHERE id = ?", [$item["id"]]);
        } else {
            $update3 = $dB->query("UPDATE IMPERIAMUCMS_MARKET SET is_sold = '1', sold_date = ?, purchased_by = ? WHERE id = ?", [$date, $item["seller"], $item["id"]]);
            $insert1 = $dB->query("INSERT INTO IMPERIAMUCMS_WEBSHOP_ITEMS_INVENTORY (AccountID,item,price,price_type,date,status,type,giftFrom) VALUES(?,?,?,?,?,0,5,null)", [$item["seller"], $item["item"], $item["price"], $price_type, $date]);
            $insert2 = $dB->query("INSERT INTO IMPERIAMUCMS_MARKET_LOGS(buyer,seller,item,date,type) VALUES(?,?,?,?,'returned')", [$item["seller"], $item["seller"], $item["item"], $date]);
            $logDate = date("Y-m-d H:i:s", time());
            $common->accountLogs($item["seller"], "market", sprintf(lang("market_txt_202", true), $item["item"]), $logDate);
        }
    }
}
updateCronLastRun($file_name);

?>