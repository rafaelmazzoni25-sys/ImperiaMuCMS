<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "donation", "allow")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("donation_txt_79", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("tmpay")) {
                $price_type = mconfig("credit_config");
                if ($price_type == "1") {
                    $price_type = lang("currency_platinum", true);
                } else {
                    if ($price_type == "2") {
                        $price_type = lang("currency_gold", true);
                    } else {
                        if ($price_type == "3") {
                            $price_type = lang("currency_silver", true);
                        } else {
                            if ($price_type == "4") {
                                $price_type = lang("currency_wcoinc", true);
                            } else {
                                if ($price_type == "5") {
                                    $price_type = lang("currency_gp", true);
                                } else {
                                    if ($price_type == "6") {
                                        $price_type = "" . lang("currency_zen", true) . "";
                                    }
                                }
                            }
                        }
                    }
                }
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $curl = curl_init();
                        curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => "https://www.tmpay.net/TPG/backend.php?merchant_id=" . mconfig("merchant_id") . "&password=" . $_POST["code"] . "&resp_url=" . __BASE_URL__ . "api/tmpay.php"]);
                        $resp = curl_exec($curl);
                        curl_close($curl);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">" . lang("donation_txt_80", true) . "</div>\r\n    </div>";
                $token = time();
                $_SESSION["token"] = $token;
                echo "\r\n    <script type=\"text/javascript\" src=\"" . __PATH_TEMPLATE__ . "js/jquery.maskedinput.js\"></script>\r\n    <script>\r\n        jQuery(function (\$) {\r\n            \$.mask.definitions['c'] = \"[A-Z0-9]\";\r\n            \$(\"#code\").mask(\"cccccccccccccc\", {placeholder: \"-\"});\r\n        });\r\n    </script>\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label for=\"type\">" . lang("donation_txt_26", true) . ":</label>\r\n                    <input type=\"text\" name=\"code\" id=\"code\" class=\"form-control code-input\" placeholder=\"" . lang("donation_txt_26", true) . "\">\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("donation_txt_27", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                </div>\r\n            </form>\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th class=\"headerRow\">" . lang("donation_txt_81", true) . "</th>\r\n                        <th class=\"headerRow\">" . lang("donation_txt_83", true) . "</th>\r\n                        <th class=\"headerRow\">" . lang("donation_txt_84", true) . "</th>\r\n                    </tr>";
                if (is_array(mconfig("options")["option"])) {
                    foreach (mconfig("options")["option"] as $thisOpt) {
                        echo "\r\n                    <tr>\r\n                        <td>" . number_format($thisOpt["@attributes"]["amount"]) . " " . lang("donation_txt_82", true) . "</td>\r\n                        <td>" . number_format($thisOpt["@attributes"]["reward"]) . " " . $price_type . "</td>\r\n                        <td>" . number_format($thisOpt["@attributes"]["bonus"]) . " " . $price_type . "</td>\r\n                    </tr>";
                    }
                }
                echo "\r\n                </table>\r\n            </div>\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                        <th class=\"headerRow\" colspan=\"6\">" . lang("donation_txt_85", true) . "</th>\r\n                    </tr>\r\n                    <tr>\r\n                        <th class=\"headerRow\">" . lang("donation_txt_86", true) . "</th>\r\n                        <th class=\"headerRow\">" . lang("donation_txt_87", true) . "</th>\r\n                        <th class=\"headerRow\">" . lang("donation_txt_83", true) . "</th>\r\n                        <th class=\"headerRow\">" . lang("donation_txt_84", true) . "</th>\r\n                        <th class=\"headerRow\">" . lang("donation_txt_67", true) . "</th>\r\n                        <th class=\"headerRow\">" . lang("donation_txt_88", true) . "</th>\r\n                    </tr>";
                $donations = $dB->query_fetch("SELECT Code, RealAmount, RewardAmount, BonusAmount, Date, Status FROM IMPERIAMUCMS_DONATE_TMPAY WHERE AccountID = ? ORDER BY Date DESC", [$_SESSION["username"]]);
                if (is_array($donations)) {
                    foreach ($donations as $thisDonation) {
                        $status = "";
                        if ($thisDonation["Status"] == "0") {
                            $status = lang("donation_txt_94", true);
                        } else {
                            if ($thisDonation["Status"] == "1") {
                                $status = lang("donation_txt_89", true);
                            } else {
                                if ($thisDonation["Status"] == "3") {
                                    $status = lang("donation_txt_90", true);
                                } else {
                                    if ($thisDonation["Status"] == "4") {
                                        $status = lang("donation_txt_91", true);
                                    } else {
                                        if ($thisDonation["Status"] == "5") {
                                            $status = lang("donation_txt_92", true);
                                        }
                                    }
                                }
                            }
                        }
                        echo "\r\n                    <tr>\r\n                        <td>" . $thisDonation["Code"] . "</td>\r\n                        <td>" . number_format($thisDonation["RealAmount"]) . " " . lang("donation_txt_82", true) . "</td>\r\n                        <td>" . number_format($thisDonation["RewardAmount"]) . " " . $price_type . "</td>\r\n                        <td>" . number_format($thisDonation["BonusAmount"]) . " " . $price_type . "</td>\r\n                        <td>" . date($config["time_date_format"], strtotime($thisDonation["Date"])) . "</td>\r\n                        <td>" . $status . "</td>\r\n                    </tr>";
                    }
                } else {
                    echo "\r\n                    <tr>\r\n                        <td colspan=\"4\">" . lang("donation_txt_93", true) . "</td>\r\n                    </tr>";
                }
                echo "\r\n                </table>\r\n            </div>\r\n        </div>\r\n    </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
    }
}

?>