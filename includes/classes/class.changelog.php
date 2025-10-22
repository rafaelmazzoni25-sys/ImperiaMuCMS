<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class Changelog
{
    public function addChangelog($title, $content, $author = "Administrator", $type = 1)
    {
        global $dB;
        if (check_value($title) && check_value($content) && check_value($author)) {
            if ($this->checkTitle($title)) {
                if ($this->checkContent($content)) {
                    if ($type < 1 || 2 < $type) {
                        $type = 1;
                    }
                    $date = date("Y-m-d H:i:s", time());
                    $changelog_data = [htmlentities($title), $author, $date, $content, $type];
                    $add_changelog = $dB->query("INSERT INTO IMPERIAMUCMS_CHANGELOGS (title,author,date,text,type) VALUES (?,?,?,?,?)", $changelog_data);
                    if ($add_changelog) {
                        message("success", "Changelog successfully added!");
                    } else {
                        message("error", lang("error_23", true));
                    }
                } else {
                    message("error", lang("error_43", true));
                }
            } else {
                message("error", lang("error_42", true));
            }
        } else {
            message("error", lang("error_41", true));
        }
    }
    public function checkTitle($title)
    {
        if (check_value($title)) {
            if (strlen($title) < 4 || 50 < strlen($title)) {
                return false;
            }
            return true;
        }
        return false;
    }
    public function checkContent($content)
    {
        if (check_value($content)) {
            if (strlen($content) < 4) {
                return false;
            }
            return true;
        }
        return false;
    }
    public function removeChangelog($id)
    {
        global $dB;
        if (Validator::Number($id)) {
            if ($this->changelogIdExists($id)) {
                $remove = $dB->query("DELETE FROM IMPERIAMUCMS_CHANGELOGS WHERE id = ?", [$id]);
                if ($remove) {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }
    public function changelogIdExists($id)
    {
        global $dB;
        if (Validator::Number($id)) {
            $id_exists = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CHANGELOGS WHERE id = ?", [$id]);
            if (is_array($id_exists)) {
                return true;
            }
            return false;
        }
        return false;
    }
    public function editChangelog($id, $title, $content, $author, $type)
    {
        global $dB;
        if (check_value($id) && check_value($title) && check_value($content) && check_value($author) && check_value($type)) {
            if (!$this->changelogIdExists($id)) {
                message("error", "Changelog does not exist.");
            }
            if ($this->checkTitle($title) && $this->checkContent($content)) {
                $editData = [$title, $content, $author, $type, $id];
                $query = $dB->query("UPDATE IMPERIAMUCMS_CHANGELOGS SET title = ?, text = ?, author = ?, type = ? WHERE id = ?", $editData);
                if ($query) {
                    message("success", "Changelog successfully edited.");
                } else {
                    message("error", "There was an error while editing the changelog.");
                }
            } else {
                message("error", "Invalid title or content.");
            }
        } else {
            message("error", "Check value error.");
        }
    }
    public function retrieveChangelogSrv($page, $limit)
    {
        global $dB;
        $changelogs = $dB->query_fetch("\r\n            SELECT * FROM IMPERIAMUCMS_CHANGELOGS \r\n            WHERE type = 1 \r\n            ORDER BY id DESC\r\n            OFFSET " . intval($page * $limit - $limit) . " ROWS FETCH NEXT " . intval($limit) . " ROWS ONLY");
        if (is_array($changelogs)) {
            return $changelogs;
        }
        return NULL;
    }
    public function retrieveChangelogSrvAll()
    {
        global $dB;
        $changelogs = $dB->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_CHANGELOGS WHERE type = 1");
        if (is_array($changelogs)) {
            return $changelogs["total"];
        }
        return NULL;
    }
    public function retrieveChangelogWeb($page, $limit)
    {
        global $dB;
        $changelogs = $dB->query_fetch("\r\n            SELECT * FROM IMPERIAMUCMS_CHANGELOGS \r\n            WHERE type = 2 \r\n            ORDER BY id DESC\r\n            OFFSET " . intval($page * $limit - $limit) . " ROWS FETCH NEXT " . intval($limit) . " ROWS ONLY");
        if (is_array($changelogs)) {
            return $changelogs;
        }
        return NULL;
    }
    public function retrieveChangelogWebAll()
    {
        global $dB;
        $changelogs = $dB->query_fetch_single("SELECT COUNT(*) as total FROM IMPERIAMUCMS_CHANGELOGS WHERE type = 2");
        if (is_array($changelogs)) {
            return $changelogs["total"];
        }
        return NULL;
    }
    public function cacheChangelog()
    {
        if ($this->isChangelogDirWritable()) {
            $changelog_list = $this->retrieveChangelog();
            if (is_array($changelog_list)) {
                $this->deleteChangelogFiles();
                foreach ($changelog_list as $changelog) {
                    $handle = fopen(__PATH_CHANGELOG_CACHE__ . "changelog_" . $changelog["id"] . ".cache", "a");
                    fwrite($handle, $changelog["text"]);
                    fclose($handle);
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function isChangelogDirWritable()
    {
        if (is_writable(__PATH_CHANGELOG_CACHE__)) {
            return true;
        }
        return false;
    }
    public function retrieveChangelog()
    {
        global $dB;
        $changelogs = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_CHANGELOGS ORDER BY id DESC");
        if (is_array($changelogs)) {
            return $changelogs;
        }
        return NULL;
    }
    public function retrieveChangelogs($limit)
    {
        global $dB;
        if (is_numeric($limit) && 0 < $limit) {
            $changelogs = $dB->query_fetch("SELECT TOP " . $limit . " * FROM IMPERIAMUCMS_CHANGELOGS ORDER BY date DESC");
            if (is_array($changelogs)) {
                return $changelogs;
            }
            return NULL;
        }
        return NULL;
    }
    public function deleteChangelogFiles()
    {
        $files = glob(__PATH_CHANGELOG_CACHE__ . "*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
    public function updateChangelogCacheIndex()
    {
        $changelog_list = $this->retrieveChangelogDataForCache();
        $cacheDATA = BuildCacheData($changelog_list);
        $updateCache = UpdateCache("changelog.cache", $cacheDATA);
        if ($updateCache) {
            return true;
        }
        return false;
    }
    public function retrieveChangelogDataForCache()
    {
        global $dB;
        $changelog = $dB->query_fetch("SELECT id,title,author,date,type FROM IMPERIAMUCMS_CHANGELOGS ORDER BY id DESC");
        if (is_array($changelog)) {
            return $changelog;
        }
        return NULL;
    }
    public function LoadCachedChangelog($id)
    {
        if (Validator::Number($id)) {
            if ($this->changelogIdExists($id)) {
                $file = __PATH_CHANGELOG_CACHE__ . "changelog_" . $id . ".cache";
                if (file_exists($file) && is_readable($file)) {
                    return file_get_contents($file);
                }
                return false;
            }
            return false;
        }
        return false;
    }
    public function loadChangelogData($id)
    {
        global $dB;
        if (check_value($id) && $this->changelogIdExists($id)) {
            $query = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_CHANGELOGS WHERE id = ?", [$id]);
            if ($query && is_array($query)) {
                return $query;
            }
        }
    }
}

?>