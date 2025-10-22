<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Recruit
{
    public function getInvitedFriends($username)
    {
        global $dB;
        if (check_value($username)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_RECRUIT_A_FRIEND WHERE AccountID_Inviter = ?", [$username]);
                    if (is_array($result)) {
                        return $result;
                    }
                    return NULL;
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function getInvitedBy($username)
    {
        global $dB;
        if (check_value($username)) {
            if (!Validator::UsernameLength($username)) {
                message("error", lang("error_5", true));
            } else {
                if (!Validator::AlphaNumeric($username)) {
                    message("error", lang("error_6", true));
                } else {
                    $result = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_RECRUIT_A_FRIEND WHERE AccountID_Friend = ?", [$username]);
                    if (is_array($result)) {
                        return $result;
                    }
                    return NULL;
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function checkProgress($friend, $inviter, $type)
    {
        global $dB;
        if (check_value($friend) && check_value($inviter)) {
            if (!Validator::UsernameLength($friend)) {
                message("error", lang("error_5", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($friend)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            if (!Validator::UsernameLength($inviter)) {
                message("error", lang("error_5", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($inviter)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            $resets = $dB->query_fetch_single("SELECT TOP 1 Name,RESETS,cLevel,mLevel FROM Character WHERE AccountID = ? ORDER BY RESETS DESC, cLevel DESC, mLevel DESC", [$friend]);
            $recruitData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_RECRUIT_A_FRIEND WHERE AccountID_Friend = ? AND AccountID_Inviter = ?", [$friend, $inviter]);
            $checkLimit = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_RECRUIT_A_FRIEND WHERE AccountID_Inviter = ? AND reward1_inviter = '1'", [$inviter]);
            if ($type == "inviter") {
                if (mconfig("req1_resets") <= $resets["RESETS"] && mconfig("req1_level") <= $resets["cLevel"] && mconfig("req1_mlevel") <= $resets["mLevel"]) {
                    if ($recruitData["reward1_inviter"] == "1") {
                        return lang("recruit_txt_1", true);
                    }
                    if ($recruitData["reward1_inviter"] == "0") {
                        if (mconfig("limit") <= $checkLimit["count"]) {
                            return lang("recruit_txt_2", true);
                        }
                        return "<button name=\"submit1\" value=\"submit\" class=\"ui-button button1\"><span class=\"button-left\"><span class=\"button-right\">" . lang("recruit_txt_7", true) . "</span></span></button>";
                    }
                } else {
                    if ($recruitData["reward1_inviter"] == "1") {
                        return lang("recruit_txt_1", true);
                    }
                    if ($recruitData["reward1_inviter"] == "0") {
                        if (mconfig("limit") <= $checkLimit["count"]) {
                            return lang("recruit_txt_2", true);
                        }
                        if ($resets["RESETS"] < mconfig("req1_resets") && $resets["cLevel"] < mconfig("req1_level") && $resets["mLevel"] < mconfig("req1_mlevel")) {
                            $lacking1 = mconfig("req1_resets") - $resets["RESETS"];
                            $lacking2 = mconfig("req1_level") - $resets["cLevel"];
                            $lacking3 = mconfig("req1_mlevel") - $resets["mLevel"];
                            return sprintf(lang("recruit_txt_3", true), $lacking2, $lacking3, $lacking1);
                        }
                        if ($resets["RESETS"] < mconfig("req1_resets")) {
                            $lacking = mconfig("req1_resets") - $resets["RESETS"];
                            return sprintf(lang("recruit_txt_4", true), $lacking);
                        }
                        if ($resets["cLevel"] < mconfig("req1_level")) {
                            $lacking = mconfig("req1_level") - $resets["cLevel"];
                            return sprintf(lang("recruit_txt_5", true), $lacking);
                        }
                        if ($resets["mLevel"] < mconfig("req1_mlevel")) {
                            $lacking = mconfig("req1_mlevel") - $resets["mLevel"];
                            return sprintf(lang("recruit_txt_6", true), $lacking);
                        }
                    }
                }
            } else {
                if ($type == "friend") {
                    if (mconfig("req1_resets") <= $resets["RESETS"] && mconfig("req1_level") <= $resets["cLevel"] && mconfig("req1_mlevel") <= $resets["mLevel"]) {
                        if ($recruitData["reward1_friend"] == "1") {
                            return lang("recruit_txt_1", true);
                        }
                        if ($recruitData["reward1_friend"] == "0") {
                            return "<button name=\"submit2\" value=\"submit\" class=\"ui-button button1\"><span class=\"button-left\"><span class=\"button-right\">" . lang("recruit_txt_7", true) . "</span></span></button>";
                        }
                    } else {
                        if ($recruitData["reward1_inviter"] == "1") {
                            return lang("recruit_txt_1", true);
                        }
                        if ($recruitData["reward1_inviter"] == "0") {
                            if (mconfig("limit") <= $checkLimit["count"]) {
                                return lang("recruit_txt_2", true);
                            }
                            if ($resets["RESETS"] < mconfig("req1_resets") && $resets["cLevel"] < mconfig("req1_level") && $resets["mLevel"] < mconfig("req1_mlevel")) {
                                $lacking1 = mconfig("req1_resets") - $resets["RESETS"];
                                $lacking2 = mconfig("req1_level") - $resets["cLevel"];
                                $lacking3 = mconfig("req1_mlevel") - $resets["mLevel"];
                                return sprintf(lang("recruit_txt_3", true), $lacking2, $lacking3, $lacking1);
                            }
                            if ($resets["RESETS"] < mconfig("req1_resets")) {
                                $lacking = mconfig("req1_resets") - $resets["RESETS"];
                                return sprintf(lang("recruit_txt_4", true), $lacking);
                            }
                            if ($resets["cLevel"] < mconfig("req1_level")) {
                                $lacking = mconfig("req1_level") - $resets["cLevel"];
                                return sprintf(lang("recruit_txt_5", true), $lacking);
                            }
                            if ($resets["mLevel"] < mconfig("req1_mlevel")) {
                                $lacking = mconfig("req1_mlevel") - $resets["mLevel"];
                                return sprintf(lang("recruit_txt_6", true), $lacking);
                            }
                        }
                    }
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function giveRewardInviter($inviter, $friend)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($friend) && check_value($inviter)) {
            if (!Validator::UsernameLength($friend)) {
                message("error", lang("error_5", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($friend)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            if (!Validator::UsernameLength($inviter)) {
                message("error", lang("error_5", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($inviter)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            $resets = $dB->query_fetch_single("SELECT TOP 1 Name,RESETS,cLevel,mLevel FROM Character WHERE AccountID = ? ORDER BY RESETS DESC, cLevel DESC", [$friend]);
            $recruitData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_RECRUIT_A_FRIEND WHERE AccountID_Friend = ? AND AccountID_Inviter = ?", [$friend, $inviter]);
            $checkLimit = $dB->query_fetch_single("SELECT COUNT(*) as count FROM IMPERIAMUCMS_RECRUIT_A_FRIEND WHERE AccountID_Friend = ? AND AccountID_Inviter = ? AND reward1_inviter = '1'", [$friend, $inviter]);
            if (mconfig("req1_resets") <= $resets["RESETS"] && mconfig("req1_level") <= $resets["cLevel"] && mconfig("req1_mlevel") <= $resets["mLevel"]) {
                if ($recruitData["reward1_inviter"] == "1") {
                    message("error", lang("recruit_txt_1", true));
                } else {
                    if ($recruitData["reward1_inviter"] == "0") {
                        if (mconfig("limit") <= $checkLimit["count"]) {
                            message("error", lang("recruit_txt_2", true));
                        } else {
                            try {
                                $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                                $creditSystem->setConfigId(mconfig("credit_config"));
                                $configSettings = $creditSystem->showConfigs(true);
                                switch ($configSettings["config_user_col_id"]) {
                                    case "userid":
                                        $creditSystem->setIdentifier($_SESSION["userid"]);
                                        break;
                                    case "username":
                                        $creditSystem->setIdentifier($_SESSION["username"]);
                                        $creditSystem->addCredits(mconfig("reward1"));
                                        $update = $dB->query("UPDATE IMPERIAMUCMS_RECRUIT_A_FRIEND SET reward1_inviter = '1' WHERE AccountID_Friend = ? AND AccountID_Inviter = ?", [$friend, $inviter]);
                                        message("success", lang("recruit_txt_8", true));
                                        $logDate = date("Y-m-d H:i:s", time());
                                        $common->accountLogs($inviter, "recruit", sprintf(lang("recruit_txt_9", true), $friend), $logDate);
                                        break;
                                    default:
                                        throw new Exception("Invalid identifier (credit system).");
                                }
                            } catch (Exception $ex) {
                            }
                        }
                    }
                }
            } else {
                if ($resets["RESETS"] < mconfig("req1_resets") && $resets["cLevel"] < mconfig("req1_level") && $resets["mLevel"] < mconfig("req1_mlevel")) {
                    $lacking1 = mconfig("req1_resets") - $resets["RESETS"];
                    $lacking2 = mconfig("req1_level") - $resets["cLevel"];
                    $lacking3 = mconfig("req1_mlevel") - $resets["mLevel"];
                    message("error", sprintf(lang("recruit_txt_3", true), $lacking2, $lacking3, $lacking1));
                } else {
                    if ($resets["RESETS"] < mconfig("req1_resets")) {
                        $lacking = mconfig("req1_resets") - $resets["RESETS"];
                        message("error", sprintf(lang("recruit_txt_4", true), $lacking));
                    } else {
                        if ($resets["cLevel"] < mconfig("req1_level")) {
                            $lacking = mconfig("req1_level") - $resets["cLevel"];
                            message("error", sprintf(lang("recruit_txt_5", true), $lacking));
                        } else {
                            if ($resets["mLevel"] < mconfig("req1_mlevel")) {
                                $lacking = mconfig("req1_mlevel") - $resets["mLevel"];
                                message("error", sprintf(lang("recruit_txt_6", true), $lacking));
                            }
                        }
                    }
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
    public function giveRewardFriend($friend, $inviter)
    {
        global $dB;
        global $dB2;
        global $common;
        if (check_value($friend) && check_value($inviter)) {
            if (!Validator::UsernameLength($friend)) {
                message("error", lang("error_5", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($friend)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            if (!Validator::UsernameLength($inviter)) {
                message("error", lang("error_5", true));
                return NULL;
            }
            if (!Validator::AlphaNumeric($inviter)) {
                message("error", lang("error_6", true));
                return NULL;
            }
            $resets = $dB->query_fetch_single("SELECT TOP 1 Name,RESETS,cLevel,mLevel FROM Character WHERE AccountID = ? ORDER BY RESETS DESC, cLevel DESC", [$friend]);
            $recruitData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_RECRUIT_A_FRIEND WHERE AccountID_Friend = ? AND AccountID_Inviter = ?", [$friend, $inviter]);
            if (mconfig("req1_resets") <= $resets["RESETS"] && mconfig("req1_level") <= $resets["cLevel"] && mconfig("req1_mlevel") <= $resets["mLevel"]) {
                if ($recruitData["reward1_friend"] == "1") {
                    message("error", lang("recruit_txt_1", true));
                } else {
                    if ($recruitData["reward1_friend"] == "0") {
                        try {
                            $creditSystem = new CreditSystem($common, new Character(), $dB, $dB2);
                            $creditSystem->setConfigId(mconfig("credit_config"));
                            $configSettings = $creditSystem->showConfigs(true);
                            switch ($configSettings["config_user_col_id"]) {
                                case "userid":
                                    $creditSystem->setIdentifier($_SESSION["userid"]);
                                    break;
                                case "username":
                                    $creditSystem->setIdentifier($_SESSION["username"]);
                                    $creditSystem->addCredits(mconfig("reward1"));
                                    $update = $dB->query("UPDATE IMPERIAMUCMS_RECRUIT_A_FRIEND SET reward1_friend = '1' WHERE AccountID_Friend = ? AND AccountID_Inviter = ?", [$friend, $inviter]);
                                    message("success", lang("recruit_txt_8", true));
                                    $logDate = date("Y-m-d H:i:s", time());
                                    $common->accountLogs($friend, "recruit", sprintf(lang("recruit_txt_10", true), $inviter), $logDate);
                                    break;
                                default:
                                    throw new Exception("Invalid identifier (credit system).");
                            }
                        } catch (Exception $ex) {
                        }
                    }
                }
            } else {
                if ($resets["RESETS"] < mconfig("req1_resets") && $resets["cLevel"] < mconfig("req1_level") && $resets["mLevel"] < mconfig("req1_mlevel")) {
                    $lacking1 = mconfig("req1_resets") - $resets["RESETS"];
                    $lacking2 = mconfig("req1_level") - $resets["cLevel"];
                    $lacking3 = mconfig("req1_mlevel") - $resets["mLevel"];
                    message("error", sprintf(lang("recruit_txt_3", true), $lacking2, $lacking3, $lacking1));
                } else {
                    if ($resets["RESETS"] < mconfig("req1_resets")) {
                        $lacking = mconfig("req1_resets") - $resets["RESETS"];
                        message("error", sprintf(lang("recruit_txt_4", true), $lacking));
                    } else {
                        if ($resets["cLevel"] < mconfig("req1_level")) {
                            $lacking = mconfig("req1_level") - $resets["cLevel"];
                            message("error", sprintf(lang("recruit_txt_5", true), $lacking));
                        } else {
                            if ($resets["mLevel"] < mconfig("req1_mlevel")) {
                                $lacking = mconfig("req1_mlevel") - $resets["mLevel"];
                                message("error", sprintf(lang("recruit_txt_6", true), $lacking));
                            }
                        }
                    }
                }
            }
        } else {
            message("error", lang("error_23", true));
        }
    }
}

?>