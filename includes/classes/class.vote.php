<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Vote
{
    public function canVote($user_id, $vote_id, $user_ip)
    {
        global $dB;
        global $dB2;
        $vote_id = xss_clean($vote_id);
        if (!check_value($user_id)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($vote_id)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($user_ip)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!Validator::UnsignedNumber($user_id)) {
                        message("error", lang("error_24", true));
                    } else {
                        if (!Validator::UnsignedNumber($vote_id)) {
                            message("error", lang("error_24", true));
                        } else {
                            $delay = $dB->query_fetch_single("SELECT votesite_time FROM IMPERIAMUCMS_VOTE_SITES WHERE votesite_id = ?", [$vote_id]);
                            $delay = $delay["votesite_time"];
                            $checkIP = false;
                            if (mconfig("ip_check")) {
                                $voteData = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_VOTES WHERE user_ip = ? AND vote_site_id = ? AND confirm = '1' ORDER BY timestamp DESC", [$user_ip, $vote_id]);
                                if (is_array($voteData)) {
                                    if ($voteData["timestamp"] + $delay * 3600 <= time()) {
                                        $checkIP = true;
                                    }
                                } else {
                                    $checkIP = true;
                                }
                            } else {
                                $checkIP = true;
                            }
                            if ($checkIP) {
                                if (config("SQL_USE_2_DB", true)) {
                                    $username = $dB2->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb_guid = ?", [$user_id]);
                                } else {
                                    $username = $dB->query_fetch_single("SELECT memb___id FROM MEMB_INFO WHERE memb_guid = ?", [$user_id]);
                                }
                                $username = $username["memb___id"];
                                $top_level = $dB->query_fetch_single("SELECT TOP 1 cLevel FROM Character WHERE AccountID = ? ORDER BY cLevel DESC", [$username]);
                                $top_reset = $dB->query_fetch_single("SELECT TOP 1 RESETS FROM Character WHERE AccountID = ? ORDER BY RESETS DESC", [$username]);
                                $level_check = true;
                                $reset_check = true;
                                $lastVote = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_VOTES WHERE user_id = ? AND vote_site_id = ? AND confirm = '1' ORDER BY timestamp DESC", [$user_id, $vote_id]);
                                if ($lastVote["timestamp"] + $delay * 3600 <= time()) {
                                    if (0 < mconfig("required_level") && $top_level["cLevel"] < mconfig("required_level")) {
                                        $level_check = false;
                                    }
                                    if (0 < mconfig("required_reset") && $top_reset["RESETS"] < mconfig("required_reset")) {
                                        $reset_check = false;
                                    }
                                    if ($level_check && $reset_check) {
                                        return true;
                                    }
                                    return false;
                                }
                                return false;
                            }
                        }
                    }
                }
            }
        }
    }
    public function getSeconds($user_id, $vote_id, $user_ip)
    {
        global $dB;
        if (!check_value($user_id)) {
            message("error", lang("error_4", true));
        } else {
            if (!check_value($vote_id)) {
                message("error", lang("error_4", true));
            } else {
                if (!check_value($user_ip)) {
                    message("error", lang("error_4", true));
                } else {
                    if (!Validator::UnsignedNumber($user_id)) {
                        throw new Exception("invalid userid");
                    }
                    $delay = $dB->query_fetch_single("SELECT votesite_time FROM IMPERIAMUCMS_VOTE_SITES WHERE votesite_id = ?", [$vote_id]);
                    $delay = $delay["votesite_time"];
                    if (mconfig("ip_check")) {
                        $lastVote = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_VOTES WHERE user_ip = ? AND vote_site_id = ? AND confirm = '1' ORDER BY timestamp DESC", [$user_ip, $vote_id]);
                        $lastVote2 = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_VOTES WHERE user_id = ? AND vote_site_id = ? AND confirm = '1' ORDER BY timestamp DESC", [$user_id, $vote_id]);
                        if (is_array($lastVote2) && $lastVote["timestamp"] < $lastVote2["timestamp"]) {
                            $lastVote = $lastVote2;
                        }
                        if (is_array($lastVote)) {
                            if ($lastVote["timestamp"] + $delay * 3600 <= time()) {
                                return NULL;
                            }
                            $wait = $lastVote["timestamp"] + $delay * 3600 - time();
                            return $wait;
                        }
                        return NULL;
                    }
                    $lastVote = $dB->query_fetch_single("SELECT TOP 1 * FROM IMPERIAMUCMS_VOTES WHERE user_id = ? AND vote_site_id = ? AND confirm = '1' ORDER BY timestamp desc", [$user_id, $vote_id]);
                    if (is_array($lastVote)) {
                        if ($lastVote["timestamp"] + $delay * 3600 <= time()) {
                            return NULL;
                        }
                        $wait = $lastVote["timestamp"] + $delay * 3600 - time();
                        return $wait;
                    }
                    return NULL;
                }
            }
        }
    }
    public function getLinks()
    {
        global $dB;
        $result = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_VOTE_SITES");
        if (is_array($result)) {
            return $result;
        }
        return NULL;
    }
    public function updateLink($id, $title, $link, $reward, $time, $img, $postback, $postback_type)
    {
        global $dB;
        if (check_value($id) && check_value($title) && check_value($link) && check_value($reward) && check_value($time)) {
            $update = $dB->query("UPDATE IMPERIAMUCMS_VOTE_SITES SET votesite_title = ?, votesite_link = ?, votesite_reward = ?, votesite_time = ?, img = ?, postback_enabled = ?, postback_type = ? WHERE votesite_id = ?", [$title, $link, $reward, $time, $img, $postback, $postback_type, $id]);
            if ($update) {
                message("success", "Data were updated successfully.");
            } else {
                message("error", "Unexpected error occurred.");
            }
        } else {
            message("error", "Invalid values.");
        }
    }
    public function addVote($title, $link, $reward, $time, $img, $postback, $postback_type)
    {
        global $dB;
        if (check_value($title) && check_value($link) && check_value($reward) && check_value($time)) {
            $update = $dB->query("INSERT INTO IMPERIAMUCMS_VOTE_SITES (votesite_title, votesite_link, votesite_reward, votesite_time, img, postback_enabled, postback_type, active)\r\n                              VALUES(?,?,?,?,?,?,?,?)", [$title, $link, $reward, $time, $img, $postback, $postback_type, 1]);
            if ($update) {
                message("success", "Data were added successfully.");
            } else {
                message("error", "Unexpected error occurred.");
            }
        } else {
            message("error", "Invalid values.");
        }
    }
    public function switchStatus($id)
    {
        global $dB;
        if (check_value($id)) {
            if (is_numeric($id)) {
                $voteStatus = $dB->query_fetch_single("SELECT active FROM IMPERIAMUCMS_VOTE_SITES WHERE votesite_id = ?", [$id]);
                if ($voteStatus["active"] == "1") {
                    $newStatus = 0;
                } else {
                    if ($voteStatus["active"] == "0") {
                        $newStatus = 1;
                    }
                }
                $update = $dB->query("UPDATE IMPERIAMUCMS_VOTE_SITES SET active = ? WHERE votesite_id = ?", [$newStatus, $id]);
                if ($update) {
                    message("success", "Data were updated successfully.");
                } else {
                    message("error", "Unexpected error occurred.");
                }
            } else {
                message("error", "Invalid values.");
            }
        } else {
            message("error", "Invalid values.");
        }
    }
}

?>