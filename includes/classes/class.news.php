<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

class News
{
    public function addNews($title, $content, $author = "Administrator", $comments = 1, $visible = 0, $type = 0)
    {
        global $dB;
        if (check_value($title) && check_value($content) && check_value($author)) {
            if ($this->checkTitle($title)) {
                if ($this->checkContent($content)) {
                    if ($comments < 0 || 1 < $comments) {
                        $comments = 1;
                    }
                    if ($visible < 0 || 1 < $visible) {
                        $visible = 0;
                    }
                    $news_data = [htmlentities($title), $author, time(), $content, $comments, $visible, $type];
                    $add_news = $dB->query("INSERT INTO IMPERIAMUCMS_NEWS (news_title, news_author, news_date, news_content, allow_comments, visible, news_type) VALUES (?, ?, ?, ?, ?, ?, ?)", $news_data);
                    if ($add_news) {
                        message("success", lang("success_15", true));
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
            if (strlen($title) < 4 || 80 < strlen($title)) {
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
    public function removeNews($id)
    {
        global $dB;
        if (Validator::Number($id)) {
            if ($this->newsIdExists($id)) {
                $remove = $dB->query("DELETE FROM IMPERIAMUCMS_NEWS WHERE news_id = '" . $id . "'");
                if ($remove) {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }
    public function newsIdExists($id)
    {
        global $dB;
        if (Validator::Number($id)) {
            $id_exists = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_NEWS WHERE news_id = '" . $id . "'");
            if (is_array($id_exists)) {
                return true;
            }
            return false;
        }
        return false;
    }
    public function editNews($id, $title, $content, $author, $comments, $date, $visible, $type)
    {
        global $dB;
        if (check_value($id) && check_value($title) && check_value($content) && check_value($author) && check_value($comments) && check_value($date) && check_value($visible) && check_value($type)) {
            if (!$this->newsIdExists($id)) {
                return false;
            }
            if ($this->checkTitle($title) && $this->checkContent($content)) {
                $editData = [$title, $content, $author, strtotime($date), $comments, $visible, $type, $id];
                $query = $dB->query("UPDATE IMPERIAMUCMS_NEWS SET news_title = ?, news_content = ?, news_author = ?, news_date = ?, allow_comments = ?, visible = ?, news_type = ? WHERE news_id = ?", $editData);
                if ($query) {
                    message("success", "News successfully edited.");
                } else {
                    message("error", "There was an error while editing the news.");
                }
            }
        }
    }
    public function cacheNews()
    {
        if ($this->isNewsDirWritable()) {
            $news_list = $this->retrieveNews();
            if (is_array($news_list)) {
                $this->deleteNewsFiles();
                foreach ($news_list as $news) {
                    $handle = fopen(__PATH_NEWS_CACHE__ . "news_" . $news["news_id"] . ".cache", "a");
                    fwrite($handle, $news["news_content"]);
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
    public function isNewsDirWritable()
    {
        if (is_writable(__PATH_NEWS_CACHE__)) {
            return true;
        }
        return false;
    }
    public function retrieveNews()
    {
        global $dB;
        $news = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_NEWS ORDER BY news_id DESC");
        if (is_array($news)) {
            return $news;
        }
        return NULL;
    }
    public function deleteNewsFiles()
    {
        $files = glob(__PATH_NEWS_CACHE__ . "*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
    public function updateNewsCacheIndex()
    {
        $news_list = $this->retrieveNewsDataForCache();
        $cacheDATA = BuildCacheData($news_list);
        $updateCache = UpdateCache("news.cache", $cacheDATA);
        if ($updateCache) {
            return true;
        }
        return false;
    }
    public function retrieveNewsDataForCache()
    {
        global $dB;
        $news = $dB->query_fetch("SELECT news_id,news_title,news_author,news_date,allow_comments,visible,news_type FROM IMPERIAMUCMS_NEWS ORDER BY news_id DESC");
        if (is_array($news)) {
            return $news;
        }
        return NULL;
    }
    public function LoadCachedNews($id)
    {
        if (Validator::Number($id)) {
            if ($this->newsIdExists($id)) {
                $file = __PATH_NEWS_CACHE__ . "news_" . $id . ".cache";
                if (file_exists($file) && is_readable($file)) {
                    return file_get_contents($file);
                }
                return false;
            }
            return false;
        }
        return false;
    }
    public function loadNewsData($id)
    {
        global $dB;
        if (check_value($id) && $this->newsIdExists($id)) {
            $query = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_NEWS WHERE news_id = ?", [$id]);
            if ($query && is_array($query)) {
                return $query;
            }
        }
    }
}

?>