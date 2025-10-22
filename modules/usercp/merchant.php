<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!isLoggedIn()) {
    redirect(1, "login");
}
if (!canAccessModule($_SESSION["username"], "merchant", "block")) {
    return NULL;
}
$General = new xGeneral();
if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("merchant")) {
    $merchants = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MERCHANTS");
    $canAccess = false;
    $i = 0;
    foreach ($merchants as $thisMerchant) {
        if ($thisMerchant["AccountID"] == $_SESSION["username"] && $thisMerchant["active"] == "1") {
            $canAccess = true;
            if (check_value($_GET["sub"])) {
                $sub = xss_clean($_GET["sub"]);
                if ($sub == "history") {
                    echo "\r\n            <div class=\"sub-page-title\">\r\n              <div id=\"title\">\r\n                <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n              </div>\r\n            </div>\r\n            <div class=\"container_2 account\" align=\"center\">\r\n              <div class=\"cont-image\">\r\n                <div class=\"container_3 account_sub_header\">\r\n                  <div class=\"grad\">\r\n                    <div class=\"page-title\">" . lang("merchant_txt_1", true) . "</div>\r\n                    <div class=\"sub-active-page\">" . lang("merchant_txt_2", true) . "</div>\r\n                    <a href=\"" . __BASE_URL__ . "usercp/merchant\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("merchant_txt_1", true) . "</a>\r\n                    <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n                  </div>\r\n                </div>\r\n                    <div class=\"page-desc-holder\"></div>";
                    if (mconfig("active") && $canAccess) {
                        echo "\r\n                <div class=\"container_3 account-wide\" align=\"center\">\r\n                  <table class=\"irq\" cellspacing=\"0\" width=\"100%\">\r\n                    <thead>\r\n                      <tr>\r\n                        <th align=\"center\">" . lang("merchant_txt_3", true) . "</th>\r\n                        <th align=\"center\">" . lang("merchant_txt_4", true) . "</th>\r\n                        <th align=\"center\">" . lang("merchant_txt_5", true) . "</th>\r\n                        <th align=\"center\">" . lang("merchant_txt_6", true) . "</th>\r\n                      </tr>\r\n                    </thead>\r\n                    <tbody>";
                        $logs = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_MERCHANTS_LOGS WHERE AccountID = ? ORDER BY date DESC", [$_SESSION["username"]]);
                        if (is_array($logs)) {
                            foreach ($logs as $thisLog) {
                                echo "\r\n                            <tr class=\"" . $m_table_class . "\">\r\n                              <td align=\"center\">" . date($config["time_date_format"], strtotime($thisLog["date"])) . "</td>\r\n                              <td align=\"center\">" . $thisLog["buyer"] . "</td>\r\n                              <td align=\"center\">" . number_format($thisLog["amount"]) . "</td>";
                                echo "<td>" . number_format($thisLog["reward_wcoin"]) . " WCoinC";
                                if (0 < $thisLog["reward_platinum"]) {
                                    echo ", " . number_format($thisLog["reward_platinum"]) . " " . lang("currency_platinum", true);
                                }
                                echo "</td>\r\n                            </tr>";
                                if ($m_table_class != "even") {
                                    $m_table_class = "even";
                                } else {
                                    $m_table_class = "";
                                }
                            }
                        }
                        echo "\r\n                    </tbody>\r\n                  </table>\r\n                </div>";
                    } else {
                        message("error", lang("error_47", true));
                    }
                    echo "\r\n              </div>\r\n            </div>";
                }
            } else {
                echo "\r\n        <div class=\"sub-page-title\">\r\n          <div id=\"title\">\r\n            <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n          </div>\r\n        </div>\r\n        <div class=\"container_2 account\" align=\"center\">\r\n          <div class=\"cont-image\">";
                if (check_value($_POST["submit"]) && $canAccess) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $account = xss_clean(htmlspecialchars($_POST["account"]));
                        $amount = xss_clean(htmlspecialchars($_POST["amount"]));
                        if (config("SQL_USE_2_DB", true)) {
                            $checkAccount = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$account]);
                        } else {
                            $checkAccount = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb___id = ?", [$account]);
                        }
                        if ($checkAccount["memb___id"] == $account) {
                            if (is_numeric($amount) && 0 < $amount) {
                                if ($amount <= $merchants[$i]["wallet"]) {
                                    $WCoinC = $amount * mconfig("ratio");
                                    $bonusDiv = floor($amount / mconfig("bonus_req"));
                                    $bonus = mconfig("bonus_amount") * $bonusDiv;
                                    $WCoinC = $WCoinC + $bonus;
                                    if (0 < mconfig("bonus")) {
                                        $percBonus = floor($WCoinC * mconfig("bonus") / 100);
                                        $WCoinC = $WCoinC + $percBonus;
                                    }
                                    $bonusPlatDiv = floor($amount / mconfig("bonus_platinum_req"));
                                    $bonusPlat = mconfig("bonus_platinum_amount") * $bonusPlatDiv;
                                    if (0 < $bonusPlat) {
                                        if (config("MEMB_CREDITS_MEMUONLINE", true)) {
                                            $update1 = $dB2->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$bonusPlat, $account]);
                                        } else {
                                            $update1 = $dB->query("UPDATE MEMB_CREDITS SET platinum = platinum + ? WHERE memb___id = ?", [$bonusPlat, $account]);
                                        }
                                    } else {
                                        $update1 = true;
                                    }
                                    if (100 <= config("server_files_season", true)) {
                                        $update2 = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + ? WHERE AccountID = ?", [$WCoinC, $account]);
                                    } else {
                                        if (100 <= config("server_files_season", true)) {
                                            $update2 = $dB->query("UPDATE T_InGameShop_Point SET WCoin = WCoin + ? WHERE AccountID = ?", [$WCoinC, $account]);
                                        } else {
                                            $update2 = $dB->query("UPDATE T_InGameShop_Point SET WCoinC = WCoinC + ? WHERE AccountID = ?", [$WCoinC, $account]);
                                        }
                                    }
                                    $update3 = $dB->query("UPDATE IMPERIAMUCMS_MERCHANTS SET wallet = wallet - ? WHERE AccountID = ?", [$amount, $_SESSION["username"]]);
                                    $insert = $dB->query("INSERT INTO IMPERIAMUCMS_MERCHANTS_LOGS(AccountID,buyer,amount,reward_wcoin,reward_platinum,date) VALUES(?,?,?,?,?,?)", [$_SESSION["username"], $account, $amount, $WCoinC, $bonusPlat, date("Y-m-d H:i:s", time())]);
                                    if ($update1 && $update2 && $update3) {
                                        message("success", sprintf(lang("merchant_txt_9", true), $account));
                                    } else {
                                        message("error", lang("error_23", true));
                                    }
                                } else {
                                    message("error", lang("merchant_txt_10", true));
                                }
                            } else {
                                message("error", lang("merchant_txt_11", true));
                            }
                        } else {
                            message("error", lang("merchant_txt_12", true));
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $token = time();
                $_SESSION["token"] = $token;
                echo "\r\n            <div class=\"container_3 account_sub_header\">\r\n              <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("merchant_txt_1", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "usercp/merchant?sub=history\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("merchant_txt_2", true) . "</a>\r\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n              </div>\r\n            </div>\r\n            <div class=\"vote-page\">\r\n              <div class=\"page-desc-holder\">\r\n                " . sprintf(lang("merchant_txt_7", true), mconfig("ratio")) . "<br>\r\n                " . sprintf(lang("merchant_txt_8", true), number_format($merchants[$i]["wallet"])) . "\r\n              </div>";
                if (mconfig("active") && $canAccess) {
                    echo "\r\n            <div class=\"container_3 account-wide\" align=\"center\">";
                    echo "\r\n              <form action=\"\" method=\"post\">\r\n                <div style=\"padding-top: 20px;\">\r\n                  <div class=\"row\">\r\n                    <label for=\"amount\">" . lang("merchant_txt_13", true) . "</label>\r\n                    <input type=\"text\" name=\"account\">\r\n                  </div>\r\n                  <div class=\"row\">\r\n                    <label for=\"amount\">" . lang("merchant_txt_14", true) . "</label>\r\n                    <input type=\"text\" name=\"amount\">\r\n                  </div>\r\n                  <div class=\"row\" align=\"right\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("merchant_txt_15", true) . "\">\r\n                  </div>\r\n                  <div class=\"clear\"></div>\r\n                  <div class=\"description-small\">\r\n                    " . lang("merchant_txt_16", true) . "\r\n                  </div>\r\n                </div>\r\n              </form>";
                    echo "\r\n            </div>";
                } else {
                    message("error", lang("error_47", true));
                }
                echo "\r\n            </div>\r\n          </div>\r\n        </div>";
            }
        } else {
            $i++;
        }
    }
} else {
    message("error", lang("merchant_txt_17", true));
}

?>