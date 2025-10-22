<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (!canAccessModule($_SESSION["username"], "balance", "allow")) {
        return NULL;
    }
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("balance_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            if ($config["MEMB_CREDITS_MEMUONLINE"]) {
                $coinsData = $dB2->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
            } else {
                $coinsData = $dB->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
            }
            $shopData = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
            echo "\r\n    <div class=\"table-responsive rankings-table\">\r\n        <table class=\"table table-hover text-center\">\r\n            <tr>\r\n                <th class=\"headerRow\">" . lang("balance_txt_2", true) . "</th>\r\n                <th class=\"headerRow\">" . lang("balance_txt_3", true) . "</th>\r\n            </tr>";
            if ($config["use_platinum"]) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_platinum", true) . "</th>\r\n                <td>" . number_format($coinsData["platinum"]) . "</td>\r\n            </tr>";
            }
            if ($config["use_gold"]) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_gold", true) . "</th>\r\n                <td>" . number_format($coinsData["gold"]) . "</td>\r\n            </tr>";
            }
            if ($config["use_silver"]) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_silver", true) . "</th>\r\n                <td>" . number_format($coinsData["silver"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("wcoinc")) {
                if (100 <= config("server_files_season", true)) {
                    echo "\r\n            <tr>\r\n                <th>" . lang("currency_wcoinc", true) . "</th>\r\n                <td>" . number_format($shopData["WCoin"]) . "</td>\r\n            </tr>";
                } else {
                    echo "\r\n            <tr>\r\n                <th>" . lang("currency_wcoinc", true) . "</th>\r\n                <td>" . number_format($shopData["WCoinC"]) . "</td>\r\n            </tr>";
                }
            }
            if (mconfig("wcoinp")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_wcoinp", true) . "</th>\r\n                <td>" . number_format($shopData["WCoinP"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("gp")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_gp", true) . "</th>\r\n                <td>" . number_format($shopData["GoblinPoint"]) . "</td>\r\n            </tr>";
            }
            echo "\r\n        </table>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
    } else {
        echo "\r\n<div class=\"sub-page-title\">\r\n  <div id=\"title\">\r\n    <h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1>\r\n  </div>\r\n</div>\r\n\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">\r\n      <div class=\"container_3 account_sub_header\">\r\n        <div class=\"grad\">\r\n          <div class=\"page-title\"><p>" . lang("balance_txt_1", true) . "</p></div>\r\n          <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\r\n        </div>\r\n      </div>\r\n      <div class=\"page-desc-holder\">\r\n\r\n      </div>";
        if (mconfig("active")) {
            if ($config["MEMB_CREDITS_MEMUONLINE"]) {
                $coinsData = $dB2->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
            } else {
                $coinsData = $dB->query_fetch_single("SELECT * FROM MEMB_CREDITS WHERE memb___id = ?", [$_SESSION["username"]]);
            }
            $shopData = $dB->query_fetch_single("SELECT * FROM T_InGameShop_Point WHERE AccountID = ?", [$_SESSION["username"]]);
            echo "\r\n    <div class=\"container_3 account-wide\" align=\"center\">\r\n        <table class=\"general-table-ui\" cellspacing=\"0\">\r\n            <tr>\r\n                <th width=\"50%\">" . lang("balance_txt_2", true) . "</th>\r\n                <th width=\"50%\">" . lang("balance_txt_3", true) . "</th>\r\n            </tr>";
            if ($config["use_platinum"]) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_platinum", true) . "</th>\r\n                <td>" . number_format($coinsData["platinum"]) . "</td>\r\n            </tr>";
            }
            if ($config["use_gold"]) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_gold", true) . "</th>\r\n                <td>" . number_format($coinsData["gold"]) . "</td>\r\n            </tr>";
            }
            if ($config["use_silver"]) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_silver", true) . "</th>\r\n                <td>" . number_format($coinsData["silver"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("wcoinc")) {
                if (100 <= config("server_files_season", true)) {
                    echo "\r\n            <tr>\r\n                <th>" . lang("currency_wcoinc", true) . "</th>\r\n                <td>" . number_format($shopData["WCoin"]) . "</td>\r\n            </tr>";
                } else {
                    echo "\r\n            <tr>\r\n                <th>" . lang("currency_wcoinc", true) . "</th>\r\n                <td>" . number_format($shopData["WCoinC"]) . "</td>\r\n            </tr>";
                }
            }
            if (mconfig("wcoinp")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_wcoinp", true) . "</th>\r\n                <td>" . number_format($shopData["WCoinP"]) . "</td>\r\n            </tr>";
            }
            if (mconfig("gp")) {
                echo "\r\n            <tr>\r\n                <th>" . lang("currency_gp", true) . "</th>\r\n                <td>" . number_format($shopData["GoblinPoint"]) . "</td>\r\n            </tr>";
            }
            echo "\r\n        </table>\r\n    </div>";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n\t</div>\r\n</div>";
    }
}

?>