<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "donation", "allow")) {
        return NULL;
    }
    $rewardType = mconfig("credit_config");
    if ($rewardType == "1") {
        $rewardType = lang("currency_platinum", true);
        $return["column"] = "platinum";
        $return["table"] = "MEMB_CREDITS";
        $return["ident"] = "memb___id";
    } else {
        if ($rewardType == "2") {
            $rewardType = lang("currency_gold", true);
            $return["column"] = "gold";
            $return["table"] = "MEMB_CREDITS";
            $return["ident"] = "memb___id";
        } else {
            if ($rewardType == "3") {
                $rewardType = lang("currency_silver", true);
                $return["column"] = "silver";
                $return["table"] = "MEMB_CREDITS";
                $return["ident"] = "memb___id";
            } else {
                if ($rewardType == "4") {
                    $rewardType = lang("currency_wcoinc", true);
                    if (100 <= config("server_files_season", true)) {
                        $return["column"] = "WCoin";
                    } else {
                        $return["column"] = "WCoinC";
                    }
                    $return["table"] = "T_InGameShop_Point";
                    $return["ident"] = "AccountID";
                } else {
                    if ($rewardType == "5") {
                        $rewardType = lang("currency_gp", true);
                        $return["column"] = "GoblinPoint";
                        $return["table"] = "T_InGameShop_Point";
                        $return["ident"] = "AccountID";
                    } else {
                        if ($rewardType == "6") {
                            $rewardType = "" . lang("currency_zen", true) . "";
                            $return["column"] = "zen";
                            $return["table"] = "IMPERIAMUCMS_WEB_BANK";
                            $return["ident"] = "AccountID";
                        }
                    }
                }
            }
        }
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\n    <h3>\n        " . lang("donation_txt_22", true) . "\n        " . $breadcrumb . "\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("homepaypl");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("homepaypl");
            echo "\n    <div class=\"row desc-row\">\n        <div class=\"col-xs-12\">" . lang("donation_txt_23", true) . "</div>\n    </div>";
            $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.homepaypl.xml");
            if ($xml !== false) {
                $options = [];
                $selectOptions = "";
                $selectInfo = "";
                $i = 1;
                foreach ($xml->options->children() as $tag => $option) {
                    if ($tag == "option") {
                        $options[$i]["acc_id"] = intval($option["acc_id"]);
                        $options[$i]["name"] = strval($option["name"]);
                        $options[$i]["netto"] = floatval($option["netto"]);
                        $options[$i]["brutto"] = floatval($option["brutto"]);
                        $options[$i]["reward"] = intval($option["reward"]);
                        $options[$i]["number"] = intval($option["number"]);
                        $options[$i]["text"] = strval($option["text"]);
                        $selectInfo .= "<div id=\"sms" . $i . "\">" . sprintf(lang("donation_txt_28", true), $options[$i]["text"], $options[$i]["number"], $options[$i]["reward"], $rewardType, $options[$i]["netto"], $options[$i]["brutto"]) . "</div>";
                        $i++;
                    }
                }
            }
            if (check_value($_POST["submit"])) {
                $code = htmlspecialchars(xss_clean($_POST["code"]));
                if ($code != NULL && strlen($code) == 8) {
                    $config_homepay_multi = ["acc_ids" => []];
                    $config_homepay_accs = [];
                    foreach ($options as $k => $v) {
                        $config_homepay_accs[$v["acc_id"]] = $k;
                        $config_homepay_multi["acc_ids"][] = $v["acc_id"];
                    }
                    $config_homepay_multi["acc_ids"] = urlencode(implode(",", $config_homepay_multi["acc_ids"]));
                    if (!preg_match("/^[A-Za-z0-9]{8}\$/", $code)) {
                        message("error", lang("donation_txt_29", true));
                    } else {
                        $handle = fopen("http://homepay.pl/API/check_code_multi.php?usr_id=" . mconfig("user_id") . "&acc_id=" . $config_homepay_multi["acc_ids"] . "&code=" . $code, "r");
                        $check = fgetcsv($handle, 1024);
                        fclose($handle);
                        if ($check[0] == "1") {
                            $i = 1;
                            foreach ($xml->options->children() as $tag => $option) {
                                if ($tag == "option") {
                                    if (floatval($option["netto"]) == $options[$config_homepay_accs[$check[1]]]["netto"]) {
                                        if (config("MEMB_CREDITS_MEMUONLINE", true) && ($return["column"] == "platinum" || $return["column"] == "gold" || $return["column"] == "silver")) {
                                            $update = $dB2->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " + ? WHERE " . $return["ident"] . " = ?", [intval($option["reward"]), $_SESSION["username"]]);
                                        } else {
                                            $update = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " + ? WHERE " . $return["ident"] . " = ?", [intval($option["reward"]), $_SESSION["username"]]);
                                        }
                                        if ($update) {
                                            message("success", sprintf(lang("donation_txt_24", true), intval($option["reward"]), $rewardType));
                                            $dB->query("INSERT INTO IMPERIAMUCMS_HOMEPAYPL_LOGS (AccountID, acc_id, name, netto, brutto, reward, reward_type, number, text, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], $option["acc_id"], $option["name"], $option["netto"], $option["brutto"], $option["reward"], mconfig("credit_config"), $option["number"], $option["text"], date("Y-m-d H:i:s", time())]);
                                            $logDate = date("Y-m-d H:i:s", time());
                                            $common->accountLogs($_SESSION["username"], "homepaypl", sprintf(lang("donation_txt_25", true), intval($option["reward"]), $rewardType), $logDate);
                                        } else {
                                            message("error", lang("error_23"));
                                        }
                                    } else {
                                        $i++;
                                    }
                                }
                            }
                        } else {
                            message("error", lang("donation_txt_29", true));
                        }
                    }
                } else {
                    message("error", lang("donation_txt_29", true));
                }
            }
            echo "\n        <script type=\"text/javascript\" src=\"";
            echo __PATH_TEMPLATE__;
            echo "js/jquery.maskedinput.js\"></script>\n        <script>\n            jQuery(function (\$) {\n                \$.mask.definitions['c'] = \"[a-zA-Z0-9]\";\n                \$(\"#code\").mask(\"cccccccc\", {placeholder: \"-\"});\n            });\n        </script>\n\n        ";
            echo "\n    <div class=\"row\">\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\n            <form name=\"homepaypl\" method=\"post\" action=\"\">\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\n                    <div class=\"row\">\n                        <label for=\"type\">" . lang("donation_txt_26", true) . ":</label>\n                        <input type=\"text\" name=\"code\" id=\"code\" class=\"form-control\" placeholder=\"" . lang("donation_txt_26", true) . "\">\n                    </div>\n                    <div class=\"row\" align=\"right\">\n                        <input type=\"submit\" name=\"submit\" class=\"btn btn-warning make-space\" value=\"" . lang("donation_txt_27", true) . "\">\n                    </div>\n                </div>\n            </form>\n        </div>\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\n<div class=\"sub-page-title\">\n    <div id=\"title\">\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\n    </div>\n</div>\n<div class=\"container_2 account\" align=\"center\">\n    <div class=\"cont-image\">\n        <div class=\"container_3 account_sub_header\">\n            <div class=\"grad\">\n                <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\n                <div class=\"sub-active-page\">" . lang("donation_txt_22", true) . "</div>\n                <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\n            </div>\n        </div>\n        <div class=\"page-desc-holder\">\n            " . lang("donation_txt_23", true) . "\n        </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("homepaypl");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("homepaypl");
            $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.homepaypl.xml");
            if ($xml !== false) {
                $options = [];
                $selectOptions = "";
                $selectInfo = "";
                $i = 1;
                foreach ($xml->options->children() as $tag => $option) {
                    if ($tag == "option") {
                        $options[$i]["acc_id"] = intval($option["acc_id"]);
                        $options[$i]["name"] = strval($option["name"]);
                        $options[$i]["netto"] = floatval($option["netto"]);
                        $options[$i]["brutto"] = floatval($option["brutto"]);
                        $options[$i]["reward"] = intval($option["reward"]);
                        $options[$i]["number"] = intval($option["number"]);
                        $options[$i]["text"] = strval($option["text"]);
                        $selectInfo .= "<div id=\"sms" . $i . "\">" . sprintf(lang("donation_txt_28", true), $options[$i]["text"], $options[$i]["number"], $options[$i]["reward"], $rewardType, $options[$i]["netto"], $options[$i]["brutto"]) . "</div>";
                        $i++;
                    }
                }
            }
            if (check_value($_POST["submit"])) {
                $code = htmlspecialchars(xss_clean($_POST["code"]));
                if ($code != NULL && strlen($code) == 8) {
                    $config_homepay_multi = ["acc_ids" => []];
                    $config_homepay_accs = [];
                    foreach ($options as $k => $v) {
                        $config_homepay_accs[$v["acc_id"]] = $k;
                        $config_homepay_multi["acc_ids"][] = $v["acc_id"];
                    }
                    $config_homepay_multi["acc_ids"] = urlencode(implode(",", $config_homepay_multi["acc_ids"]));
                    if (!preg_match("/^[A-Za-z0-9]{8}\$/", $code)) {
                        message("error", lang("donation_txt_29", true));
                    } else {
                        $handle = fopen("http://homepay.pl/API/check_code_multi.php?usr_id=" . mconfig("user_id") . "&acc_id=" . $config_homepay_multi["acc_ids"] . "&code=" . $code, "r");
                        $check = fgetcsv($handle, 1024);
                        fclose($handle);
                        if ($check[0] == "1") {
                            $i = 1;
                            foreach ($xml->options->children() as $tag => $option) {
                                if ($tag == "option") {
                                    if (floatval($option["netto"]) == $options[$config_homepay_accs[$check[1]]]["netto"]) {
                                        if (config("MEMB_CREDITS_MEMUONLINE", true) && ($return["column"] == "platinum" || $return["column"] == "gold" || $return["column"] == "silver")) {
                                            $update = $dB2->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " + ? WHERE " . $return["ident"] . " = ?", [intval($option["reward"]), $_SESSION["username"]]);
                                        } else {
                                            $update = $dB->query("UPDATE " . $return["table"] . " SET " . $return["column"] . " = " . $return["column"] . " + ? WHERE " . $return["ident"] . " = ?", [intval($option["reward"]), $_SESSION["username"]]);
                                        }
                                        if ($update) {
                                            message("success", sprintf(lang("donation_txt_24", true), intval($option["reward"]), $rewardType));
                                            $dB->query("INSERT INTO IMPERIAMUCMS_HOMEPAYPL_LOGS (AccountID, acc_id, name, netto, brutto, reward, reward_type, number, text, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], $option["acc_id"], $option["name"], $option["netto"], $option["brutto"], $option["reward"], mconfig("credit_config"), $option["number"], $option["text"], date("Y-m-d H:i:s", time())]);
                                            $logDate = date("Y-m-d H:i:s", time());
                                            $common->accountLogs($_SESSION["username"], "homepaypl", sprintf(lang("donation_txt_25", true), intval($option["reward"]), $rewardType), $logDate);
                                        } else {
                                            message("error", lang("error_23"));
                                        }
                                    } else {
                                        $i++;
                                    }
                                }
                            }
                        } else {
                            message("error", lang("donation_txt_29", true));
                        }
                    }
                } else {
                    message("error", lang("donation_txt_29", true));
                }
            }
            echo "\n        <script>\n            jQuery(function (\$) {\n                \$.mask.definitions['c'] = \"[a-zA-Z0-9]\";\n                \$(\"#code\").mask(\"cccccccc\", {placeholder: \"-\"});\n            });\n        </script>\n\n        ";
            echo "\n        <div class=\"container_3 account-wide\" align=\"center\">\n            <form name=\"homepaypl\" method=\"post\" action=\"\">\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\n                    <div class=\"row\">\n                        <label for=\"type\">" . lang("donation_txt_26", true) . ":</label>\n                        <input type=\"text\" name=\"code\" id=\"code\" placeholder=\"" . lang("donation_txt_26", true) . "\">\n                    </div>\n                    <div class=\"row\" align=\"right\">\n                        <input type=\"submit\" name=\"submit\" value=\"" . lang("donation_txt_27", true) . "\">\n                    </div>\n                </div>\n            </form>\n            <div style=\"padding-bottom: 20px;\">\n                <p>" . $selectInfo . "</p>\n            </div>\n        </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\n    </div>\n</div>";
    }
}

?>