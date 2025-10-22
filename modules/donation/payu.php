<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "donation", "allow")) {
        return NULL;
    }
    $reward_type = mconfig("credit_config");
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
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\n    <h3>\n        " . lang("donation_txt_30", true) . "\n        " . $breadcrumb . "\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("payu");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("payu");
            echo "\n    <div class=\"row desc-row\">\n        <div class=\"col-xs-12\">" . lang("donation_txt_33", true) . "</div>\n    </div>";
            $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.payu.xml");
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
                        $options[$i]["reward"] = floatval($option["reward"]);
                        $options[$i]["desc"] = strval($option["desc"]);
                        $selectOptions .= "<option value=\"" . intval($option["id"]) . "\">" . strval($option["name"]) . "</option>";
                        $i++;
                    }
                }
            }
            if (check_value($_GET["payment_done"])) {
                message("success", lang("donation_txt_41", true));
            }
            if (check_value($_GET["payment_error"])) {
                message("error", sprintf(lang("donation_txt_42", true), $_GET["payment_error"]));
            }
            if (check_value($_POST["proceed"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    if (empty($_POST["type"])) {
                        message("error", lang("donation_txt_36", true));
                    } else {
                        $_itemOrder = (array) $_POST["type"];
                        $_isItemBeeee = false;
                        foreach ($options as $option) {
                            if ($option["id"] == $_itemOrder) {
                                if (config("SQL_USE_2_DB", true)) {
                                    $user_mail = $dB2->query_fetch_single("SELECT mail_addr FROM MEMB_INFO WHERE memb___id = ?", [$_SESSION["username"]]);
                                } else {
                                    $user_mail = $dB->query_fetch_single("SELECT mail_addr FROM MEMB_INFO WHERE memb___id = ?", [$_SESSION["username"]]);
                                }
                                $date = date("Y-m-d H:i:s", time());
                                $insert = $dB->query("INSERT INTO IMPERIAMUCMS_PAYU_LOGS (AccountID, amount, reward, reward_type, sig, createDate, paymentDate, lastStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], $option["amount"], $option["reward"], mconfig("credit_config"), 0, $date, NULL, 1]);
                                $session_id = $dB->query_fetch_single("SELECT TOP 1 id FROM IMPERIAMUCMS_PAYU_LOGS WHERE AccountID = ? AND amount = ? AND reward = ? AND createDate = ? ORDER BY id DESC", [$_SESSION["username"], $option["amount"], $option["reward"], $date]);
                                $_isItemBeeee = true;
                                $currTime = time();
                                $urlParams = "amount=" . urlencode($option["amount"] * 100);
                                $urlParams .= "&client_ip=" . urlencode($_SERVER["REMOTE_ADDR"]);
                                $urlParams .= "&desc=" . urlencode($option["desc"] . " " . lang("donation_txt_37", true) . ": " . $_SESSION["username"] . " " . lang("donation_txt_38", true) . ": " . $option["reward"] . " " . $reward_type);
                                $urlParams .= "&email=" . urlencode($user_mail["mail_addr"]);
                                $urlParams .= "&first_name=";
                                $urlParams .= "&last_name=";
                                $urlParams .= "&pos_auth_key=" . urlencode(mconfig("pos_auth_key"));
                                $urlParams .= "&pos_id=" . urlencode(mconfig("pos_id"));
                                $urlParams .= "&session_id=" . urlencode($session_id["id"]);
                                $urlParams .= "&ts=" . urlencode($currTime);
                                $sig = hash("sha256", $urlParams . "&" . mconfig("second_md5_key"));
                                $dB->query("UPDATE IMPERIAMUCMS_PAYU_LOGS SET sig = ? WHERE id = ?", [$sig, $session_id["id"]]);
                                echo "\n    <div class=\"row\">\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\n            <form action=\"https://secure.payu.com/paygw/UTF/NewPayment\" method=\"POST\" name=\"payform\" accept_charset=\"UTF-8\">\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\n                    <div class=\"row\">\n                        <label for=\"type\">" . lang("donation_txt_37", true) . ":</label>\n                        <input type=\"text\" name=\"username\" class=\"form-control\" value=\"" . $_SESSION["username"] . "\" readonly=\"readonly\" />\n                    </div>\n                    <div class=\"row\">\n                        <label for=\"type\">" . lang("donation_txt_38", true) . ":</label>\n                        <input type=\"text\" name=\"reward\" class=\"form-control\" value=\"" . $option["reward"] . " " . $reward_type . "\" readonly=\"readonly\" />\n                    </div>\n                    <div class=\"row\">\n                        <label for=\"type\">" . lang("donation_txt_39", true) . ":</label>\n                        <input type=\"text\" name=\"price\" class=\"form-control\" value=\"" . sprintf(lang("donation_txt_40", true), number_format($option["amount"], 2, ".", " ")) . "\" readonly=\"readonly\" />\n                    </div>\n                    <div class=\"row\" align=\"right\">\n                        <input type=\"hidden\" name=\"first_name\" value=\"\">\n                        <input type=\"hidden\" name=\"last_name\" value=\"\">\n                        <input type=\"hidden\" name=\"email\" value=\"" . $user_mail["mail_addr"] . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"pos_id\" value=\"" . mconfig("pos_id") . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"pos_auth_key\" value=\"" . mconfig("pos_auth_key") . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"session_id\" value=\"" . $session_id["id"] . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"amount\" value=\"" . $option["amount"] * 100 . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"desc\" value=\"" . $option["desc"] . " " . lang("donation_txt_37", true) . ": " . $_SESSION["username"] . " " . lang("donation_txt_38", true) . ": " . $option["reward"] . " " . $reward_type . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"client_ip\" value=\"" . $_SERVER["REMOTE_ADDR"] . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"ts\" value=\"" . $currTime . "\">\n                        <input type=\"hidden\" name=\"sig\" value=\"" . $sig . "\">\n                        <input type=\"submit\" name=\"checkout\" class=\"btn btn-warning make-space\" value=\"" . lang("donation_txt_31", true) . "\">\n                    </div>\n                </div>\n            </form>\n        </div>\n    </div>";
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
                echo "\n    <div class=\"row\">\n        <div class=\"col-xs-12 col-md-6 col-md-offset-3\">\n            <form name=\"payu\" method=\"post\" action=\"\">\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\n                    <div class=\"row\">\n                        <label for=\"type\">" . lang("donation_txt_32", true) . ":</label>\n                        <select name=\"type\" class=\"form-control\">\n                            <option value=\"\" selected=\"selected\" disabled=\"disabled\">" . lang("donation_txt_34", true) . "</option>\n                            " . $selectOptions . "\n                        </select>\n                    </div>\n                    <div class=\"row\" align=\"right\">\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\n                        <input type=\"submit\" name=\"proceed\" class=\"btn btn-warning make-space\" value=\"" . lang("donation_txt_35", true) . "\">\n                    </div>\n                </div>\n            </form>\n        </div>\n    </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\n<div class=\"sub-page-title\">\n    <div id=\"title\">\n        <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\n    </div>\n</div>\n<div class=\"container_2 account\" align=\"center\">\n    <div class=\"cont-image\">\n        <div class=\"container_3 account_sub_header\">\n            <div class=\"grad\">\n                <div class=\"page-title\"><p>" . lang("donation_txt_3", true) . "</p></div>\n                <div class=\"sub-active-page\">" . lang("donation_txt_30", true) . "</div>\n                <a href=\"" . __BASE_URL__ . "donation\">" . lang("donation_txt_6", true) . "</a>\n            </div>\n        </div>\n        <div class=\"page-desc-holder\">\n            " . lang("donation_txt_33", true) . "\n        </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("payu");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("payu");
            $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "donation.payu.xml");
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
                        $options[$i]["reward"] = floatval($option["reward"]);
                        $options[$i]["desc"] = strval($option["desc"]);
                        $selectOptions .= "<option value=\"" . intval($option["id"]) . "\">" . strval($option["name"]) . "</option>";
                        $i++;
                    }
                }
            }
            if (check_value($_GET["payment_done"])) {
                message("success", lang("donation_txt_41", true));
            }
            if (check_value($_GET["payment_error"])) {
                message("error", sprintf(lang("donation_txt_42", true), $_GET["payment_error"]));
            }
            if (check_value($_POST["proceed"])) {
                if ($_SESSION["token"] == $_POST["token"]) {
                    if (empty($_POST["type"])) {
                        message("error", lang("donation_txt_36", true));
                    } else {
                        $_itemOrder = (array) $_POST["type"];
                        $_isItemBeeee = false;
                        foreach ($options as $option) {
                            if ($option["id"] == $_itemOrder) {
                                if (config("SQL_USE_2_DB", true)) {
                                    $user_mail = $dB2->query_fetch_single("SELECT mail_addr FROM MEMB_INFO WHERE memb___id = ?", [$_SESSION["username"]]);
                                } else {
                                    $user_mail = $dB->query_fetch_single("SELECT mail_addr FROM MEMB_INFO WHERE memb___id = ?", [$_SESSION["username"]]);
                                }
                                $date = date("Y-m-d H:i:s", time());
                                $insert = $dB->query("INSERT INTO IMPERIAMUCMS_PAYU_LOGS (AccountID, amount, reward, reward_type, sig, createDate, paymentDate, lastStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$_SESSION["username"], $option["amount"], $option["reward"], mconfig("credit_config"), 0, $date, NULL, 1]);
                                $session_id = $dB->query_fetch_single("SELECT TOP 1 id FROM IMPERIAMUCMS_PAYU_LOGS WHERE AccountID = ? AND amount = ? AND reward = ? AND createDate = ? ORDER BY id DESC", [$_SESSION["username"], $option["amount"], $option["reward"], $date]);
                                $_isItemBeeee = true;
                                $currTime = time();
                                $urlParams = "amount=" . urlencode($option["amount"] * 100);
                                $urlParams .= "&client_ip=" . urlencode($_SERVER["REMOTE_ADDR"]);
                                $urlParams .= "&desc=" . urlencode($option["desc"] . " " . lang("donation_txt_37", true) . ": " . $_SESSION["username"] . " " . lang("donation_txt_38", true) . ": " . $option["reward"] . " " . $reward_type);
                                $urlParams .= "&email=" . urlencode($user_mail["mail_addr"]);
                                $urlParams .= "&first_name=";
                                $urlParams .= "&last_name=";
                                $urlParams .= "&pos_auth_key=" . urlencode(mconfig("pos_auth_key"));
                                $urlParams .= "&pos_id=" . urlencode(mconfig("pos_id"));
                                $urlParams .= "&session_id=" . urlencode($session_id["id"]);
                                $urlParams .= "&ts=" . urlencode($currTime);
                                $sig = hash("sha256", $urlParams . "&" . mconfig("second_md5_key"));
                                $dB->query("UPDATE IMPERIAMUCMS_PAYU_LOGS SET sig = ? WHERE id = ?", [$sig, $session_id["id"]]);
                                echo "\n        <div class=\"container_3 account-wide\" align=\"center\">\n            <form action=\"https://secure.payu.com/paygw/UTF/NewPayment\" method=\"POST\" name=\"payform\" accept_charset=\"UTF-8\">\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\n                    <div class=\"row\">\n                        <label for=\"type\">" . lang("donation_txt_37", true) . ":</label>\n                        <input type=\"text\" name=\"username\" value=\"" . $_SESSION["username"] . "\" readonly=\"readonly\" />\n                    </div>\n                    <div class=\"row\">\n                        <label for=\"type\">" . lang("donation_txt_38", true) . ":</label>\n                        <input type=\"text\" name=\"reward\" value=\"" . $option["reward"] . " " . $reward_type . "\" readonly=\"readonly\" />\n                    </div>\n                    <div class=\"row\">\n                        <label for=\"type\">" . lang("donation_txt_39", true) . ":</label>\n                        <input type=\"text\" name=\"price\" value=\"" . sprintf(lang("donation_txt_40", true), number_format($option["amount"], 2, ".", " ")) . "\" readonly=\"readonly\" />\n                    </div>\n                    <div class=\"row\" align=\"right\">\n                        <input type=\"hidden\" name=\"first_name\" value=\"\">\n                        <input type=\"hidden\" name=\"last_name\" value=\"\">\n                        <input type=\"hidden\" name=\"email\" value=\"" . $user_mail["mail_addr"] . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"pos_id\" value=\"" . mconfig("pos_id") . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"pos_auth_key\" value=\"" . mconfig("pos_auth_key") . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"session_id\" value=\"" . $session_id["id"] . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"amount\" value=\"" . $option["amount"] * 100 . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"desc\" value=\"" . $option["desc"] . " " . lang("donation_txt_37", true) . ": " . $_SESSION["username"] . " " . lang("donation_txt_38", true) . ": " . $option["reward"] . " " . $reward_type . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"client_ip\" value=\"" . $_SERVER["REMOTE_ADDR"] . "\">\n\t\t\t\t\t\t<input type=\"hidden\" name=\"ts\" value=\"" . $currTime . "\">\n                        <input type=\"hidden\" name=\"sig\" value=\"" . $sig . "\">\n                        <input type=\"submit\" name=\"checkout\" value=\"" . lang("donation_txt_31", true) . "\">\n                    </div>\n                </div>\n            </form>\n            <div style=\"padding-bottom: 20px;\">\n                <p>" . $selectInfo . "</p>\n            </div>\n        </div>";
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
                echo "\n        <div class=\"container_3 account-wide\" align=\"center\">\n            <form name=\"payu\" method=\"post\" action=\"\">\n                <div style=\"padding-top: 20px; padding-bottom: 20px;\">\n                    <div class=\"row\">\n                        <label for=\"type\">" . lang("donation_txt_32", true) . ":</label>\n                        <select name=\"type\" styled=\"true\" id=\"select-style-2\" style=\"display: none;\">\n                            <option value=\"\" selected=\"selected\" disabled=\"disabled\">" . lang("donation_txt_34", true) . "</option>\n                            " . $selectOptions . "\n                        </select>\n                    </div>\n                    <div class=\"row\" align=\"right\">\n                        <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\n                        <input type=\"submit\" name=\"proceed\" value=\"" . lang("donation_txt_35", true) . "\">\n                    </div>\n                </div>\n            </form>\n            <div style=\"padding-bottom: 20px;\">\n                <p>" . $selectInfo . "</p>\n            </div>\n        </div>";
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\n    </div>\n</div>";
    }
}

?>