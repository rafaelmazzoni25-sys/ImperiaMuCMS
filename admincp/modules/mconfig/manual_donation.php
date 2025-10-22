<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <table width=\"100%\" style=\"margin-bottom: 12px;\">\r\n        <tr>\r\n            <td><h2>Nạp thẻ Cào Settings</h2></td>\r\n            <td align=\"right\">\r\n                <a href=\"";
echo admincp_base("modules_manager&config=manual_donation");
echo "\" class=\"btn btn-primary\">Settings</a>&nbsp;\r\n                <a href=\"";
echo admincp_base("modules_manager&config=manual_donation&sub=reviewed");
echo "\" class=\"btn btn-primary\">Reviewed Requests</a>&nbsp;\r\n                <a href=\"";
echo admincp_base("modules_manager&config=manual_donation&sub=pending");
echo "\" class=\"btn btn-primary\">Pending Requests</a>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n\r\n";
if (check_value($_GET["sub"])) {
    if ($_GET["sub"] == "pending") {
        if (check_value($_GET["approve"]) && is_numeric($_GET["approve"])) {
            $check = $dB->query_fetch_single("SELECT status, AccountID, reward, reward_type FROM IMPERIAMUCMS_DONATE_MANUAL WHERE id = ?", [$_GET["approve"]]);
            if ($check["status"] == "0") {
                try {
                    $user_id = $common->retrieveUserID($check["AccountID"]);
                    if (!Validator::UnsignedNumber($user_id)) {
                        throw new Exception("invalid userid");
                    }
                    $accountInfo = $common->accountInformation($user_id);
                    if (!is_array($accountInfo)) {
                        throw new Exception("invalid account");
                    }
                    $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                    $creditSystem->setConfigId($check["reward_type"]);
                    $configSettings = $creditSystem->showConfigs(true);
                    switch ($configSettings["config_user_col_id"]) {
                        case "userid":
                            $creditSystem->setIdentifier($accountInfo[_CLMN_MEMBID_]);
                            break;
                        case "username":
                            $creditSystem->setIdentifier($accountInfo[_CLMN_USERNM_]);
                            break;
                        case "email":
                            $creditSystem->setIdentifier($accountInfo[_CLMN_EMAIL_]);
                            $creditSystem->addCredits($check["reward"]);
                            $update = $dB->query("UPDATE IMPERIAMUCMS_DONATE_MANUAL SET status = ? WHERE id = ?", [1, $_GET["approve"]]);
                            if ($update) {
                                message("success", "User " . $check["AccountID"] . " has been rewarded successfully.");
                            } else {
                                message("error", "We could not update status of the request.");
                            }
                            break;
                        default:
                            throw new Exception("invalid identifier");
                    }
                } catch (Exception $ex) {
                    message("error", "Exception: " . $ex);
                }
            } else {
                message("error", "This request was already approved or denied.");
            }
        } else {
            if (check_value($_GET["deny"]) && is_numeric($_GET["deny"])) {
                $check = $dB->query_fetch_single("SELECT status, AccountID, reward, reward_type FROM IMPERIAMUCMS_DONATE_MANUAL WHERE id = ?", [$_GET["deny"]]);
                if ($check["status"] == "0") {
                    $update = $dB->query("UPDATE IMPERIAMUCMS_DONATE_MANUAL SET status = ? WHERE id = ?", [2, $_GET["deny"]]);
                    if ($update) {
                        message("success", "User " . $check["AccountID"] . " has been denied successfully.");
                    } else {
                        message("error", "We could not update status of the request.");
                    }
                } else {
                    message("error", "This request was already approved or denied.");
                }
            }
        }
        $requests = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_DONATE_MANUAL WHERE status = ? ORDER BY date ASC", [0]);
        echo "\r\n        <table class=\"table table-striped table-bordered table-hover\">\r\n            <tr>\r\n                <td>Date</td>\r\n                <td>AccountID</td>\r\n                <td>Amount</td>\r\n                <td>Reward</td>\r\n                <td>Gateway</td>\r\n                <td>Code</td>\r\n                <td>Serial</td>\r\n                <td>Status</td>\r\n                <td>Action</td>\r\n            </tr>";
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
                                        $reward_type = "Zen";
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
                echo "\r\n                <tr>\r\n                    <td>" . date($config["time_date_format"], strtotime($thisRequest["date"])) . "</td>\r\n                    <td>" . $thisRequest["AccountID"] . "</td>\r\n                    <td>" . number_format($thisRequest["amount"]) . " " . $thisRequest["amount_currency"] . "</td>\r\n                    <td>" . number_format($thisRequest["reward"]) . " " . $reward_type . "</td>\r\n                    <td>" . $gatewayNameTmp . "</td>\r\n                    <td>" . $thisRequest["code"] . "</td>\r\n                    <td>" . $thisRequest["serial"] . "</td>\r\n                    <td>" . $status . "</td>\r\n                    <td>\r\n                        <div class=\"btn-group\">\r\n                            <a class=\"btn dropdown-toggle btn btn-default\" data-toggle=\"dropdown\" href=\"#\">Change Status <span class=\"caret\"></span></a>\r\n                            <ul class=\"dropdown-menu\">\r\n                                <li><a href=\"" . admincp_base("modules_manager&config=manual_donation&sub=pending&approve=" . $thisRequest["id"]) . "\"><span style=\"padding: 5px; border-radius: 2px; background-color: green; color: white;\">Approve</span></a></li>\r\n                                <li><a href=\"" . admincp_base("modules_manager&config=manual_donation&sub=pending&deny=" . $thisRequest["id"]) . "\"><span style=\"padding: 5px; border-radius: 2px; background-color: #9b0900; color: white;\">Deny</span></a></li>\r\n                            </ul>\r\n                        </div>\r\n                    </td>\r\n                </tr>";
            }
        } else {
            echo "\r\n            <tr>\r\n                <td colspan=\"9\">No requests found.</td>\r\n            </tr>";
        }
        echo "\r\n        </table>";
    } else {
        if ($_GET["sub"] == "reviewed") {
            $requests = $dB->query_fetch("SELECT TOP 200 * FROM IMPERIAMUCMS_DONATE_MANUAL WHERE status = ? OR status = ? ORDER BY date DESC", [1, 2]);
            echo "\r\n        <table class=\"table table-striped table-bordered table-hover\">\r\n            <tr>\r\n                <td>Date</td>\r\n                <td>AccountID</td>\r\n                <td>Amount</td>\r\n                <td>Reward</td>\r\n                <td>Gateway</td>\r\n                <td>Code</td>\r\n                <td>Serial</td>\r\n                <td>Status</td>\r\n            </tr>";
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
                                            $reward_type = "Zen";
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
                    echo "\r\n                <tr>\r\n                    <td>" . date($config["time_date_format"], strtotime($thisRequest["date"])) . "</td>\r\n                    <td>" . $thisRequest["AccountID"] . "</td>\r\n                    <td>" . number_format($thisRequest["amount"]) . " " . $thisRequest["amount_currency"] . "</td>\r\n                    <td>" . number_format($thisRequest["reward"]) . " " . $reward_type . "</td>\r\n                    <td>" . $gatewayNameTmp . "</td>\r\n                    <td>" . $thisRequest["code"] . "</td>\r\n                    <td>" . $thisRequest["serial"] . "</td>\r\n                    <td>" . $status . "</td>\r\n                </tr>";
                }
            } else {
                echo "\r\n            <tr>\r\n                <td colspan=\"9\">No requests found.</td>\r\n            </tr>";
            }
        }
    }
} else {
    function saveChanges()
    {
        
        foreach ($_POST as $setting) {
            if (!check_value($setting)) {
                message("error", "Missing data (complete all fields).");
                return NULL;
            }
        }
        $xmlPath = __PATH_MODULE_CONFIGS__ . "manualdonation.xml";
        $xml = simplexml_load_file($xmlPath);
        $xml->active = $_POST["active"];
        $xml->enable_viettel = $_POST["enable_viettel"];
        $xml->enable_mobifone = $_POST["enable_mobifone"];
        $xml->enable_vinaphone = $_POST["enable_vinaphone"];
        $xml->credit_config = $_POST["credit_config"];
        $save = $xml->asXML($xmlPath);
        if ($save) {
            message("success", "Settings successfully saved.");
        } else {
            message("error", "There has been an error while saving changes.");
        }
    }
    function arrayToXML($array)
    {
        $sxe = new SimpleXMLElement("<settings/>");
        $sxe->addChild("active", $array["active"]);
        $sxe->addChild("enable_viettel", $array["enable_viettel"]);
        $sxe->addChild("enable_mobifone", $array["enable_mobifone"]);
        $sxe->addChild("enable_vinaphone", $array["enable_vinaphone"]);
        $sxe->addChild("credit_config", $array["credit_config"]);
        $options = $sxe->addChild("options");
        foreach ($array["options"] as $thisOpt) {
            $option = $options->addChild("option");
            $option->addAttribute("id", $thisOpt["id"]);
            $option->addAttribute("name", $thisOpt["name"]);
            $option->addAttribute("amount", $thisOpt["amount"]);
            $option->addAttribute("currency", $thisOpt["currency"]);
            $option->addAttribute("reward", $thisOpt["reward"]);
            $option->addAttribute("desc", $thisOpt["desc"]);
        }
        return $sxe->asXML();
    }
    if (check_value($_POST["submit_changes"])) {
        saveChanges();
    }
    if (check_value($_POST["package_add_submit"])) {
        if (check_value($_POST["id"]) && check_value($_POST["name"]) && check_value($_POST["amount"]) && check_value($_POST["reward"]) && check_value($_POST["desc"])) {
            $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "manualdonation.xml");
            if ($xml !== false) {
                $array = [];
                $array["active"] = trim($xml->active);
                $array["enable_viettel"] = trim($xml->enable_viettel);
                $array["enable_mobifone"] = trim($xml->enable_mobifone);
                $array["enable_vinaphone"] = trim($xml->enable_vinaphone);
                $array["credit_config"] = trim($xml->credit_config);
                $i = 1;
                foreach ($xml->options->children() as $tag => $option) {
                    if ($tag == "option") {
                        $array["options"][$i]["id"] = intval($option["id"]);
                        $array["options"][$i]["name"] = strval($option["name"]);
                        $array["options"][$i]["amount"] = floatval($option["amount"]);
                        $array["options"][$i]["currency"] = strval($option["currency"]);
                        $array["options"][$i]["reward"] = intval($option["reward"]);
                        $array["options"][$i]["desc"] = strval($option["desc"]);
                        $i++;
                    }
                }
                $array["options"][$i]["id"] = intval($_POST["id"]);
                $array["options"][$i]["name"] = strval($_POST["name"]);
                $array["options"][$i]["amount"] = floatval($_POST["amount"]);
                $array["options"][$i]["currency"] = strval($_POST["currency"]);
                $array["options"][$i]["reward"] = intval($_POST["reward"]);
                $array["options"][$i]["desc"] = strval($_POST["desc"]);
                $tmp = arrayToXML($array);
                file_put_contents(__PATH_MODULE_CONFIGS__ . "manualdonation.xml", $tmp);
                message("success", "Donation package was successfully created.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    if (check_value($_POST["package_edit_submit"])) {
        if (check_value($_POST["id"]) && check_value($_POST["name"]) && check_value($_POST["amount"]) && check_value($_POST["reward"]) && check_value($_POST["desc"])) {
            $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "manualdonation.xml");
            if ($xml !== false) {
                $array = [];
                $array["active"] = trim($xml->active);
                $array["enable_viettel"] = trim($xml->enable_viettel);
                $array["enable_mobifone"] = trim($xml->enable_mobifone);
                $array["enable_vinaphone"] = trim($xml->enable_vinaphone);
                $array["credit_config"] = trim($xml->credit_config);
                $i = 1;
                foreach ($xml->options->children() as $tag => $option) {
                    if ($tag == "option") {
                        if (intval($option["id"]) == intval($_POST["id"])) {
                            $array["options"][$i]["id"] = intval($_POST["id"]);
                            $array["options"][$i]["name"] = strval($_POST["name"]);
                            $array["options"][$i]["amount"] = floatval($_POST["amount"]);
                            $array["options"][$i]["currency"] = strval($_POST["currency"]);
                            $array["options"][$i]["reward"] = intval($_POST["reward"]);
                            $array["options"][$i]["desc"] = strval($_POST["desc"]);
                        } else {
                            $array["options"][$i]["id"] = intval($option["id"]);
                            $array["options"][$i]["name"] = strval($option["name"]);
                            $array["options"][$i]["amount"] = floatval($option["amount"]);
                            $array["options"][$i]["currency"] = strval($option["currency"]);
                            $array["options"][$i]["reward"] = intval($option["reward"]);
                            $array["options"][$i]["desc"] = strval($option["desc"]);
                        }
                        $i++;
                    }
                }
                $tmp = arrayToXML($array);
                file_put_contents(__PATH_MODULE_CONFIGS__ . "manualdonation.xml", $tmp);
                message("success", "Donation package #" . intval($_POST["id"]) . " was successfully edited.");
            }
        } else {
            message("error", "Missing data (complete all fields).");
        }
    }
    if (check_value($_GET["delete"])) {
        $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "manualdonation.xml");
        if ($xml !== false) {
            $array = [];
            $array["active"] = trim($xml->active);
            $array["enable_viettel"] = trim($xml->enable_viettel);
            $array["enable_mobifone"] = trim($xml->enable_mobifone);
            $array["enable_vinaphone"] = trim($xml->enable_vinaphone);
            $array["credit_config"] = trim($xml->credit_config);
            $found = false;
            $i = 1;
            foreach ($xml->options->children() as $tag => $option) {
                if ($tag == "option") {
                    if (intval($option["id"]) == intval($_GET["delete"])) {
                        $found = true;
                    } else {
                        $array["options"][$i]["id"] = intval($option["id"]);
                        $array["options"][$i]["name"] = strval($option["name"]);
                        $array["options"][$i]["amount"] = floatval($option["amount"]);
                        $array["options"][$i]["currency"] = strval($option["currency"]);
                        $array["options"][$i]["reward"] = intval($option["reward"]);
                        $array["options"][$i]["desc"] = strval($option["desc"]);
                        $i++;
                    }
                }
            }
            $tmp = arrayToXML($array);
            file_put_contents(__PATH_MODULE_CONFIGS__ . "manualdonation.xml", $tmp);
            if ($found) {
                message("success", "Donation package #" . intval($_GET["delete"]) . " was successfully deleted.");
            }
        }
    }
    loadModuleConfigs("manualdonation");
    $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
    echo "    <form action=\"\" method=\"post\">\r\n        <table class=\"table table-striped table-bordered table-hover module_config_tables\">\r\n            <tr>\r\n                <th>Status<br/><span>Enable/disable module.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("active", mconfig("active"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Viettel Gateway<br/><span>Enable/disable Viettel Gateway.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("enable_viettel", mconfig("enable_viettel"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Mobifone Gateway<br/><span>Enable/disable Mobifone Gateway.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("enable_mobifone", mconfig("enable_mobifone"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Vinaphone Gateway<br/><span>Enable/disable Vinaphone Gateway.</span></th>\r\n                <td>\r\n                    ";
    enabledisableCheckboxes("enable_vinaphone", mconfig("enable_vinaphone"), "Enabled", "Disabled");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <th>Credit Configuration<br/><span></span></th>\r\n                <td>\r\n                    ";
    echo $creditSystem->buildSelectInput("credit_config", mconfig("credit_config"), "form-control");
    echo "                </td>\r\n            </tr>\r\n            <tr>\r\n                <td colspan=\"2\"><input type=\"submit\" name=\"submit_changes\" value=\"Save Changes\" class=\"btn btn-success\"/></td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n\r\n    <hr><h3>Manage Donation Packages</h3>\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr>\r\n            <th width=\"60px\">ID</th>\r\n            <th>Name</th>\r\n            <th>Price</th>\r\n            <th>Currency</th>\r\n            <th>Reward</th>\r\n            <th>Description</th>\r\n            <th></th>\r\n        </tr>\r\n        <form action=\"index.php?module=modules_manager&config=manual_donation\" method=\"post\">\r\n            <tr>\r\n                <td><input name=\"id\" class=\"form-control\" type=\"text\"/></td>\r\n                <td><input name=\"name\" class=\"form-control\" type=\"text\"/></td>\r\n                <td><input name=\"amount\" class=\"form-control\" type=\"text\"/></td>\r\n                <td><input name=\"currency\" class=\"form-control\" type=\"text\"/></td>\r\n                <td><input name=\"reward\" class=\"form-control\" type=\"text\"/></td>\r\n                <td><input name=\"desc\" class=\"form-control\" type=\"text\"/></td>\r\n                <td><input type=\"submit\" name=\"package_add_submit\" class=\"btn btn-success\" value=\"Add\"/></td>\r\n            </tr>\r\n        </form>\r\n    </table>\r\n\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n        <tr>\r\n            <th width=\"60px\">ID</th>\r\n            <th>Name</th>\r\n            <th>Price</th>\r\n            <th>Currency</th>\r\n            <th>Reward</th>\r\n            <th>Description</th>\r\n            <th></th>\r\n        </tr>\r\n\r\n    ";
    $xml = simplexml_load_file(__PATH_MODULE_CONFIGS__ . "manualdonation.xml");
    if ($xml !== false) {
        $options = [];
        $i = 1;
        foreach ($xml->options->children() as $tag => $option) {
            if ($tag == "option") {
                $options[$i]["id"] = intval($option["id"]);
                $options[$i]["name"] = strval($option["name"]);
                $options[$i]["amount"] = floatval($option["amount"]);
                $options[$i]["currency"] = strval($option["currency"]);
                $options[$i]["reward"] = floatval($option["reward"]);
                $options[$i]["desc"] = strval($option["desc"]);
                echo "<form action=\"index.php?module=modules_manager&config=manual_donation\" method=\"post\"><tr>";
                echo "<td><input name=\"id\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["id"] . "\" /></td>";
                echo "<td><input name=\"name\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["name"] . "\" /></td>";
                echo "<td><input name=\"amount\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["amount"] . "\" /></td>";
                echo "<td><input name=\"currency\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["currency"] . "\" /></td>";
                echo "<td><input name=\"reward\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["reward"] . "\" /></td>";
                echo "<td><input name=\"desc\" class=\"form-control\" type=\"text\" value=\"" . $options[$i]["desc"] . "\" /></td>";
                echo "<td><input type=\"submit\" name=\"package_edit_submit\" class=\"btn btn-success\" value=\"Save\"/><a href=\"index.php?module=modules_manager&config=manual_donation&delete=" . $option["id"] . "\" class=\"btn btn-danger\"><i class=\"fa fa-remove\"></i></a></td>";
                echo "</tr></form>";
                $i++;
            }
        }
    }
    echo "\r\n    </table>";
}

?>