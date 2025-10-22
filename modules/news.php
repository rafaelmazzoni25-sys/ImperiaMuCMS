<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    if (mconfig("active")) {
        if (mconfig("news_enable_comment_system") || mconfig("news_enable_like_button")) {
            echo "\r\n        <div id=\"fb-root\"></div>\r\n        <script>(function(d, s, id) {\r\n            var js, fjs = d.getElementsByTagName(s)[0];\r\n            if (d.getElementById(id)) return;\r\n            js = d.createElement(s); js.id = id;\r\n            js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=" . mconfig("facebook_app_id") . "\";\r\n            fjs.parentNode.insertBefore(js, fjs);\r\n        }(document, 'script', 'facebook-jssdk'));</script>";
        }
        $News = new News();
        $loadNews = LoadCacheData("news.cache");
        if (is_array($loadNews)) {
            $requestedNewsId = $_GET["subpage"];
            if ($requestedNewsId == "history") {
                if (isset($_GET["pg"])) {
                    $currPage = $_GET["pg"];
                } else {
                    $currPage = 1;
                }
                $itemsPerPage = mconfig("news_per_page");
                $totalItems = count($loadNews) - 1;
                $totalPages = ceil($totalItems / $itemsPerPage);
                $displayMax = $currPage * $itemsPerPage;
                $displayMin = $displayMax - $itemsPerPage + 1;
                $currPageData = [];
                $start = $displayMin;
                $i = 0;
                while ($i < $itemsPerPage) {
                    if ($loadNews[$start][5]) {
                        $currPageData[$i] = $loadNews[$start];
                    }
                    $start++;
                    $i++;
                }
                $breadcrumb = generateBreadcrumb();
                echo "\r\n    <h3>\r\n        " . lang("news_txt_3", true) . $breadcrumb . "\r\n    </h3>";
                $nid = 0;
                echo "\r\n    <div class=\"panel-group\" id=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">";
                foreach ($currPageData as $thisNews) {
                    list($news_id, $news_visible) = $thisNews;
                    if ($news_visible) {
                        list($news_title, $news_author, $news_date, $news_comments, $news_type) = $thisNews;
                        $news_url = __BASE_URL__ . "news/" . Encode_id($news_id) . "/";
                        $loadNewsCache = $News->LoadCachedNews($news_id);
                        if (check_value($loadNewsCache)) {
                            $aClass = "class=\"collapsed\" ";
                            $ariaExpanded = "false";
                            $collapseIn = "";
                            if (mconfig("news_type") == 2) {
                                $aClass = "";
                                $ariaExpanded = "true";
                                $collapseIn = " in";
                            }
                            if ($news_type == 0) {
                                $typeLabel = "<span class=\"label label-info\">" . lang("news_txt_4", true) . "</span>";
                            } else {
                                if ($news_type == 1) {
                                    $typeLabel = "<span class=\"label label-primary\">" . lang("news_txt_5", true) . "</span>";
                                } else {
                                    if ($news_type == 2) {
                                        $typeLabel = "<span class=\"label label-success\">" . lang("news_txt_6", true) . "</span>";
                                    } else {
                                        if ($news_type == 3) {
                                            $typeLabel = "<span class=\"label label-warning\">" . lang("news_txt_7", true) . "</span>";
                                        }
                                    }
                                }
                            }
                            echo "\r\n        <div class=\"panel panel-default\">";
                            if (mconfig("news_type") == 2) {
                                echo "\r\n            <a href=\"" . $news_url . "\">";
                            } else {
                                echo "\r\n            <a " . $aClass . "role=\"button\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#news" . $nid . "\" aria-expanded=\"" . $ariaExpanded . "\" aria-controls=\"news" . $nid . "\">";
                            }
                            echo "\r\n                <div class=\"panel-heading\" role=\"tab\" id=\"heading" . $nid . "\">\r\n                    <h4 class=\"panel-title\">\r\n                        " . $news_title . "\r\n                        <div class=\"panel-title-date-div\">\r\n                            <b><span style=\"text-transform: uppercase;\"><small>" . $typeLabel . "</small></span></b>\r\n                            <b><span style=\"text-transform: uppercase;\"><small><span class=\"label label-default\">" . date($config["news_date"], $news_date) . "</span></small></span></b>\r\n                        </div>\r\n                    </h4>\r\n                </div>\r\n            </a>\r\n            <div id=\"news" . $nid . "\" class=\"panel-collapse collapse" . $collapseIn . "\" role=\"tabpanel\" aria-labelledby=\"heading" . $nid . "\">\r\n                <div class=\"panel-body\">\r\n                    " . $loadNewsCache;
                            if (mconfig("news_enable_like_button")) {
                                echo "\r\n                    <div style=\"width: 100%; float: right;\">\r\n                        <div style=\"float: right;\" class=\"fb-like\" data-href=\"" . $news_url . "\" data-width=\"670\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"true\" data-share=\"true\" data-colorscheme=\"dark\"></div>\r\n                    </div>";
                            }
                            if ($news_comments && mconfig("news_enable_comment_system")) {
                                echo "\r\n                    <div class=\"fb-comments\" data-href=\"" . $news_url . "\" data-width=\"100%\" data-numposts=\"5\" data-colorscheme=\"dark\"></div>";
                            }
                            echo "\r\n                </div>\r\n            </div>\r\n        </div>";
                        }
                    }
                    $nid++;
                }
                echo "\r\n    </div>";
                echo "\r\n    <nav class=\"text-center\">\r\n        <ul class=\"pagination\">\r\n            <li>\r\n                <a href=\"" . __BASE_URL__ . "news/history?pg=1\" aria-label=\"First\">\r\n                    <span aria-hidden=\"true\">&laquo;</span>\r\n                </a>\r\n            </li>";
                if ($currPage == "1") {
                    echo "<li class=\"active\"><a href=\"#\">" . $currPage . "</a></li>";
                    if ($currPage + 1 <= $totalPages) {
                        echo "<li><a href=\"" . __BASE_URL__ . "news/history?pg=" . ($currPage + 1) . "\">" . ($currPage + 1) . "</a></li>";
                    }
                    if ($currPage + 2 <= $totalPages) {
                        echo "<li><a href=\"#\">...</a></li>";
                    }
                } else {
                    if ($currPage == $totalPages) {
                        if (0 < $currPage - 2) {
                            echo "<li><a href=\"#\">...</a></li>";
                        }
                        if (0 < $currPage - 1) {
                            echo "<li><a href=\"" . __BASE_URL__ . "news/history?pg=" . ($currPage - 1) . "\">" . ($currPage - 1) . "</a></li>";
                        }
                        echo "<li class=\"active\"><a href=\"#\">" . $currPage . "</a></li>";
                    } else {
                        if (0 < $currPage - 2) {
                            echo "<li><a href=\"#\">...</a></li>";
                        }
                        echo "<li><a href=\"" . __BASE_URL__ . "news/history?pg=" . ($currPage - 1) . "\">" . ($currPage - 1) . "</a></li>";
                        echo "<li class=\"active\"><a href=\"#\">" . $currPage . "</a></li>";
                        echo "<li><a href=\"" . __BASE_URL__ . "news/history?pg=" . ($currPage + 1) . "\">" . ($currPage + 1) . "</a></li>";
                        if ($currPage + 2 <= $totalPages) {
                            echo "<li><a href=\"#\">...</a></li>";
                        }
                    }
                }
                echo "\r\n            <li>\r\n                <a href=\"" . __BASE_URL__ . "news/history?pg=" . $totalPages . "\" aria-label=\"Last\">\r\n                    <span aria-hidden=\"true\">&raquo;</span>\r\n                </a>\r\n            </li>\r\n        </ul>\r\n    </nav>";
            } else {
                if (check_value($requestedNewsId) && $requestedNewsId != "history" && $News->newsIdExists(Decode_id($requestedNewsId))) {
                    echo "\r\n    <h3>\r\n        <a href=\"" . __BASE_URL__ . "news/history\" class=\"btn-simple btn-icon-plus pull-right\"></a>\r\n        " . lang("news_txt_3", true) . "\r\n    </h3>";
                    $newsID = Decode_id($requestedNewsId);
                    $nid = 0;
                    echo "\r\n    <div class=\"panel-group\" id=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">";
                    foreach ($loadNews as $thisNews) {
                        $news_id = $thisNews[0];
                        if ($news_id == $newsID) {
                            $news_visible = $thisNews[5];
                            if ($news_visible) {
                                list($news_title, $news_author, $news_date, $news_comments, $news_type) = $thisNews;
                                $news_url = __BASE_URL__ . "news/" . Encode_id($news_id) . "/";
                                $loadNewsCache = $News->LoadCachedNews($news_id);
                                if (check_value($loadNewsCache)) {
                                    if (1 < $nid) {
                                        $aClass = "class=\"collapsed\" ";
                                        $ariaExpanded = "false";
                                        $collapseIn = "";
                                    } else {
                                        $aClass = "";
                                        $ariaExpanded = "true";
                                        $collapseIn = " in";
                                    }
                                    if (mconfig("news_type") == 2) {
                                        $aClass = "";
                                        $ariaExpanded = "true";
                                        $collapseIn = " in";
                                    }
                                    if ($news_type == 0) {
                                        $typeLabel = "<span class=\"label label-info\">" . lang("news_txt_4", true) . "</span>";
                                    } else {
                                        if ($news_type == 1) {
                                            $typeLabel = "<span class=\"label label-primary\">" . lang("news_txt_5", true) . "</span>";
                                        } else {
                                            if ($news_type == 2) {
                                                $typeLabel = "<span class=\"label label-success\">" . lang("news_txt_6", true) . "</span>";
                                            } else {
                                                if ($news_type == 3) {
                                                    $typeLabel = "<span class=\"label label-warning\">" . lang("news_txt_7", true) . "</span>";
                                                }
                                            }
                                        }
                                    }
                                    echo "\r\n        <div class=\"panel panel-default\">";
                                    if (mconfig("news_type") == 2) {
                                        echo "\r\n            <a href=\"" . $news_url . "\">";
                                    } else {
                                        echo "\r\n            <a " . $aClass . "role=\"button\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#news" . $nid . "\" aria-expanded=\"" . $ariaExpanded . "\" aria-controls=\"news" . $nid . "\">";
                                    }
                                    echo "\r\n                <div class=\"panel-heading\" role=\"tab\" id=\"heading" . $nid . "\">\r\n                    <h4 class=\"panel-title\">\r\n                        " . $news_title . "\r\n                        <div class=\"panel-title-date-div\">\r\n                            <b><span style=\"text-transform: uppercase;\"><small>" . $typeLabel . "</small></span></b>\r\n                            <b><span style=\"text-transform: uppercase;\"><small><span class=\"label label-default\">" . date($config["news_date"], $news_date) . "</span></small></span></b>\r\n                        </div>\r\n                    </h4>\r\n                </div>\r\n            </a>\r\n            <div id=\"news" . $nid . "\" class=\"panel-collapse collapse" . $collapseIn . "\" role=\"tabpanel\" aria-labelledby=\"heading" . $nid . "\">\r\n                <div class=\"panel-body\">\r\n                    " . $loadNewsCache;
                                    if (mconfig("news_enable_like_button")) {
                                        echo "\r\n                    <div style=\"width: 100%; float: right;\">\r\n                        <div style=\"float: right;\" class=\"fb-like\" data-href=\"" . $news_url . "\" data-width=\"670\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"true\" data-share=\"true\" data-colorscheme=\"dark\"></div>\r\n                    </div>";
                                    }
                                    if ($news_comments && mconfig("news_enable_comment_system")) {
                                        echo "\r\n                    <div class=\"fb-comments\" data-href=\"" . $news_url . "\" data-width=\"100%\" data-numposts=\"5\" data-colorscheme=\"dark\"></div>";
                                    }
                                    echo "\r\n                </div>\r\n            </div>\r\n        </div>";
                                }
                            }
                        }
                        $nid++;
                    }
                    echo "\r\n    </div>";
                } else {
                    echo "\r\n    <h3>\r\n        <a href=\"" . __BASE_URL__ . "news/history\" class=\"btn-simple btn-icon-plus pull-right\"></a>\r\n        " . lang("news_txt_3", true) . "\r\n    </h3>";
                    $nid = 0;
                    echo "\r\n    <div class=\"panel-group\" id=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">";
                    foreach ($loadNews as $thisNews) {
                        if ($nid <= mconfig("news_list_limit")) {
                            list($news_id, $news_visible) = $thisNews;
                            if ($news_visible) {
                                list($news_title, $news_author, $news_date, $news_comments, $news_type) = $thisNews;
                                $news_url = __BASE_URL__ . "news/" . Encode_id($news_id) . "/";
                                $loadNewsCache = $News->LoadCachedNews($news_id);
                                if (check_value($loadNewsCache)) {
                                    if (1 < $nid) {
                                        $aClass = "class=\"collapsed\" ";
                                        $ariaExpanded = "false";
                                        $collapseIn = "";
                                    } else {
                                        $aClass = "";
                                        $ariaExpanded = "true";
                                        $collapseIn = " in";
                                    }
                                    if (mconfig("news_type") == 2) {
                                        $aClass = "";
                                        $ariaExpanded = "true";
                                        $collapseIn = " in";
                                    }
                                    if ($news_type == 0) {
                                        $typeLabel = "<span class=\"label label-info\">" . lang("news_txt_4", true) . "</span>";
                                    } else {
                                        if ($news_type == 1) {
                                            $typeLabel = "<span class=\"label label-primary\">" . lang("news_txt_5", true) . "</span>";
                                        } else {
                                            if ($news_type == 2) {
                                                $typeLabel = "<span class=\"label label-success\">" . lang("news_txt_6", true) . "</span>";
                                            } else {
                                                if ($news_type == 3) {
                                                    $typeLabel = "<span class=\"label label-warning\">" . lang("news_txt_7", true) . "</span>";
                                                }
                                            }
                                        }
                                    }
                                    echo "\r\n        <div class=\"panel panel-default\">";
                                    if (mconfig("news_type") == 2) {
                                        echo "\r\n            <a href=\"" . $news_url . "\">";
                                    } else {
                                        echo "\r\n            <a " . $aClass . "role=\"button\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#news" . $nid . "\" aria-expanded=\"" . $ariaExpanded . "\" aria-controls=\"news" . $nid . "\">";
                                    }
                                    echo "\r\n                <div class=\"panel-heading\" role=\"tab\" id=\"heading" . $nid . "\">\r\n                    <h4 class=\"panel-title\">\r\n                        " . $news_title . "\r\n                        <div class=\"panel-title-date-div\">\r\n                            <b><span style=\"text-transform: uppercase;\"><small>" . $typeLabel . "</small></span></b>\r\n                            <b><span style=\"text-transform: uppercase;\"><small><span class=\"label label-default\">" . date($config["news_date"], $news_date) . "</span></small></span></b>\r\n                        </div>\r\n                    </h4>\r\n                </div>\r\n            </a>\r\n            <div id=\"news" . $nid . "\" class=\"panel-collapse collapse" . $collapseIn . "\" role=\"tabpanel\" aria-labelledby=\"heading" . $nid . "\">\r\n                <div class=\"panel-body\">\r\n                    " . $loadNewsCache;
                                    if (mconfig("news_enable_like_button")) {
                                        echo "\r\n                    <div style=\"width: 100%; float: right;\">\r\n                        <div style=\"float: right;\" class=\"fb-like\" data-href=\"" . $news_url . "\" data-width=\"670\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"true\" data-share=\"true\" data-colorscheme=\"dark\"></div>\r\n                    </div>";
                                    }
                                    if ($news_comments && mconfig("news_enable_comment_system")) {
                                        echo "\r\n                    <div class=\"fb-comments\" data-href=\"" . $news_url . "\" data-width=\"100%\" data-numposts=\"5\" data-colorscheme=\"dark\"></div>";
                                    }
                                    echo "\r\n                </div>\r\n            </div>\r\n        </div>";
                                }
                            }
                            $nid++;
                        } else {
                            echo "\r\n    </div>";
                        }
                    }
                }
            }
        }
    } else {
        message("error", lang("error_47", true));
    }
} else {
    if (mconfig("active")) {
        if (mconfig("news_enable_comment_system") || mconfig("news_enable_like_button")) {
            echo "\r\n        <div id=\"fb-root\"></div>\r\n        <script>(function(d, s, id) {\r\n            var js, fjs = d.getElementsByTagName(s)[0];\r\n            if (d.getElementById(id)) return;\r\n            js = d.createElement(s); js.id = id;\r\n            js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=" . mconfig("facebook_app_id") . "\";\r\n            fjs.parentNode.insertBefore(js, fjs);\r\n        }(document, 'script', 'facebook-jssdk'));</script>";
        }
        $News = new News();
        $loadNews = LoadCacheData("news.cache");
        if (is_array($loadNews)) {
            $requestedNewsId = $_GET["subpage"];
            if (check_value($requestedNewsId) && $requestedNewsId != "history" && $News->newsIdExists(Decode_id($requestedNewsId))) {
                $newsID = Decode_id($requestedNewsId);
                foreach ($loadNews as $thisNews) {
                    $news_id = $thisNews[0];
                    if ($news_id == $newsID) {
                        $news_visible = $thisNews[5];
                        if ($news_visible) {
                            list($news_title, $news_author, $news_date, $news_comments) = $thisNews;
                            $news_url = __BASE_URL__ . "news/" . Encode_id($news_id) . "/";
                            $loadNewsCache = $News->LoadCachedNews($news_id);
                            if (check_value($loadNewsCache)) {
                                echo "\r\n            <div class=\"header\">\r\n              <div class=\"header_left\">\r\n              <a href=\"" . $news_url . "\">" . $news_title . "<span class=\"title_overlay\"></a></span>\r\n              </div>\r\n              <div class=\"header_right\">\r\n                <ul>\r\n                  <li><a href=\"" . $news_url . "\">" . date($config["news_date"], $news_date) . "</a></li>\r\n                </ul>\r\n              </div>\r\n              <div class=\"clear\"></div>\r\n            </div>\r\n            <div class=\"active_latest_news\">\r\n              <div class=\"news_content\">\r\n                <p>" . $loadNewsCache . "</p>";
                                if (mconfig("news_enable_like_button")) {
                                    echo "\r\n                    <div style=\"width: 100%; padding: 0 0 10px 0; float: right;\">\r\n                        <div style=\"float: right;\" class=\"fb-like\" data-href=\"" . $news_url . "\" data-width=\"670\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"true\" data-share=\"true\" data-colorscheme=\"dark\"></div>\r\n                    </div>";
                                }
                                echo "\r\n              </div>\r\n              <div class=\"clear\"></div>\r\n            </div>";
                            }
                        }
                    }
                }
                if ($news_visible && $news_comments && mconfig("news_enable_comment_system")) {
                    echo "<div class=\"fb-comments\" data-href=\"" . $news_url . "\" data-width=\"670\" data-numposts=\"5\" data-colorscheme=\"dark\"></div>";
                }
            } else {
                if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                    if (check_value($_GET["subpage"]) && $_GET["subpage"] == "history") {
                        $breadcrumb = generateBreadcrumb();
                        echo "\r\n    <h3>\r\n        " . lang("news_txt_3", true) . $breadcrumb . "\r\n    </h3>";
                    } else {
                        echo "\r\n    <h3>\r\n        <a href=\"" . __BASE_URL__ . "news/history\" class=\"btn-simple btn-icon-plus pull-right\"></a>\r\n        " . lang("news_txt_3", true) . "\r\n    </h3>";
                    }
                    echo "\r\n    <div class=\"panel-group\" id=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">";
                }
                $nid = 0;
                foreach ($loadNews as $thisNews) {
                    if (1 <= $nid) {
                        $news_visible = $thisNews[5];
                        if ($news_visible && ($nid <= mconfig("news_list_limit") || check_value($_GET["subpage"]) && $_GET["subpage"] == "history")) {
                            list($news_id, $news_title, $news_author, $news_date, $news_comments, $news_type) = $thisNews;
                            $news_url = __BASE_URL__ . "news/" . Encode_id($news_id) . "/";
                            $loadNewsCache = $News->LoadCachedNews($news_id);
                            if (check_value($loadNewsCache)) {
                                if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                                    if (1 < $nid) {
                                        $aClass = "class=\"collapsed\" ";
                                        $ariaExpanded = "false";
                                        $collapseIn = "";
                                    } else {
                                        $aClass = "";
                                        $ariaExpanded = "true";
                                        $collapseIn = " in";
                                    }
                                    if ($news_type == 0) {
                                        $typeLabel = "<span class=\"label label-info\">" . lang("news_txt_4", true) . "</span>";
                                    } else {
                                        if ($news_type == 1) {
                                            $typeLabel = "<span class=\"label label-primary\">" . lang("news_txt_5", true) . "</span>";
                                        } else {
                                            if ($news_type == 2) {
                                                $typeLabel = "<span class=\"label label-success\">" . lang("news_txt_6", true) . "</span>";
                                            } else {
                                                if ($news_type == 3) {
                                                    $typeLabel = "<span class=\"label label-warning\">" . lang("news_txt_7", true) . "</span>";
                                                }
                                            }
                                        }
                                    }
                                    echo "\r\n        <div class=\"panel panel-default\">\r\n            <a " . $aClass . "role=\"button\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#news" . $nid . "\" aria-expanded=\"" . $ariaExpanded . "\" aria-controls=\"news" . $nid . "\">\r\n                <div class=\"panel-heading\" role=\"tab\" id=\"heading" . $nid . "\">\r\n                    <h4 class=\"panel-title\">\r\n                        " . $news_title . "\r\n                        <div class=\"panel-title-date-div\">\r\n                            <b><span style=\"text-transform: uppercase;\"><small>" . $typeLabel . "</small></span></b>\r\n                            <b><span style=\"text-transform: uppercase;\"><small><span class=\"label label-default\">" . date($config["news_date"], $news_date) . "</span></small></span></b>\r\n                        </div>\r\n                    </h4>\r\n                </div>\r\n            </a>\r\n            <div id=\"news" . $nid . "\" class=\"panel-collapse collapse" . $collapseIn . "\" role=\"tabpanel\" aria-labelledby=\"heading" . $nid . "\">\r\n                <div class=\"panel-body\">\r\n                    " . $loadNewsCache;
                                    if (mconfig("news_enable_like_button")) {
                                        echo "\r\n                    <div style=\"width: 100%; float: right;\">\r\n                        <div style=\"float: right;\" class=\"fb-like\" data-href=\"" . $news_url . "\" data-width=\"670\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"true\" data-share=\"true\" data-colorscheme=\"dark\"></div>\r\n                    </div>";
                                    }
                                    if ($news_comments && mconfig("news_enable_comment_system")) {
                                        echo "\r\n                    <div class=\"fb-comments\" data-href=\"" . $news_url . "\" data-width=\"100%\" data-numposts=\"5\" data-colorscheme=\"dark\"></div>";
                                    }
                                    echo "\r\n                </div>\r\n            </div>\r\n        </div>";
                                } else {
                                    if ($nid <= mconfig("news_expanded")) {
                                        echo "\r\n                <div class=\"header\">\r\n                  <div class=\"header_left\">\r\n                  <a href=\"" . $news_url . "\">" . $news_title . "<span class=\"title_overlay\"></a></span>\r\n                  </div>\r\n                  <div class=\"header_right\">\r\n                    <ul>\r\n                      <li><a href=\"" . $news_url . "\">" . date($config["news_date"], $news_date) . "</a></li>\r\n                    </ul>\r\n                  </div>\r\n                  <div class=\"clear\"></div>\r\n                </div>\r\n                <div class=\"active_latest_news\">\r\n                  <div class=\"news_content\">\r\n                    <p>" . $loadNewsCache . "</p>";
                                        if (mconfig("news_enable_like_button")) {
                                            echo "\r\n                    <div style=\"width: 100%; padding: 0 0 10px 0; float: right;\">\r\n                        <div style=\"float: right;\" class=\"fb-like\" data-href=\"" . $news_url . "\" data-width=\"670\" data-layout=\"button_count\" data-action=\"like\" data-show-faces=\"true\" data-share=\"true\" data-colorscheme=\"dark\"></div>\r\n                    </div>";
                                        }
                                        echo "\r\n                  </div>\r\n                  <div class=\"clear\"></div>\r\n                </div>";
                                        if ($news_comments && mconfig("news_enable_comment_system")) {
                                            echo "<div class=\"fb-comments\" data-href=\"" . $news_url . "\" data-width=\"670\" data-numposts=\"5\" data-colorscheme=\"dark\"></div>";
                                        }
                                    } else {
                                        echo "\r\n                <div class=\"header\">\r\n                  <div class=\"header_left\">\r\n                  <a href=\"" . $news_url . "\">" . $news_title . "<span class=\"title_overlay\"></a></span>\r\n                  </div>\r\n                  <div class=\"header_right\">\r\n                    <ul>\r\n                      <li><a href=\"" . $news_url . "\">" . date($config["news_date"], $news_date) . "</a></li>\r\n                    </ul>\r\n                  </div>\r\n                  <div class=\"clear\"></div>\r\n                </div>";
                                    }
                                }
                            }
                        }
                    }
                    $nid++;
                }
                if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
                    echo "\r\n        </div>";
                }
            }
        }
    } else {
        message("error", lang("error_47", true));
    }
}

?>