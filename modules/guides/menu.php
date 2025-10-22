<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */
$menu = [["Level Up Guide", ["lvx" => ["Level X", ["howtostart" => "How to Start"]], "tutorialfornewbiesupport" => "Tutorial for Newbie Support", "lv130" => "Lv 1~30", "lv3050" => "Lv 30~50", "lv5080" => "Lv 50~80", "lv220" => "Lv 220~"]], ["How to start", "empty"]];
echo "\r\n<div class=\"store_left_side\" style=\"width: 210px;\">\r\n    <div class=\"scrollable\" id=\"left_scrollbable\">\r\n        <div class=\"scrollbar disable\" style=\"height: 894px;\">\r\n            <div class=\"track\" style=\"height: 894px;\">\r\n                <div class=\"thumb\" style=\"top: 0px; height: 894px;\">\r\n                    <div class=\"end\"></div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <div class=\"viewport\">\r\n            <div class=\"overview\" style=\"top:0px;\">\r\n                ";
foreach ($menu as $menuItem) {
    $showClass = "";
    $activeClass = "";
    $showSubClass = "";
    $activeSubClass = "";
    if (is_array($menuItem[1])) {
        if (check_value($_GET["subpage"])) {
            if (array_key_exists($_GET["subpage"], $menuItem[1])) {
                $activeClass = " active";
                $showClass = " show";
            } else {
                foreach ($menuItem[1] as $key => $text) {
                    if (is_array($text) && array_key_exists($_GET["subpage"], $text[1])) {
                        $activeClass = " active";
                        $showClass = " show";
                        $activeSubClass = " active";
                        $showSubClass = " show";
                    }
                }
            }
        }
        echo "<button type=\"button\" class=\"guide_accordion" . $activeClass . "\">" . $menuItem[0] . "</button>";
        echo "<div class=\"guide_subpanel" . $showClass . "\">";
        foreach ($menuItem[1] as $menuSubItemModule => $menuSubItemTitle) {
            if (is_array($menuSubItemTitle)) {
                echo "<button type=\"button\" class=\"guide_accordion subaccordion" . $activeSubClass . "\">" . $menuSubItemTitle[0] . "</button>";
                if (is_array($menuSubItemTitle[1])) {
                    echo "<div class=\"guide_subpanel sub2panel" . $showSubClass . "\">";
                    foreach ($menuSubItemTitle[1] as $subModule => $subTitle) {
                        $active_cat = $_GET["subpage"] == $subModule ? "active_category" : "";
                        echo "<a href=\"" . __BASE_URL__ . "guides/" . $subModule . "/\" class=\"store_sub_category_button " . $active_cat . "\">\r\n                                            <span>" . $subTitle . "</span>\r\n                                         </a>";
                    }
                    echo "</div>";
                }
            } else {
                $active_cat = $_GET["subpage"] == $menuSubItemModule ? "active_category" : "";
                echo "<a href=\"" . __BASE_URL__ . "guides/" . $menuSubItemModule . "/\" class=\"store_sub_category_button " . $active_cat . "\">\r\n                                    <span>" . $menuSubItemTitle . "</span>\r\n                                 </a>";
            }
        }
        echo "</div>";
    } else {
        if (check_value($_GET["subpage"]) && $_GET["subpage"] == $menuItem[1]) {
            $activeClass = " active";
        }
        echo "<a href=\"" . __BASE_URL__ . "guides/" . $menuItem[1] . "/\" class=\"guide_button" . $activeClass . "\">" . $menuItem[0] . "</a>";
    }
}
echo "            </div>\r\n        </div>\r\n    </div>\r\n</div>\r\n\r\n<script type=\"text/javascript\">\r\nvar acc = document.getElementsByClassName(\"guide_accordion\");\r\nvar i;\r\n\r\nfor (i = 0; i < acc.length; i++) {\r\n    acc[i].onclick = function(){\r\n        this.classList.toggle(\"active\");\r\n        this.nextElementSibling.classList.toggle(\"show\");\r\n  }\r\n}\r\n</script>";

?>