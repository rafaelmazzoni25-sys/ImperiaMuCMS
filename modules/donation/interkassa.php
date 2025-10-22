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
        echo "\r\n    <h3>\r\n        " . lang("donation_txt_44", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("interkassa");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("interkassa");
            include __PATH_INCLUDES__ . "libs/Interkassa/interkassa.php";
            Interkassa::register();
            $shop_id = mconfig("shop_id");
            if (mconfig("enable_sandbox")) {
                $secret_key = mconfig("test_key");
            } else {
                $secret_key = mconfig("secret_key");
            }
            $shop = Interkassa_Shop::factory(["id" => $shop_id, "secret_key" => $secret_key]);
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
            if (check_value($_GET["op"]) && $_GET["op"] == "success") {
                message("success", lang("donation_txt_41", true));
            } else {
                if (check_value($_GET["op"]) && $_GET["op"] == "fail") {
                    message("error", lang("donation_txt_50", true));
                } else {
                    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.interkassa.xml");
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
                    if (check_value($_POST["proceed"])) {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            if (empty($_POST["type"])) {
                                message("error", lang("donation_txt_36", true));
                            } else {
                                $_itemOrder = (array) $_POST["type"];
                                foreach ($options as $option) {
                                    if ($option["id"] == $_itemOrder) {
                                        echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\r\n            <div class=\"table-responsive rankings-table\">\r\n                <table class=\"table table-hover text-center\">\r\n                    <tr>\r\n                    <td width=\"50%\">" . lang("donation_txt_47", true) . "</td>\r\n                    <td width=\"50%\">" . $option["name"] . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("donation_txt_48", true) . "</td>\r\n                    <td>" . $option["amount"] . " " . $option["currency"] . "</td>\r\n                </tr>\r\n                <tr>\r\n                    <td>" . lang("donation_txt_49", true) . "</td>\r\n                    <td>" . $option["reward"] . " " . $price_type . "</td>\r\n                </tr>\r\n                </table>\r\n            </div>";
                                        $payment_id = $_SESSION["token"] . "_" . $_SESSION["userid"];
                                        $payment_amount = $option["amount"];
                                        $payment_desc = $option["desc"];
                                        $payment = $shop->createPayment(["id" => $payment_id, "amount" => $payment_amount, "description" => $payment_desc, "currency" => $option["currency"]]);
                                        $payment->setBaggage($option["id"]);
                                        $payment->setStatusUrl(__BASE_URL__ . "api/interkassa.php");
                                        $payment->setStatusMethod(METHOD_POST);
                                        $payment->setSuccessUrl(__BASE_URL__ . "donation/interkassa?op=success");
                                        $payment->setSuccessMethod(Interkassa::METHOD_GET);
                                        $payment->setFailUrl(__BASE_URL__ . "donation/interkassa?op=fail");
                                        $payment->setFailMethod(Interkassa::METHOD_GET);
                                        $dataSet = [];
                                        echo "                                <form action=\"";
                                        echo $payment->getFormAction();
                                        echo "\" method=\"post\">\r\n                                    ";
                                        foreach ($payment->getFormValues() as $field => $value) {
                                            echo "<input type=\"hidden\" name=\"" . $field . "\" value=\"" . $value . "\"/>";
                                            $dataSet[$field] = $value;
                                        }
                                        if (mconfig("enable_signature")) {
                                            ksort($dataSet, SORT_STRING);
                                            array_push($dataSet, $secret_key);
                                            $signString = implode(":", $dataSet);
                                            $sign = base64_encode(md5($signString, true));
                                            echo "<input type=\"hidden\" name=\"ik_sign\" value=\"" . $sign . "\" />";
                                        } else {
                                            $sign = NULL;
                                        }
                                        echo "                                    <input type=\"submit\" class=\"btn btn-warning btn-right make-space\" value=\"";
                                        echo lang("donation_txt_46", true);
                                        echo "\">\r\n                                </form>\r\n                                </div>\r\n                                </div>\r\n\r\n                                ";
                                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_DONATE_INTERKASSA ([AccountID],[date],[ip],[package_id],[amount],[amount_currency],[reward],[reward_type],[checkout_id],[payment_id],[invoice_id],[invoice_created],[invoice_processed],[transaction_id],[paid_with],[signature],[status])\r\n                                                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$_SESSION["username"], date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"], $option["id"], $option["amount"], $option["currency"], $option["reward"], mconfig("credit_config"), NULL, $payment_id, NULL, NULL, NULL, NULL, NULL, $sign, 0]);
                                        if (!$insert) {
                                            message("error", lang("donation_txt_51", true));
                                        }
                                    }
                                }
                            }
                        } else {
                            message("notice", lang("global_module_13", true));
                        }
                        $token = time();
                        $_SESSION["token"] = $token;
                    } else {
                        $token = time();
                        $_SESSION["token"] = $token;
                        echo "\r\n        <div class=\"row\">\r\n            <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\r\n                <form name=\"interkassa\" method=\"post\" action=\"\">\r\n                    <div class=\"row\">\r\n                        <label for=\"type\">" . lang("donation_txt_32", true) . ":</label>\r\n                        <select name=\"type\" class=\"form-control\">\r\n                            <option value=\"\" selected=\"selected\" disabled=\"disabled\">" . lang("donation_txt_34", true) . "</option>\r\n                            " . $selectOptions . "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"row\" align=\"right\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"submit\" name=\"proceed\" class=\"btn btn-warning make-space\" value=\"" . lang("donation_txt_45", true) . "\">\r\n                    </div>\r\n                </form>\r\n                <div style=\"padding-bottom: 20px;\">\r\n                    <p>" . $selectInfo . "</p>\r\n                </div>\r\n            </div>\r\n        </div>";
                    }
                }
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\r\n                <div class=\"sub-active-page\">" . lang("donation_txt_44", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">";
        echo "\r\n        </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("interkassa");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("interkassa");
            include __PATH_INCLUDES__ . "libs/Interkassa/interkassa.php";
            Interkassa::register();
            $shop_id = mconfig("shop_id");
            if (mconfig("enable_sandbox")) {
                $secret_key = mconfig("test_key");
            } else {
                $secret_key = mconfig("secret_key");
            }
            $shop = Interkassa_Shop::factory(["id" => $shop_id, "secret_key" => $secret_key]);
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
            if (!(check_value($_GET["op"]) && $_GET["op"] == "status")) {
                if (check_value($_GET["op"]) && $_GET["op"] == "success") {
                    message("success", lang("donation_txt_41", true));
                } else {
                    if (check_value($_GET["op"]) && $_GET["op"] == "fail") {
                        message("error", lang("donation_txt_50", true));
                    } else {
                        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.interkassa.xml");
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
                        if (check_value($_POST["proceed"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                if (empty($_POST["type"])) {
                                    message("error", lang("donation_txt_36", true));
                                } else {
                                    $_itemOrder = (array) $_POST["type"];
                                    foreach ($options as $option) {
                                        if ($option["id"] == $_itemOrder) {
                                            echo "\r\n                            <table width=\"70%\" align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"3\">\r\n                                <tr>\r\n                                    <td width=\"50%\" align=\"right\">" . lang("donation_txt_47", true) . ":</td>\r\n                                    <td width=\"50%\">" . $option["name"] . "</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td align=\"right\">" . lang("donation_txt_48", true) . ":</td>\r\n                                    <td>" . $option["amount"] . " " . $option["currency"] . "</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td align=\"right\">" . lang("donation_txt_49", true) . ":</td>\r\n                                    <td>" . $option["reward"] . " " . $price_type . "</td>\r\n                                </tr>\r\n                            </table>";
                                            $payment_id = $_SESSION["token"] . "_" . $_SESSION["userid"];
                                            $payment_amount = $option["amount"];
                                            $payment_desc = $option["desc"];
                                            $payment = $shop->createPayment(["id" => $payment_id, "amount" => $payment_amount, "description" => $payment_desc, "currency" => $option["currency"]]);
                                            $payment->setBaggage($option["id"]);
                                            $payment->setStatusUrl(__BASE_URL__ . "api/interkassa.php");
                                            $payment->setStatusMethod(METHOD_POST);
                                            $payment->setSuccessUrl(__BASE_URL__ . "donation/interkassa?op=success");
                                            $payment->setSuccessMethod(Interkassa::METHOD_GET);
                                            $payment->setFailUrl(__BASE_URL__ . "donation/interkassa?op=fail");
                                            $payment->setFailMethod(Interkassa::METHOD_GET);
                                            $dataSet = [];
                                            echo "                                <form action=\"";
                                            echo $payment->getFormAction();
                                            echo "\" method=\"post\">\r\n                                    ";
                                            foreach ($payment->getFormValues() as $field => $value) {
                                                echo "<input type=\"hidden\" name=\"" . $field . "\" value=\"" . $value . "\"/>";
                                                $dataSet[$field] = $value;
                                            }
                                            if (mconfig("enable_signature")) {
                                                ksort($dataSet, SORT_STRING);
                                                array_push($dataSet, $secret_key);
                                                $signString = implode(":", $dataSet);
                                                $sign = base64_encode(md5($signString, true));
                                                echo "<input type=\"hidden\" name=\"ik_sign\" value=\"" . $sign . "\" />";
                                            } else {
                                                $sign = NULL;
                                            }
                                            echo "                                    <input type=\"submit\" value=\"";
                                            echo lang("donation_txt_46", true);
                                            echo "\">\r\n                                </form>\r\n                                ";
                                            $insert = $dB->query("INSERT INTO IMPERIAMUCMS_DONATE_INTERKASSA ([AccountID],[date],[ip],[package_id],[amount],[amount_currency],[reward],[reward_type],[checkout_id],[payment_id],[invoice_id],[invoice_created],[invoice_processed],[transaction_id],[paid_with],[signature],[status])\r\n                                                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$_SESSION["username"], date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"], $option["id"], $option["amount"], $option["currency"], $option["reward"], mconfig("credit_config"), NULL, $payment_id, NULL, NULL, NULL, NULL, NULL, $sign, 0]);
                                            if (!$insert) {
                                                message("error", lang("donation_txt_51", true));
                                            }
                                        }
                                    }
                                }
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                            $token = time();
                            $_SESSION["token"] = $token;
                        } else {
                            $token = time();
                            $_SESSION["token"] = $token;
                            echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <form name=\"interkassa\" method=\"post\" action=\"\">\r\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\r\n                    <div class=\"row\">\r\n                        <label for=\"type\">" . lang("donation_txt_32", true) . ":</label>\r\n                        <select name=\"type\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\r\n                            <option value=\"\" selected=\"selected\" disabled=\"disabled\">" . lang("donation_txt_34", true) . "</option>\r\n                            " . $selectOptions . "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"row\" align=\"right\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"submit\" name=\"proceed\" value=\"" . lang("donation_txt_45", true) . "\">\r\n                    </div>\r\n                </div>\r\n            </form>\r\n            <div style=\"padding-bottom: 20px;\">\r\n                <p>" . $selectInfo . "</p>\r\n            </div>\r\n        </div>";
                        }
                    }
                }
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n</div>";
    }
}

?>