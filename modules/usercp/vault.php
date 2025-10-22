<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "vault", "block")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE_ASSETS__ . "js/tooltip.js\"></script>";
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("vault_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("vault");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("vault");
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 text-right\">\r\n            <div class=\"form-group\">";
            if (check_value($_GET["item"])) {
                echo "\r\n                <a href=\"" . __BASE_URL__ . "usercp/vault\">\r\n                    <button class=\"btn btn-warning\">" . lang("vault_txt_3", true) . "</button>\r\n                </a>";
            } else {
                echo "\r\n                <a href=\"" . __BASE_URL__ . "usercp/market\">\r\n                    <button class=\"btn btn-warning\">" . lang("myaccount_txt_58", true) . "</button>\r\n                </a>\r\n                <a href=\"" . __BASE_URL__ . "usercp/items\">\r\n                    <button class=\"btn btn-warning\">" . lang("myaccount_txt_67", true) . "</button>\r\n                </a>";
            }
            echo "\r\n            </div>\r\n        </div>\r\n    </div>";
            $Market = new Market();
            if (check_value($_GET["item"])) {
                $token = time();
                $_SESSION["token"] = $token;
                $vaultData = $Market->getVaultData($_SESSION["username"]);
                $Market->showItemResponsive($vaultData, Decode($_GET["item"]), $token);
            } else {
                if (check_value($_POST["sell"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $serial = htmlspecialchars(Decode($_POST["item"]));
                        $price = htmlspecialchars($_POST["sell_price"]);
                        $price_type = htmlspecialchars($_POST["sell_price_type"]);
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Market->sellItem($_SESSION["username"], $serial, $price, $price_type);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                } else {
                    if (check_value($_POST["delete"])) {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            $serial = htmlspecialchars(Decode($_POST["item"]));
                            $Market->deleteItem($_SESSION["username"], $serial);
                        } else {
                            message("notice", lang("global_module_13", true));
                        }
                    } else {
                        if (check_value($_POST["upgrade"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                $serial = htmlspecialchars(Decode($_POST["item"]));
                                $operation_type = htmlspecialchars(Decode($_POST["operation_type"]));
                                $item_type = htmlspecialchars(Decode($_POST[Encode("item_type")]));
                                $item_id = htmlspecialchars(Decode($_POST[Encode("item_id")]));
                                $item_level = htmlspecialchars(Decode($_POST[Encode("item_level")]));
                                if ($item_type == "00") {
                                    $item_type = 0;
                                }
                                if ($item_id == "00") {
                                    $item_type = 0;
                                }
                                if ($item_level == "00") {
                                    $item_level = 0;
                                }
                                if ($common->beginDbTrans($_SESSION["username"])) {
                                    $Market->upgradeItem($_SESSION["username"], $serial, $item_type, $item_id, $item_level, $operation_type);
                                    $common->endDbTrans($_SESSION["username"]);
                                }
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                    }
                }
                $token = time();
                $_SESSION["token"] = $token;
                $vaultData = $Market->getVaultData($_SESSION["username"]);
                $isExpanded = $Market->isExtendedVault($_SESSION["username"]);
                $Market->showVaultResponsive($vaultData, $isExpanded, $token);
            }
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "<script type=\"text/javascript\" SRC=\"" . __PATH_TEMPLATE__ . "js/tooltip.js\"></script>";
        if (check_value($_GET["item"])) {
            $subpage = "<div class=\"sub-active-page\">" . lang("vault_txt_2", true) . "</div>";
            $buttons = "<a href=\"" . __BASE_URL__ . "usercp/vault\">" . lang("vault_txt_3", true) . "</a>";
        } else {
            $subpage = "";
            $buttons = "<a href=\"" . __BASE_URL__ . "usercp/items\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("myaccount_txt_67", true) . "</a>\r\n              <a href=\"" . __BASE_URL__ . "usercp/market\" style=\"background-image: none;padding: 9px 12px 10px 10px\">" . lang("myaccount_txt_58", true) . "</a>\r\n              <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>";
        }
        echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\r\n</div>\r\n<div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n        <div class=\"container_3 account_sub_header\">\r\n            <div class=\"grad\">\r\n                <div class=\"page-title\">" . lang("vault_txt_1", true) . "</div>\r\n                " . $subpage . "\r\n                " . $buttons . "\r\n            </div>\r\n        </div>";
        if (mconfig("active")) {
            $General = new xGeneral();
            $General->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License("vault");
            $General->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License("vault");
            $Market = new Market();
            if (check_value($_GET["item"])) {
                $token = time();
                $_SESSION["token"] = $token;
                $vaultData = $Market->getVaultData($_SESSION["username"]);
                $Market->showItem($vaultData, Decode($_GET["item"]), $token);
            } else {
                if (check_value($_POST["sell"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        $serial = htmlspecialchars(Decode($_POST["item"]));
                        $price = htmlspecialchars($_POST["sell_price"]);
                        $price_type = htmlspecialchars($_POST["sell_price_type"]);
                        $Market->sellItem($_SESSION["username"], $serial, $price, $price_type);
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                } else {
                    if (check_value($_POST["delete"])) {
                        if ($_SESSION["token"] == $_POST["token"]) {
                            $serial = htmlspecialchars(Decode($_POST["item"]));
                            $Market->deleteItem($_SESSION["username"], $serial);
                        } else {
                            message("notice", lang("global_module_13", true));
                        }
                    } else {
                        if (check_value($_POST["upgrade"])) {
                            if ($_SESSION["token"] == $_POST["token"]) {
                                $serial = htmlspecialchars(Decode($_POST["item"]));
                                $operation_type = htmlspecialchars(Decode($_POST["operation_type"]));
                                $item_type = htmlspecialchars(Decode($_POST[Encode("item_type")]));
                                $item_id = htmlspecialchars(Decode($_POST[Encode("item_id")]));
                                $item_level = htmlspecialchars(Decode($_POST[Encode("item_level")]));
                                if ($item_type == "00") {
                                    $item_type = 0;
                                }
                                if ($item_id == "00") {
                                    $item_type = 0;
                                }
                                if ($item_level == "00") {
                                    $item_level = 0;
                                }
                                $Market->upgradeItem($_SESSION["username"], $serial, $item_type, $item_id, $item_level, $operation_type);
                            } else {
                                message("notice", lang("global_module_13", true));
                            }
                        }
                    }
                }
                $token = time();
                $_SESSION["token"] = $token;
                $vaultData = $Market->getVaultData($_SESSION["username"]);
                $isExpanded = $Market->isExtendedVault($_SESSION["username"]);
                $Market->showVault($vaultData, $isExpanded, $token);
            }
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    </div>\r\n</div>";
    }
}

?>