<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "cleareventinv", "block")) {
        return NULL;
    }
    $price_type = mconfig("price_type");
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
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("cleareventinv_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            echo "\r\n    <div class=\"row desc-row\">\r\n        <div class=\"col-xs-12\">\r\n            " . lang("cleareventinv_txt_2", true) . "";
            if (mconfig("enable_requirement")) {
                echo "<br />" . sprintf(lang("cleareventinv_txt_3", true), number_format(mconfig("price")), $price_type);
            }
            echo "\r\n        </div>\r\n    </div>";
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            if (is_array($AccountCharacters)) {
                if (check_value($_POST["submit"])) {
                    if ($_SESSION["token"] == $_POST["token"]) {
                        if ($common->beginDbTrans($_SESSION["username"])) {
                            $Character->CharacterClearEventInventory($_SESSION["username"], $_POST["character"]);
                            $common->endDbTrans($_SESSION["username"]);
                        }
                    } else {
                        message("notice", lang("global_module_13", true));
                    }
                }
                $charOpts = "";
                $token = time();
                $_SESSION["token"] = $token;
                foreach ($AccountCharacters as $thisCharacter) {
                    $characterData = $Character->CharacterData($thisCharacter);
                    $characterIMG = $Character->GenerateCharacterClassAvatar($characterData[_CLMN_CHR_CLASS_]);
                    $charOpts .= "<option value=\"" . Encode($characterData[_CLMN_CHR_NAME_]) . "\">" . $common->replaceHtmlSymbols($characterData[_CLMN_CHR_NAME_]) . " (" . $custom["character_class"][$characterData["Class"]][0] . ")</option>";
                }
                echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-center\">\r\n            <form action=\"\" method=\"post\">\r\n                <div class=\"form-group\">\r\n                    <label>" . lang("cleareventinv_txt_4", true) . "</label>\r\n                    <select name=\"character\" class=\"form-control\">\r\n                        " . $charOpts . "\r\n                    </select>\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    " . lang("cleareventinv_txt_6", true) . "\r\n                </div>\r\n                <div class=\"form-group\">\r\n                    <input type=\"hidden\" name=\"token\" value=\"" . $token . "\">\r\n                    <input type=\"submit\" name=\"submit\" value=\"" . lang("cleareventinv_txt_5", true) . "\" class=\"btn btn-warning full-width-btn\">\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>";
            } else {
                message("error", lang("error_46", true));
            }
        } else {
            message("error", lang("error_47", true));
        }
    }
}

?>