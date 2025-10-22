<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
if (!isLoggedIn()) {
    redirect(1, "login");
} else {
    if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
        $breadcrumb = generateBreadcrumb();
        echo "\r\n    <h3>\r\n        " . lang("guides_txt_1", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
        if (mconfig("active")) {
            $guides = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES WHERE active = '1' ORDER BY category_id, subcategory_id, position");
            $cats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES_CATEGORIES WHERE active = '1' ORDER BY position");
            $subcats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES_SUBCATEGORIES WHERE active = '1' ORDER BY category_id, position");
            if (check_value($_GET["guide"])) {
                $id = xss_clean($_GET["guide"]);
                $id = explode(";", $id);
                list($cat_id, $subcat_id, $guide_id) = $id;
                if (is_numeric($guide_id)) {
                    $guideData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_GUIDES WHERE id = ? AND active = ?", [$guide_id, "1"]);
                    if (is_array($guideData)) {
                        $content = true;
                    }
                }
            } else {
                $guideData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_GUIDES WHERE id = ? AND active = ?", [mconfig("default_guide"), "1"]);
                if (is_array($guideData)) {
                    $cat_id = $guideData["category_id"];
                    $subcat_id = $guideData["subcategory_id"];
                    $guide_id = $guideData["id"];
                    $content = true;
                }
            }
            echo "\r\n    <div class=\"row\">\r\n        <div class=\"col-xs-12 col-md-4 col-lg-3\">";
            foreach ($cats as $thisCat) {
                echo "\r\n            <button class=\"btn btn-warning full-width-btn\" type=\"button\" data-toggle=\"collapse\" data-target=\"#subcats_" . $thisCat["id"] . "\" aria-expanded=\"false\" aria-controls=\"subcats_" . $thisCat["id"] . "\">\r\n                " . $thisCat["title"] . "\r\n            </button>";
                if (is_array($subcats)) {
                    echo "\r\n            <div id=\"subcats_" . $thisCat["id"] . "\" aria-expanded=\"false\" class=\"collapse\">";
                    foreach ($subcats as $thisSubcat) {
                        if ($thisSubcat["category_id"] == $thisCat["id"]) {
                            echo "\r\n                <button class=\"btn btn-primary full-width-btn\" type=\"button\" data-toggle=\"collapse\" data-target=\"#guides_" . $thisCat["id"] . "_" . $thisSubcat["id"] . "\" aria-expanded=\"false\" aria-controls=\"guides_" . $thisCat["id"] . "_" . $thisSubcat["id"] . "\">\r\n                    " . $thisSubcat["title"] . "\r\n                </button>";
                            if (is_array($guides)) {
                                echo "\r\n                <div id=\"guides_" . $thisCat["id"] . "_" . $thisSubcat["id"] . "\" aria-expanded=\"false\" class=\"collapse\">";
                                foreach ($guides as $thisGuide) {
                                    if ($thisGuide["category_id"] == $thisCat["id"] && $thisGuide["subcategory_id"] == $thisSubcat["id"]) {
                                        echo "\r\n                    <a href=\"" . __BASE_URL__ . "guides/?guide=" . $thisGuide["category_id"] . ";" . $thisGuide["subcategory_id"] . ";" . $thisGuide["id"] . "\">\r\n                        <button class=\"btn btn-brand full-width-btn\" type=\"button\">\r\n                            " . $thisGuide["title"] . "\r\n                        </button>\r\n                    </a>";
                                    }
                                }
                                echo "\r\n                </div>";
                            }
                        }
                    }
                    if (is_array($guides)) {
                        foreach ($guides as $thisGuide) {
                            if ($thisGuide["category_id"] == $thisCat["id"] && ($thisGuide["subcategory_id"] == NULL || $thisGuide["subcategory_id"] == 0)) {
                                echo "\r\n                <a href=\"" . __BASE_URL__ . "guides/?guide=" . $thisGuide["category_id"] . ";" . $thisGuide["subcategory_id"] . ";" . $thisGuide["id"] . "\">\r\n                    <button class=\"btn btn-brand full-width-btn\" type=\"button\">\r\n                        " . $thisGuide["title"] . "\r\n                    </button>\r\n                </a>";
                            }
                        }
                    }
                    echo "\r\n            </div>";
                } else {
                    if (is_array($guides)) {
                        echo "\r\n            <div id=\"subcats_" . $thisCat["id"] . "\" aria-expanded=\"false\" class=\"collapse\">";
                        foreach ($guides as $thisGuide) {
                            if ($thisGuide["category_id"] == $thisCat["id"] && ($thisGuide["subcategory_id"] == NULL || $thisGuide["subcategory_id"] == 0)) {
                                echo "\r\n                <a href=\"" . __BASE_URL__ . "guides/?guide=" . $thisGuide["category_id"] . ";" . $thisGuide["subcategory_id"] . ";" . $thisGuide["id"] . "\">\r\n                    <button class=\"btn btn-brand full-width-btn\" type=\"button\">\r\n                        " . $thisGuide["title"] . "\r\n                    </button>\r\n                </a>";
                            }
                        }
                        echo "\r\n            </div>";
                    }
                }
                echo "<div class=\"btn-guide-cat\"></div>";
            }
            echo "\r\n        </div>\r\n        <div class=\"col-xs-12 col-md-8 col-lg-9\">\r\n            <h4 class=\"guide-title\">" . $guideData["title"] . "</h4>\r\n            " . stripslashes($guideData["text"]) . "\r\n        </div>\r\n    </div>";
        }
    } else {
        $guides = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES WHERE active = '1' ORDER BY category_id, subcategory_id, position");
        $cats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES_CATEGORIES WHERE active = '1' ORDER BY position");
        $subcats = $dB->query_fetch("SELECT * FROM IMPERIAMUCMS_GUIDES_SUBCATEGORIES WHERE active = '1' ORDER BY category_id, position");
        $content = false;
        if (check_value($_GET["guide"])) {
            $id = xss_clean($_GET["guide"]);
            $id = explode(";", $id);
            list($cat_id, $subcat_id, $guide_id) = $id;
            if (is_numeric($guide_id)) {
                $guideData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_GUIDES WHERE id = ? AND active = ?", [$guide_id, "1"]);
                if (is_array($guideData)) {
                    $content = true;
                }
            }
        } else {
            $guideData = $dB->query_fetch_single("SELECT * FROM IMPERIAMUCMS_GUIDES WHERE id = ? AND active = ?", [mconfig("default_guide"), "1"]);
            if (is_array($guideData)) {
                $cat_id = $guideData["category_id"];
                $subcat_id = $guideData["subcategory_id"];
                $guide_id = $guideData["id"];
                $content = true;
            }
        }
        echo "\r\n    <link rel=\"stylesheet\" href=\"";
        echo __PATH_TEMPLATE__;
        echo "style/guides.css\"/>\r\n    <div class=\"sub-page-title\">\r\n        <div id=\"title\">\r\n            <h1>";
        echo lang("guides_txt_1", true);
        echo "<p></p><span></span></h1>\r\n        </div>\r\n    </div>\r\n\r\n    ";
        if (mconfig("active")) {
            echo "        <div class=\"container_2 account store\" align=\"center\">\r\n            <div class=\"cont-image\">\r\n                <div class=\"container_3 account_sub_header\">\r\n                    <div class=\"grad\">\r\n                        <div class=\"page-title\">\r\n                            ";
            if ($content) {
                echo stripslashes($guideData["title"]);
            } else {
                echo lang("guides_txt_2", true);
            }
            echo "                        </div>\r\n                        <a href=\"";
            echo __BASE_URL__;
            echo "usercp\">";
            echo lang("guides_txt_3", true);
            echo "</a>\r\n                    </div>\r\n                </div>\r\n                <div class=\"page-desc-holder\">\r\n\r\n                </div>\r\n                <script type=\"text/javascript\">\r\n                    \$(document).ready(function () {\r\n                        \$('#left_scrollbable').tinyscrollbar();\r\n                        \$('.store_items_list').tinyscrollbar();\r\n                        \$('.store_body').WarcryStore();\r\n                    });\r\n                </script>\r\n\r\n                <div class=\"store_body\" style=\"margin: 0 0 0 0;\">\r\n                    <form id=\"store_form\" method=\"post\">\r\n                        <div style=\"padding-top: 10px;\"></div>\r\n                        <div class=\"store_inner_body\">\r\n\r\n\r\n                            <div class=\"store_left_side\" style=\"width: 210px;\">\r\n                                <div class=\"scrollable\" id=\"left_scrollbable\">\r\n                                    <div class=\"scrollbar disable\" style=\"height: 894px;\">\r\n                                        <div class=\"track\" style=\"height: 894px;\">\r\n                                            <div class=\"thumb\" style=\"top: 0px; height: 894px;\">\r\n                                                <div class=\"end\"></div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"viewport\">\r\n                                        <div class=\"overview\" style=\"top:0px;\">\r\n                                            ";
            if (is_array($cats)) {
                foreach ($cats as $thisCat) {
                    $showClass = "";
                    $activeClass = "";
                    if ($cat_id == $thisCat["id"]) {
                        $activeClass = " active";
                        $showClass = " show";
                    }
                    $openSubpanel = true;
                    $closeSubpanel = false;
                    echo "<button type=\"button\" class=\"guide_accordion" . $activeClass . "\">" . stripslashes($thisCat["title"]) . "</button>";
                    if (is_array($subcats)) {
                        $i = 1;
                        foreach ($subcats as $thisSubcat) {
                            $showSubClass = "";
                            $activeSubClass = "";
                            if ($subcat_id == $thisSubcat["id"]) {
                                $activeSubClass = " active";
                                $showSubClass = " show";
                            }
                            if ($thisSubcat["category_id"] == $thisCat["id"]) {
                                if ($i == 1) {
                                    $openSubpanel = false;
                                    $closeSubpanel = true;
                                    echo "<div class=\"guide_subpanel" . $showClass . "\">";
                                }
                                echo "<button type=\"button\" class=\"guide_accordion subaccordion" . $activeSubClass . "\">" . stripslashes($thisSubcat["title"]) . "</button>";
                                if (is_array($guides)) {
                                    echo "<div class=\"guide_subpanel sub2panel" . $showSubClass . "\">";
                                    foreach ($guides as $thisGuide) {
                                        $active_cat = "";
                                        if ($guide_id == $thisGuide["id"]) {
                                            $active_cat = "active_category";
                                        }
                                        if ($thisGuide["category_id"] == $thisCat["id"] && $thisGuide["subcategory_id"] == $thisSubcat["id"]) {
                                            echo "\r\n                                                                <a href=\"" . __BASE_URL__ . "guides/?guide=" . $thisGuide["category_id"] . ";" . $thisGuide["subcategory_id"] . ";" . $thisGuide["id"] . "\" class=\"store_sub_category_button " . $active_cat . "\">\r\n                                                                    <span>" . stripslashes($thisGuide["title"]) . "</span>\r\n                                                                </a>";
                                        }
                                    }
                                    echo "</div>";
                                }
                                $i++;
                            }
                        }
                        if (1 < $i) {
                        }
                    }
                    if (is_array($guides)) {
                        if ($openSubpanel) {
                            $closeSubpanel = true;
                            echo "<div class=\"guide_subpanel" . $showClass . "\">";
                        }
                        foreach ($guides as $thisGuide) {
                            $active_cat = "";
                            if ($guide_id == $thisGuide["id"]) {
                                $active_cat = "active_category";
                            }
                            if ($thisGuide["category_id"] == $thisCat["id"] && $thisGuide["subcategory_id"] == 0) {
                                echo "\r\n                                                    <a href=\"" . __BASE_URL__ . "guides/?guide=" . $thisGuide["category_id"] . ";" . $thisGuide["subcategory_id"] . ";" . $thisGuide["id"] . "\" class=\"store_sub_category_button " . $active_cat . "\">\r\n                                                        <span>" . stripslashes($thisGuide["title"]) . "</span>\r\n                                                    </a>";
                            }
                        }
                    }
                    if ($closeSubpanel) {
                        echo "</div>";
                    }
                }
            }
            echo "                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n\r\n\r\n                            <div class=\"store_right_side\">\r\n                                <div class=\"store_items_list\">\r\n                                    <div class=\"scrollbar disable\" style=\"height: 554px;\">\r\n                                        <div class=\"track\" style=\"height: 554px;\">\r\n                                            <div class=\"thumb\" style=\"top: 0px; height: 554px;\">\r\n                                                <div class=\"end\"></div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"viewport\">\r\n                                        <div class=\"overview\" style=\"top: 0px;\">\r\n                                            <div class=\"items\">\r\n                                                ";
            if ($content) {
                echo stripslashes($guideData["text"]);
            } else {
                message("error", lang("guides_txt_4", true));
            }
            echo "                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"clear\"></div>\r\n                        </div>\r\n                    </form>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        ";
        } else {
            message("error", lang("error_47", true));
        }
        echo "\r\n    <script type=\"text/javascript\">\r\n        var acc = document.getElementsByClassName(\"guide_accordion\");\r\n        var i;\r\n\r\n        for (i = 0; i < acc.length; i++) {\r\n            acc[i].onclick = function () {\r\n                this.classList.toggle(\"active\");\r\n                this.nextElementSibling.classList.toggle(\"show\");\r\n            }\r\n        }\r\n    </script>\r\n    ";
    }
}

?>