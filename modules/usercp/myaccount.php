<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    echo "<div class=\"page-container\">";
    echo "<div class=\"page-title\"> <span>" . lang("module_titles_txt_4", true) . "</span> </div>";
    echo "<div class=\"page-content\">";
    if (mconfig("active")) {
        $accountInfo = $common->accountInformation($_SESSION["userid"]);
        if ($accountInfo) {
            if ($common->accountOnline($_SESSION["username"])) {
                $accountOnlineStatus = "<span class=\"online\">" . lang("myaccount_txt_9", true) . "</span>";
            } else {
                $accountOnlineStatus = "<span class=\"offline\">" . lang("myaccount_txt_10", true) . "</span>";
            }
            if ($accountInfo[_CLMN_BLOCCODE_] == 1) {
                $accountStatus = "<span class=\"blocked\">" . lang("myaccount_txt_8", true) . "</span>";
            } else {
                $accountStatus = "<span class=\"active\">" . lang("myaccount_txt_7", true) . "</span>";
            }
            $Character = new Character();
            $AccountCharacters = $Character->AccountCharacter($_SESSION["username"]);
            echo "<table class=\"myaccount-table\" cellspacing=\"0\"><tr>";
            echo "<td>" . lang("myaccount_txt_1", true) . "</td>";
            echo "<td>" . $accountStatus . "</td>";
            echo "</tr><tr>";
            echo "<td>" . lang("myaccount_txt_2", true) . "</td>";
            echo "<td>" . $accountInfo[_CLMN_USERNM_] . "</td>";
            echo "</tr><tr>";
            echo "<td>" . lang("myaccount_txt_3", true) . "</td>";
            echo "<td>" . $accountInfo[_CLMN_EMAIL_] . " (<a href=\"" . __BASE_URL__ . "usercp/myemail/\">" . lang("myaccount_txt_6", true) . "</a>)</td>";
            echo "</tr><tr>";
            echo "<td>" . lang("myaccount_txt_4", true) . "</td>";
            echo "<td>********** (<a href=\"" . __BASE_URL__ . "usercp/mypassword/\">" . lang("myaccount_txt_6", true) . "</a>)</td>";
            echo "</tr><tr>";
            echo "<td>" . lang("myaccount_txt_5", true) . "</td>";
            echo "<td>" . $accountOnlineStatus . "</td>";
            echo "</tr><tr>";
            echo "<td>" . lang("myaccount_txt_12", true) . "</td>";
            echo "<td>" . ($accountInfo[_CLMN_CREDITS_] + $accountInfo[_CLMN_CREDITS_TEMP_]) . "</td>";
            echo "</tr><tr valign=\"top\">";
            echo "<td>" . lang("myaccount_txt_15", true) . "</td>";
            echo "<td>";
            if (is_array($AccountCharacters)) {
                foreach ($AccountCharacters as $char) {
                    echo "<a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($char) . "/\" target=\"_blank\">" . $char . "</a><br />";
                }
            } else {
                lang("myaccount_txt_16");
            }
            echo "</td></tr></table>";
        } else {
            message("error", lang("error_12", true));
        }
    } else {
        message("error", lang("error_47", true));
    }
    echo "</div></div>";
}

?>