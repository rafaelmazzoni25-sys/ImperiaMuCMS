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
        echo "\r\n    <h3>\r\n        " . lang("donation_txt_58", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("nganluong");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("nganluong");
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">" . lang("donation_txt_59", true) . "</div>\r\n    </div>";
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
            $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.nganluong.xml");
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
                                require_once __PATH_INCLUDES__ . "libs/nganluong/lib/nusoap.php";
                                require_once __PATH_INCLUDES__ . "libs/nganluong/nganluong.microcheckout.class.php";
                                $items = [];
                                $items[0] = ["item_name" => $option["name"], "item_quanty" => 1, "item_amount" => $option["amount"]];
                                $return_url = __BASE_URL__ . "api/nganluong.php";
                                $cancel_url = __BASE_URL__ . "donation/nganluong/";
                                $inputs = ["receiver" => mconfig("receiver"), "order_code" => date("Y-m-d-H-i-s") . "-" . $_SESSION["username"], "amount" => $option["amount"], "currency_code" => $option["currency"], "tax_amount" => "0", "discount_amount" => "0", "fee_shipping" => "0", "request_confirm_shipping" => "0", "no_shipping" => "1", "return_url" => $return_url, "cancel_url" => $cancel_url, "language" => "vi", "items" => $items];
                                $link_checkout = "";
                                $obj = new NL_MicroCheckout(mconfig("merchant_id"), mconfig("merchant_pass"), mconfig("url_ws"));
                                $result = $obj->setExpressCheckoutPayment($inputs);
                                if ($result) {
                                    if ($result["result_code"] == "00") {
                                        $link_checkout = $result["link_checkout"];
                                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_DONATE_NGANLUONG ([AccountID],[date],[ip],[package_id],[amount],[amount_currency],[reward],[reward_type],[order_code],[status])\r\n                                              VALUES (?,?,?,?,?,?,?,?,?,?)", [$_SESSION["username"], date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"], $option["id"], $option["amount"], $option["currency"], $option["reward"], mconfig("credit_config"), $inputs["order_code"], 0]);
                                        if (!$insert) {
                                            message("error", lang("donation_txt_51", true));
                                        }
                                        echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\r\n            <form name=\"nganluong\" method=\"post\" action=\"\">\r\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\r\n                    <div class=\"row\">\r\n                        <label for=\"type\">" . lang("donation_txt_47", true) . ":</label>\r\n                        <input type=\"text\" class=\"form-control\" value=\"" . $option["name"] . "\" readonly=\"readonly\" />\r\n                    </div>\r\n                    <div class=\"row\">\r\n                        <label for=\"type\">" . lang("donation_txt_48", true) . ":</label>\r\n                        <input type=\"text\" class=\"form-control\" value=\"" . $option["amount"] . " " . strtoupper($option["currency"]) . "\" readonly=\"readonly\" />\r\n                    </div>\r\n                    <div class=\"row\">\r\n                        <label for=\"type\">" . lang("donation_txt_49", true) . ":</label>\r\n                        <input type=\"text\" class=\"form-control\" value=\"" . $option["reward"] . " " . $price_type . "\" readonly=\"readonly\" />\r\n                    </div>\r\n                    <div class=\"row\" align=\"right\">\r\n                        <input type=\"button\" class=\"btn btn-warning make-space\" id=\"btn_payment\" value=\"" . lang("donation_txt_35", true) . "\">\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
                                        echo "\r\n                        <script language=\"javascript\" src=\"" . __PATH_TEMPLATE__ . "js/nganluong.apps.mcflow.js\"></script>\r\n                        <script language=\"javascript\">\r\n                        var mc_flow = new NGANLUONG.apps.MCFlow({trigger: 'btn_payment', url: '" . $link_checkout . "'});\r\n                        </script>";
                                    } else {
                                        exit("Mã lỗi " . $result["result_code"] . " (" . $result["result_description"] . ") ");
                                    }
                                } else {
                                    exit("Lỗi kết nối tới cổng thanh toán Ngân Lượng");
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
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\r\n            <form name=\"nganluong\" method=\"post\" action=\"\">\r\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\r\n                    <div class=\"row\">\r\n                        <label for=\"type\">" . lang("donation_txt_32", true) . ":</label>\r\n                        <select name=\"type\" class=\"form-control\">\r\n                            <option value=\"\" selected=\"selected\" disabled=\"disabled\">" . lang("donation_txt_34", true) . "</option>\r\n                            " . $selectOptions . "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"row\" align=\"right\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"submit\" name=\"proceed\" class=\"btn btn-warning make-space\" value=\"" . lang("donation_txt_45", true) . "\">\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\r\n                <div class=\"sub-active-page\">" . lang("donation_txt_58", true) . "</div>\r\n                <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\r\n            </div>\r\n        </div>\r\n        <div class=\"page-desc-holder\">" . lang("donation_txt_59", true) . "</div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("nganluong");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("nganluong");
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
            $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.nganluong.xml");
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
                                require_once __PATH_INCLUDES__ . "libs/nganluong/lib/nusoap.php";
                                require_once __PATH_INCLUDES__ . "libs/nganluong/nganluong.microcheckout.class.php";
                                $items = [];
                                $items[0] = ["item_name" => $option["name"], "item_quanty" => 1, "item_amount" => $option["amount"]];
                                $return_url = __BASE_URL__ . "api/nganluong.php";
                                $cancel_url = __BASE_URL__ . "donation/nganluong/";
                                $inputs = ["receiver" => mconfig("receiver"), "order_code" => date("Y-m-d-H-i-s") . "-" . $_SESSION["username"], "amount" => $option["amount"], "currency_code" => $option["currency"], "tax_amount" => "0", "discount_amount" => "0", "fee_shipping" => "0", "request_confirm_shipping" => "0", "no_shipping" => "1", "return_url" => $return_url, "cancel_url" => $cancel_url, "language" => "vi", "items" => $items];
                                $link_checkout = "";
                                $obj = new NL_MicroCheckout(mconfig("merchant_id"), mconfig("merchant_pass"), mconfig("url_ws"));
                                $result = $obj->setExpressCheckoutPayment($inputs);
                                if ($result) {
                                    if ($result["result_code"] == "00") {
                                        $link_checkout = $result["link_checkout"];
                                        $insert = $dB->query("INSERT INTO IMPERIAMUCMS_DONATE_NGANLUONG ([AccountID],[date],[ip],[package_id],[amount],[amount_currency],[reward],[reward_type],[order_code],[status])\r\n                                              VALUES (?,?,?,?,?,?,?,?,?,?)", [$_SESSION["username"], date("Y-m-d H:i:s", time()), $_SERVER["REMOTE_ADDR"], $option["id"], $option["amount"], $option["currency"], $option["reward"], mconfig("credit_config"), $inputs["order_code"], 0]);
                                        if (!$insert) {
                                            message("error", lang("donation_txt_51", true));
                                        }
                                        echo "\r\n                        <div class=\"container_3 account-wide\" align=\"center\">\r\n                            <form name=\"nganluong\" method=\"post\" action=\"\">\r\n                                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\r\n                                    <div class=\"row\">\r\n                                        <label for=\"type\">" . lang("donation_txt_47", true) . ":</label>\r\n                                        <input type=\"text\" value=\"" . $option["name"] . "\" readonly=\"readonly\" />\r\n                                    </div>\r\n                                    <div class=\"row\">\r\n                                        <label for=\"type\">" . lang("donation_txt_48", true) . ":</label>\r\n                                        <input type=\"text\" value=\"" . $option["amount"] . " " . strtoupper($option["currency"]) . "\" readonly=\"readonly\" />\r\n                                    </div>\r\n                                    <div class=\"row\">\r\n                                        <label for=\"type\">" . lang("donation_txt_49", true) . ":</label>\r\n                                        <input type=\"text\" value=\"" . $option["reward"] . " " . $price_type . "\" readonly=\"readonly\" />\r\n                                    </div>\r\n                                    <div class=\"row\" align=\"right\">\r\n                                        <input type=\"button\" class=\"simple_button\" id=\"btn_payment\" value=\"" . lang("donation_txt_35", true) . "\">\r\n                                    </div>\r\n                                </div>\r\n                            </form>\r\n                            <div style=\"padding-bottom: 20px;\">\r\n                                <p>" . $selectInfo . "</p>\r\n                            </div>\r\n                        </div>";
                                        echo "\r\n                        <script language=\"javascript\" src=\"" . __PATH_TEMPLATE__ . "js/nganluong.apps.mcflow.js\"></script>\r\n                        <script language=\"javascript\">\r\n                        var mc_flow = new NGANLUONG.apps.MCFlow({trigger: 'btn_payment', url: '" . $link_checkout . "'});\r\n                        </script>";
                                    } else {
                                        exit("Mã lỗi " . $result["result_code"] . " (" . $result["result_description"] . ") ");
                                    }
                                } else {
                                    exit("Lỗi kết nối tới cổng thanh toán Ngân Lượng");
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
                echo "\r\n        <div class=\"container_3 account-wide\" align=\"center\">\r\n            <form name=\"nganluong\" method=\"post\" action=\"\">\r\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\r\n                    <div class=\"row\">\r\n                        <label for=\"type\">" . lang("donation_txt_32", true) . ":</label>\r\n                        <select name=\"type\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\r\n                            <option value=\"\" selected=\"selected\" disabled=\"disabled\">" . lang("donation_txt_34", true) . "</option>\r\n                            " . $selectOptions . "\r\n                        </select>\r\n                    </div>\r\n                    <div class=\"row\" align=\"right\">\r\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                        <input type=\"submit\" name=\"proceed\" value=\"" . lang("donation_txt_45", true) . "\">\r\n                    </div>\r\n                </div>\r\n            </form>\r\n            <div style=\"padding-bottom: 20px;\">\r\n                <p>" . $selectInfo . "</p>\r\n            </div>\r\n        </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n</div>";
    }
}

?>