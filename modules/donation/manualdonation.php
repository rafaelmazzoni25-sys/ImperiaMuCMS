<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "donation", "allow")) {
        return NULL;
    }
    loadModuleConfigs("manualdonation");
    $General = new xGeneral();
    if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("manual_donation")) {
        $gatewayId = NULL;
        $gatewayName = NULL;
        $displayError = false;
        if (isset($_GET["gateway"]) && $_GET["gateway"] == "viettel") {
            $gatewayId = 1;
            $gatewayName = "Viettel";
        } else {
            if (isset($_GET["gateway"]) && $_GET["gateway"] == "mobifone") {
                $gatewayId = 2;
                $gatewayName = "Mobifone";
            } else {
                if (isset($_GET["gateway"]) && $_GET["gateway"] == "vinaphone") {
                    $gatewayId = 3;
                    $gatewayName = "Vinaphone";
                } else {
                    message("error", lang("error_25", true));
                    $displayError = true;
                }
            }
        }
        if (!$displayError) {
            if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                $breadcrumb = generateBreadcrumb();
                echo "\r\n    <h3>\r\n        " . $gatewayName;
                if (isset($_GET["sub"]) && $_GET["sub"] == "history") {
                    echo "<a href=\"" . __BASE_URL__ . "donation/manualdonation/gateway/" . $_GET["gateway"] . "\" class=\"btn btn-warning btn-navtop\">" . $gatewayName . "</a>";
                } else {
                    echo "<a href=\"" . __BASE_URL__ . "donation/manualdonation/gateway/" . $_GET["gateway"] . "/?sub=history\" class=\"btn btn-warning btn-navtop\">" . lang("donation_txt_66", true) . "</a>";
                }
                echo "\r\n        " . $breadcrumb . "\r\n    </h3>";
                if (mconfig("active")) {
                    if (check_value($_GET["sub"]) && $_GET["sub"] == "history") {
                        $requests = $dB->query_fetch("SELECT TOP 50 * FROM IMPERIAMUCMS_DONATE_MANUAL WHERE AccountID = ? ORDER BY date DESC", [$_SESSION["username"]]);
                        echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12\">\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <thead>\r\n                        <tr>\r\n                            <th align=\"center\">" . lang("donation_txt_67", true) . "</th>\r\n                            <th align=\"center\">" . lang("donation_txt_68", true) . "</th>\r\n                            <th align=\"center\">" . lang("donation_txt_69", true) . "</th>\r\n                            <th align=\"center\">" . lang("donation_txt_70", true) . "</th>\r\n                            <th align=\"center\">" . lang("donation_txt_71", true) . "</th>\r\n                            <th align=\"center\">" . lang("donation_txt_72", true) . "</th>\r\n                            <th align=\"center\">" . lang("donation_txt_73", true) . "</th>\r\n                        </tr>\r\n                    </thead>\r\n                    <tbody>";
                        if (is_array($requests)) {
                            foreach ($requests as $thisRequest) {
                                $status = NULL;
                                $gatewayNameTmp = NULL;
                                $reward_type = NULL;
                                $reward_type = $thisRequest["reward_type"];
                                if ($reward_type == "1") {
                                    $reward_type = lang("currency_platinum", true);
                                } else {
                                    if ($reward_type == "2") {
                                        $reward_type = lang("currency_gold", true);
                                    } else {
                                        if ($reward_type == "3") {
                                            $reward_type = lang("currency_silver", true);
                                        } else {
                                            if ($reward_type == "4") {
                                                $reward_type = lang("currency_wcoinc", true);
                                            } else {
                                                if ($reward_type == "5") {
                                                    $reward_type = lang("currency_gp", true);
                                                } else {
                                                    if ($reward_type == "6") {
                                                        $reward_type = "" . lang("currency_zen", true) . "";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                if ($thisRequest["gateway"] == "1") {
                                    $gatewayNameTmp = "Viettel";
                                } else {
                                    if ($thisRequest["gateway"] == "2") {
                                        $gatewayNameTmp = "Mobifone";
                                    } else {
                                        if ($thisRequest["gateway"] == "3") {
                                            $gatewayNameTmp = "Vinaphone";
                                        }
                                    }
                                }
                                if ($thisRequest["status"] == "0") {
                                    $status = "<span style=\"padding: 5px; border-radius: 2px; background-color: blue; color: white;\">" . lang("donation_txt_75", true) . "</span>";
                                } else {
                                    if ($thisRequest["status"] == "1") {
                                        $status = "<span style=\"padding: 5px; border-radius: 2px; background-color: green; color: white;\">" . lang("donation_txt_76", true) . "</span>";
                                    } else {
                                        if ($thisRequest["status"] == "2") {
                                            $status = "<span style=\"padding: 5px; border-radius: 2px; background-color: #9b0900; color: white;\">" . lang("donation_txt_77", true) . "</span>";
                                        }
                                    }
                                }
                                echo "\r\n                    <tr>\r\n                        <td>" . date($config["time_date_format"], strtotime($thisRequest["date"])) . "</td>\r\n                        <td>" . number_format($thisRequest["amount"]) . " " . $thisRequest["amount_currency"] . "</td>\r\n                        <td>" . number_format($thisRequest["reward"]) . " " . $reward_type . "</td>\r\n                        <td>" . $gatewayNameTmp . "</td>\r\n                        <td>" . $thisRequest["code"] . "</td>\r\n                        <td>" . $thisRequest["serial"] . "</td>\r\n                        <td>" . $status . "</td>\r\n                    </tr>";
                            }
                        } else {
                            echo "\r\n                    <tr>\r\n                        <td colspan=\"7\">" . lang("donation_txt_74", true) . "</td>\r\n                    </tr>";
                        }
                        echo "\r\n                    </tbody>\r\n                </table>\r\n            </div>\r\n        </div>\r\n    </div>";
                    } else {
                        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "manualdonation.xml");
                        if ($xml !== false) {
                            $options = [];
                            $selectOptions = "";
                            $selectInfo = "";
                            $i = 1;
                            foreach ($xml->options->children() as $tag => $option) {
                                if ($tag == "option") {
                                    $options[$i]["id"] = intval($option["id"]);
                                    $options[$i]["name"] = strval($option["name"]);
                                    $options[$i]["amount"] = floatval($option["amount"]);
                                    $options[$i]["currency"] = strval($option["currency"]);
                                    $options[$i]["reward"] = floatval($option["reward"]);
                                    $options[$i]["desc"] = strval($option["desc"]);
                                    $selectOptions .= "<option value=\"" . intval($option["id"]) . "\">" . strval($option["name"]) . "</option>";
                                    $i++;
                                }
                            }
                        }
                        if (check_value($_POST["submit"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                if (empty($_POST["type"])) {
                                    message("error", lang("donation_txt_36", true));
                                } else {
                                    $_itemOrder = (array) $_POST["type"];
                                    foreach ($options as $option) {
                                        if ($option["id"] == $_itemOrder) {
                                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_DONATE_MANUAL (AccountID, date, ip, amount, amount_currency, reward, reward_type, gateway, serial, code, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"], $option["amount"], $option["currency"], $option["reward"], mconfig("credit_config"), $gatewayId, $_POST["serial"], $_POST["code"], 0]);
                                            if ($insert) {
                                                message("success", lang("donation_txt_65", true));
                                            } else {
                                                message("error_23", true);
                                            }
                                        }
                                    }
                                }
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        $token = time();
                        $_SESSION["token"] = $token;
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
                        echo "\r\n        <div class=\"row desc-row\">\r\n            <div class=\"col-xs-12\">" . lang("donation_txt_64", true) . "</div>\r\n        </div>\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\r\n                <form name=\"manualdonation\" method=\"post\" action=\"\">\r\n                    <div style=\"padding-top: 20px; padding-bottom: 20px;\">\r\n                        <div class=\"row\">\r\n                            <label for=\"type\">" . sprintf(lang("donation_txt_60", true), mconfig("currency")) . ":</label>\r\n                            <select name=\"type\" class=\"form-control\">\r\n                                <option value=\"\" selected=\"selected\" disabled=\"disabled\">" . lang("donation_txt_34", true) . "</option>\r\n                                " . $selectOptions . "\r\n                            </select>\r\n                        </div>\r\n                        <div class=\"row\">\r\n                            <label for=\"type\">" . lang("donation_txt_61", true) . ":</label>\r\n                            <input type=\"text\" name=\"code\" class=\"form-control\" value=\"\" placeholder=\"Code\" />\r\n                        </div>\r\n                        <div class=\"row\">\r\n                            <label for=\"type\">" . lang("donation_txt_62", true) . ":</label>\r\n                            <input type=\"text\" name=\"serial\" class=\"form-control\" value=\"\" placeholder=\"Serial\" />\r\n                        </div>\r\n                        <div class=\"row\" align=\"right\">\r\n                            <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                            <input type=\"submit\" name=\"submit\" class=\"btn btn-warning make-space\" value=\"" . lang("donation_txt_63", true) . "\">\r\n                        </div>\r\n                    </div>\r\n                </form>\r\n            </div>\r\n        </div>";
                    }
                } else {
                    message("error", lang("error_47", true));
                }
            } else {
                echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\r\n                <div class=\"sub-active-page\">" . $gatewayName . "</div>\r\n                <a href=\"" . __BASE_URL__ . "donation/manualdonation/gateway/" . $_GET["gateway"] . "/?sub=history\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("donation_txt_66", true) . "</a>\r\n                <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\r\n            </div>\r\n        </div>";
                if (mconfig("active")) {
                    if (check_value($_GET["sub"]) && $_GET["sub"] == "history") {
                        $requests = $dB->query_fetch("SELECT TOP 50 * FROM IMPERIAMUCMS_DONATE_MANUAL WHERE AccountID = ? ORDER BY date DESC", [$_SESSION["username"]]);
                        echo "\r\n        <div class=\"account-wide\" align=\"center\">\r\n            <table width=\"100%\" class=\"irq\">\r\n                <thead>\r\n                    <tr>\r\n                        <th align=\"center\">" . lang("donation_txt_67", true) . "</th>\r\n                        <th align=\"center\">" . lang("donation_txt_68", true) . "</th>\r\n                        <th align=\"center\">" . lang("donation_txt_69", true) . "</th>\r\n                        <th align=\"center\">" . lang("donation_txt_70", true) . "</th>\r\n                        <th align=\"center\">" . lang("donation_txt_71", true) . "</th>\r\n                        <th align=\"center\">" . lang("donation_txt_72", true) . "</th>\r\n                        <th align=\"center\">" . lang("donation_txt_73", true) . "</th>\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
                        if (is_array($requests)) {
                            foreach ($requests as $thisRequest) {
                                $status = NULL;
                                $gatewayNameTmp = NULL;
                                $reward_type = NULL;
                                $reward_type = $thisRequest["reward_type"];
                                if ($reward_type == "1") {
                                    $reward_type = lang("currency_platinum", true);
                                } else {
                                    if ($reward_type == "2") {
                                        $reward_type = lang("currency_gold", true);
                                    } else {
                                        if ($reward_type == "3") {
                                            $reward_type = lang("currency_silver", true);
                                        } else {
                                            if ($reward_type == "4") {
                                                $reward_type = lang("currency_wcoinc", true);
                                            } else {
                                                if ($reward_type == "5") {
                                                    $reward_type = lang("currency_gp", true);
                                                } else {
                                                    if ($reward_type == "6") {
                                                        $reward_type = "" . lang("currency_zen", true) . "";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                if ($thisRequest["gateway"] == "1") {
                                    $gatewayNameTmp = "Viettel";
                                } else {
                                    if ($thisRequest["gateway"] == "2") {
                                        $gatewayNameTmp = "Mobifone";
                                    } else {
                                        if ($thisRequest["gateway"] == "3") {
                                            $gatewayNameTmp = "Vinaphone";
                                        }
                                    }
                                }
                                if ($thisRequest["status"] == "0") {
                                    $status = "<span style=\"padding: 5px; border-radius: 2px; background-color: blue; color: white;\">" . lang("donation_txt_75", true) . "</span>";
                                } else {
                                    if ($thisRequest["status"] == "1") {
                                        $status = "<span style=\"padding: 5px; border-radius: 2px; background-color: green; color: white;\">" . lang("donation_txt_76", true) . "</span>";
                                    } else {
                                        if ($thisRequest["status"] == "2") {
                                            $status = "<span style=\"padding: 5px; border-radius: 2px; background-color: #9b0900; color: white;\">" . lang("donation_txt_77", true) . "</span>";
                                        }
                                    }
                                }
                                echo "\r\n                    <tr>\r\n                        <td>" . date($config["time_date_format"], strtotime($thisRequest["date"])) . "</td>\r\n                        <td>" . number_format($thisRequest["amount"]) . " " . $thisRequest["amount_currency"] . "</td>\r\n                        <td>" . number_format($thisRequest["reward"]) . " " . $reward_type . "</td>\r\n                        <td>" . $gatewayNameTmp . "</td>\r\n                        <td>" . $thisRequest["code"] . "</td>\r\n                        <td>" . $thisRequest["serial"] . "</td>\r\n                        <td>" . $status . "</td>\r\n                    </tr>";
                            }
                        } else {
                            echo "\r\n                    <tr>\r\n                        <td colspan=\"7\">" . lang("donation_txt_74", true) . "</td>\r\n                    </tr>";
                        }
                        echo "                \r\n                </tbody>\r\n            </table>\r\n        </div>";
                    } else {
                        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "manualdonation.xml");
                        if ($xml !== false) {
                            $options = [];
                            $selectOptions = "";
                            $selectInfo = "";
                            $i = 1;
                            foreach ($xml->options->children() as $tag => $option) {
                                if ($tag == "option") {
                                    $options[$i]["id"] = intval($option["id"]);
                                    $options[$i]["name"] = strval($option["name"]);
                                    $options[$i]["amount"] = floatval($option["amount"]);
                                    $options[$i]["currency"] = strval($option["currency"]);
                                    $options[$i]["reward"] = floatval($option["reward"]);
                                    $options[$i]["desc"] = strval($option["desc"]);
                                    $selectOptions .= "<option value=\"" . intval($option["id"]) . "\">" . strval($option["name"]) . "</option>";
                                    $i++;
                                }
                            }
                        }
                        if (check_value($_POST["submit"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                if (empty($_POST["type"])) {
                                    message("error", lang("donation_txt_36", true));
                                } else {
                                    $_itemOrder = (array) $_POST["type"];
                                    foreach ($options as $option) {
                                        if ($option["id"] == $_itemOrder) {
                                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_DONATE_MANUAL (AccountID, date, ip, amount, amount_currency, reward, reward_type, gateway, serial, code, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"], $option["amount"], $option["currency"], $option["reward"], mconfig("credit_config"), $gatewayId, $_POST["serial"], $_POST["code"], 0]);
                                            if ($insert) {
                                                message("success", lang("donation_txt_65", true));
                                            } else {
                                                message("error_23", true);
                                            }
                                        }
                                    }
                                }
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                        $token = time();
                        $_SESSION["token"] = $token;
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
                        echo "\r\n        <div class=\"page-desc-holder\">\r\n            " . lang("donation_txt_64", true) . "\r\n        </div>";
                        echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <form name=\"manualdonation\" method=\"post\" action=\"\">\r\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\r\n                    <div class=\"row\">\r\n                        <label for=\"type\">" . sprintf(lang("donation_txt_60", true), mconfig("currency")) . ":</label>\r\n                        <select name=\"type\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\r\n                            <option value=\"\" selected=\"selected\" disabled=\"disabled\">" . lang("donation_txt_34", true) . "</option>\r\n                            " . $selectOptions . "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"row\">\r\n                        <label for=\"type\">" . lang("donation_txt_61", true) . ":</label>\r\n                        <input type=\"text\" name=\"code\" value=\"\" placeholder=\"Code\" />\r\n                    </div>\r\n                    <div class=\"row\">\r\n                        <label for=\"type\">" . lang("donation_txt_62", true) . ":</label>\r\n                        <input type=\"text\" name=\"serial\" value=\"\" placeholder=\"Serial\" />\r\n                    </div>\r\n                    <div class=\"row\" align=\"right\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"submit\" name=\"submit\" value=\"" . lang("donation_txt_63", true) . "\">\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>";
                    }
                } else {
                    message("error", lang("error_47", true));
                }
                echo "\r\n    </div>\r\n</div>";
            }
        }
    }
}

?>