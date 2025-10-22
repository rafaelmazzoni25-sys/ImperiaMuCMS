<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

while (check_value($_GET["name"])) {
    echo "<h1 class=\"page-header\">Account Information</h1>";
    message("error", "Please provide a valid user id.");
    try {
        $char = hex_decode($_GET["name"]);
        $Character = new Character();
        if (!$Character->CharacterExists($char)) {
            throw new Exception("Character does not exist.");
        }
        if (check_value($_POST["characteredit_submit"])) {
            try {
                if ($_POST["characteredit_name"] != $char) {
                    throw new Exception("Invalid character name.");
                }
                if (!check_value($_POST["characteredit_account"])) {
                    throw new Exception("Invalid account name.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_class"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_level"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_resets"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_gresets"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_mlevel"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_zen"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_lvlpoints"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_pklevel"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_str"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_agi"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_vit"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_ene"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if (!Validator::UnsignedNumber($_POST["characteredit_cmd"])) {
                    throw new Exception("All the entered values must be numeric.");
                }
                if ($common->accountOnline($_POST["characteredit_account"])) {
                    throw new Exception("The account is currently online.");
                }
                $updateData = ["name" => $_POST["characteredit_name"], "class" => $_POST["characteredit_class"], "level" => $_POST["characteredit_level"], "resets" => $_POST["characteredit_resets"], "gresets" => $_POST["characteredit_gresets"], "mlevel" => $_POST["characteredit_mlevel"], "zen" => $_POST["characteredit_zen"], "lvlpoints" => $_POST["characteredit_lvlpoints"], "pklevel" => $_POST["characteredit_pklevel"], "str" => $_POST["characteredit_str"], "agi" => $_POST["characteredit_agi"], "vit" => $_POST["characteredit_vit"], "ene" => $_POST["characteredit_ene"], "cmd" => $_POST["characteredit_cmd"]];
                $query = "UPDATE " . _TBL_CHR_ . " SET ";
                $query .= _CLMN_CHR_CLASS_ . " = :class,";
                $query .= _CLMN_CHR_LVL_ . " = :level,";
                $query .= _CLMN_CHR_RSTS_ . " = :resets,";
                $query .= _CLMN_CHR_GRSTS_ . " = :gresets,";
                $query .= "mLevel = :mlevel,";
                $query .= _CLMN_CHR_ZEN_ . " = :zen,";
                $query .= _CLMN_CHR_LVLUP_POINT_ . " = :lvlpoints,";
                $query .= _CLMN_CHR_PK_LEVEL_ . " = :pklevel,";
                $query .= _CLMN_CHR_STAT_STR_ . " = :str,";
                $query .= _CLMN_CHR_STAT_AGI_ . " = :agi,";
                $query .= _CLMN_CHR_STAT_VIT_ . " = :vit,";
                $query .= _CLMN_CHR_STAT_ENE_ . " = :ene,";
                $query .= _CLMN_CHR_STAT_CMD_ . " = :cmd";
                $query .= " WHERE " . _CLMN_CHR_NAME_ . " = :name";
                $updateCharacter = $dB->query($query, $updateData);
                if (!$updateCharacter) {
                    throw new Exception("Could not update character data.");
                }
                message("success", "Character was successfully updated.");
            } catch (Exception $ex) {
                message("error", $ex->getMessage());
            }
        }
        $charData = $Character->CharacterData($char);
        if (!$charData) {
            throw new Exception("Could not retrieve character information (invalid character).");
        }
        if ($charData["mLevel"] == NULL) {
            $charData["mLevel"] = 0;
        }
        echo "<h1 class=\"page-header\">Edit Character: <small>" . $common->replaceHtmlSymbols($charData[_CLMN_CHR_NAME_]) . "</small></h1>";
        echo "<form role=\"form\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"characteredit_name\" value=\"" . $charData[_CLMN_CHR_NAME_] . "\"/>";
        echo "<input type=\"hidden\" name=\"characteredit_account\" value=\"" . $charData[_CLMN_CHR_ACCID_] . "\"/>";
        echo "<div class=\"row\"><div class=\"col-md-6\"><div class=\"panel panel-primary\"><div class=\"panel-heading\">Common</div><div class=\"panel-body\"><table class=\"table table-no-border table-hover\"><tr><th>Account:</th>";
        echo "<td><a href=\"" . admincp_base("accountinfo&id=" . $common->retrieveUserID($charData[_CLMN_CHR_ACCID_])) . "\">" . $charData[_CLMN_CHR_ACCID_] . "</a></td>";
        echo "</tr><tr><th>Class:</th><td><select class=\"form-control\" name=\"characteredit_class\">";
        foreach ($custom["character_class"] as $classID => $thisClass) {
            if ($classID == $charData[_CLMN_CHR_CLASS_]) {
                echo "<option value=\"" . $classID . "\" selected=\"selected\">" . $thisClass[0] . " (" . $thisClass[1] . ")</option>";
            } else {
                echo "<option value=\"" . $classID . "\">" . $thisClass[0] . " (" . $thisClass[1] . ")</option>";
            }
        }
        echo "</select></td></tr><tr><th>Level:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_level\" value=\"" . $charData[_CLMN_CHR_LVL_] . "\"/></td>";
        echo "</tr><tr><th>Master Level:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_mlevel\" value=\"" . $charData["mLevel"] . "\"/></td>";
        echo "</tr><tr><th>Resets:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_resets\" value=\"" . $charData[_CLMN_CHR_RSTS_] . "\"/></td>";
        echo "</tr><tr><th>Grand Resets:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_gresets\" value=\"" . $charData[_CLMN_CHR_GRSTS_] . "\"/></td>";
        echo "</tr><tr><th>Money:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_zen\" value=\"" . $charData[_CLMN_CHR_ZEN_] . "\"/></td>";
        echo "</tr><tr><th>Level-Up Points:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_lvlpoints\" value=\"" . $charData[_CLMN_CHR_LVLUP_POINT_] . "\"/></td>";
        echo "</tr><tr><th>PK Level:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_pklevel\" value=\"" . $charData[_CLMN_CHR_PK_LEVEL_] . "\"/></td>";
        echo "</tr></table></div></div></div><div class=\"col-md-6\"><div class=\"panel panel-default\"><div class=\"panel-heading\">Stats</div><div class=\"panel-body\"><table class=\"table table-no-border table-hover\"><tr><th>Strength:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_str\" value=\"" . $charData[_CLMN_CHR_STAT_STR_] . "\"/></td>";
        echo "</tr><tr><th>Dexterity:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_agi\" value=\"" . $charData[_CLMN_CHR_STAT_AGI_] . "\"/></td>";
        echo "</tr><tr><th>Vitality:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_vit\" value=\"" . $charData[_CLMN_CHR_STAT_VIT_] . "\"/></td>";
        echo "</tr><tr><th>Energy:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_ene\" value=\"" . $charData[_CLMN_CHR_STAT_ENE_] . "\"/></td>";
        echo "</tr><tr><th>Command:</th>";
        echo "<td><input type=\"number\" class=\"form-control\" name=\"characteredit_cmd\" value=\"" . $charData[_CLMN_CHR_STAT_CMD_] . "\"/></td>";
        echo "</tr></table></div></div></div></div><div class=\"row\"><div class=\"col-md-12\"><button type=\"submit\" class=\"btn btn-large btn-block btn-success\" name=\"characteredit_submit\" value=\"ok\">Save Changes</button></div></div></form>";
    } catch (Exception $ex) {
        echo "<h1 class=\"page-header\">Account Information</h1>";
        message("error", $ex->getMessage());
    }
}

?>