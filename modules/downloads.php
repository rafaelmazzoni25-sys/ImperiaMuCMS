<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$downloads = mconfig("downloads");
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_8", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    if (mconfig("active")) {
        $downloadsCACHE = LoadCacheData("downloads.cache");
        $downloadCLIENTS = [];
        $downloadPATCHES = [];
        $downloadTOOLS = [];
        foreach ($downloadsCACHE as $key => $tempDownloadsData) {
            if (0 < $key) {
                switch ($tempDownloadsData[5]) {
                    case 1:
                        $downloadCLIENTS[] = $tempDownloadsData;
                        break;
                    case 2:
                        $downloadPATCHES[] = $tempDownloadsData;
                        break;
                    case 3:
                        $downloadTOOLS[] = $tempDownloadsData;
                        break;
                }
            }
        }
        function showDownloads($downloadData, $title = "")
        {
            if (is_array($downloadData)) {
                echo "\r\n                <div class=\"col-xs-12 col-md-6\">\r\n                    <div class=\"panel panel-default\">\r\n                        <div class=\"panel-heading\">" . $title . "</div>\r\n                        <div class=\"panel-body\">";
                foreach ($downloadData as $thisDownload) {
                    if ($thisDownload[6] == "0") {
                        $open_type = "_blank";
                    } else {
                        $open_type = "_self";
                    }
                    echo "\r\n                            <div class=\"list-group\">\r\n                                <a href=\"" . $thisDownload[2] . "\" title=\"" . lang("downloads_txt_5", true) . " " . $thisDownload[1] . "\" target=\"" . $open_type . "\" class=\"list-group-item\">\r\n                                    <strong>" . $thisDownload[1] . "</strong>&nbsp;\r\n                                    <small>(" . round($thisDownload[3], 2) . " " . lang("downloads_txt_4", true) . ")</small>\r\n                                    <span style=\"float: right;\">" . $thisDownload[4] . "&nbsp;<i class=\"glyphicon glyphicon-cloud-download\"></i></span><br />\r\n                                    <small>" . $thisDownload[7] . "</small>\r\n                                </a>\r\n                            </div>";
                }
                echo "\r\n                        </div>\r\n                    </div>\r\n                </div>";
            }
        }
        if (mconfig("show_client_downloads")) {
            showDownloads($downloadCLIENTS, lang("downloads_txt_6", true));
        }
        if (mconfig("show_patch_downloads")) {
            showDownloads($downloadPATCHES, lang("downloads_txt_7", true));
        }
        if (mconfig("show_tool_downloads")) {
            showDownloads($downloadTOOLS, lang("downloads_txt_8", true));
        }
        if (mconfig("show_req")) {
            echo "\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"panel panel-default\">\r\n                    <div class=\"panel-heading\">" . lang("downloads_txt_9", true) . "</div>\r\n                    <div class=\"panel-body\">\r\n                        <table class=\"table table-hover system-req\" align=\"center\">\r\n                            <thead>\r\n                                <tr>\r\n                                    <th width=\"50%\">" . lang("downloads_txt_10", true) . "</th>\r\n                                    <th width=\"50%\">" . lang("downloads_txt_11", true) . "</th>\r\n                                </tr>\r\n                            </thead>\r\n                            <tbody>\r\n                                <tr>\r\n                                    <td>" . lang("downloads_txt_12", true) . "</td>\r\n                                    <td>" . lang("downloads_txt_13", true) . "</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>" . lang("downloads_txt_14", true) . "</td>\r\n                                    <td>" . lang("downloads_txt_15", true) . "</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>" . lang("downloads_txt_16", true) . "</td>\r\n                                    <td>" . lang("downloads_txt_17", true) . "</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>" . lang("downloads_txt_18", true) . "</td>\r\n                                    <td>" . lang("downloads_txt_19", true) . "</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>" . lang("downloads_txt_20", true) . "</td>\r\n                                    <td>" . lang("downloads_txt_21", true) . "</td>\r\n                                </tr>\r\n                                <tr>\r\n                                    <td>" . lang("downloads_txt_22", true) . "</td>\r\n                                    <td>" . lang("downloads_txt_23", true) . "</td>\r\n                                </tr>\r\n                            </tbody>\r\n                        </table>\r\n                    </div>\r\n                </div>\r\n            </div>";
        }
        if (mconfig("show_drivers")) {
            echo "\r\n            <div class=\"col-xs-12\">\r\n                <div class=\"panel panel-default\">\r\n                    <div class=\"panel-heading\">" . lang("downloads_txt_24", true) . "</div>\r\n                    <div class=\"panel-body\">\r\n                        <div class=\"col-xs-6 col-sm-3 text-center\">\r\n                            <a href=\"https://www.microsoft.com/en-us/download/details.aspx?id=8109\" target=\"_blank\"><img class=\"drivers-img\" src=\"" . __PATH_TEMPLATE__ . "images/mark_down_direct.jpg\"></a>\r\n                        </div>\r\n                        <div class=\"col-xs-6 col-sm-3 text-center\">\r\n                            <a href=\"http://www.nvidia.com/Download/index.aspx\" target=\"_blank\"><img class=\"drivers-img\" src=\"" . __PATH_TEMPLATE__ . "images/mark_down_nvidea.jpg\"></a>\r\n                        </div>\r\n                        <div class=\"col-xs-6 col-sm-3 text-center\">\r\n                            <a href=\"http://support.amd.com/en-us/download\" target=\"_blank\"><img class=\"drivers-img\" src=\"" . __PATH_TEMPLATE__ . "images/mark_down_ati.jpg\"></a>\r\n                        </div>\r\n                        <div class=\"col-xs-6 col-sm-3 text-center\">\r\n                            <a href=\"https://downloadcenter.intel.com\" target=\"_blank\"><img class=\"drivers-img\" src=\"" . __PATH_TEMPLATE__ . "images/mark_down_intel.jpg\"></a>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </div>";
        }
    } else {
        message("error", lang("error_47", true));
    }
} else {
    echo "\r\n<div class=\"sub-page-title\">\r\n    <div id=\"title\">\r\n        <h1>" . lang("module_titles_txt_8", true) . "<p></p><span></span></h1>\r\n    </div>\r\n</div>\r\n<div class=\"container_2 features\" align=\"center\">";
    if (mconfig("active")) {
        echo "<ul>";
        $downloadsCACHE = LoadCacheData("downloads.cache");
        $downloadCLIENTS = [];
        $downloadPATCHES = [];
        $downloadTOOLS = [];
        foreach ($downloadsCACHE as $key => $tempDownloadsData) {
            if (0 < $key) {
                switch ($tempDownloadsData[5]) {
                    case 1:
                        $downloadCLIENTS[] = $tempDownloadsData;
                        break;
                    case 2:
                        $downloadPATCHES[] = $tempDownloadsData;
                        break;
                    case 3:
                        $downloadTOOLS[] = $tempDownloadsData;
                        break;
                }
            }
        }
        function showDownloads($downloadData, $title = "")
        {
            if (is_array($downloadData)) {
                echo "\r\n                <div class=\"col-xs-12 col-md-6\">\r\n                    <div class=\"panel panel-default\">\r\n                        <div class=\"panel-heading\">" . $title . "</div>\r\n                        <div class=\"panel-body\">";
                foreach ($downloadData as $thisDownload) {
                    if ($thisDownload[6] == "0") {
                        $open_type = "_blank";
                    } else {
                        $open_type = "_self";
                    }
                    echo "\r\n                            <div class=\"list-group\">\r\n                                <a href=\"" . $thisDownload[2] . "\" title=\"" . lang("downloads_txt_5", true) . " " . $thisDownload[1] . "\" target=\"" . $open_type . "\" class=\"list-group-item\">\r\n                                    <strong>" . $thisDownload[1] . "</strong>&nbsp;\r\n                                    <small>(" . round($thisDownload[3], 2) . " " . lang("downloads_txt_4", true) . ")</small>\r\n                                    <span style=\"float: right;\">" . $thisDownload[4] . "&nbsp;<i class=\"glyphicon glyphicon-cloud-download\"></i></span><br />\r\n                                    <small>" . $thisDownload[7] . "</small>\r\n                                </a>\r\n                            </div>";
                }
                echo "\r\n                        </div>\r\n                    </div>\r\n                </div>";
            }
        }
        if (mconfig("show_client_downloads")) {
            showDownloads($downloadCLIENTS, lang("downloads_txt_6", true));
        }
        if (mconfig("show_patch_downloads")) {
            showDownloads($downloadPATCHES, lang("downloads_txt_7", true));
        }
        if (mconfig("show_tool_downloads")) {
            showDownloads($downloadTOOLS, lang("downloads_txt_8", true));
        }
        if (mconfig("show_req")) {
            echo "\r\n        <li class=\"container_3 archived-news w-addons\" id=\"xprate\">\r\n            <div class=\"w-addon-row\">\r\n                <div class=\"addon-info\">\r\n                    <div style=\"width: 700px;\">\r\n                        <h1>" . lang("downloads_txt_9", true) . "</h1>\r\n                        <table class=\"general-table-ui\" width=\"700px\">\r\n                            <tr>\r\n                                <th width=\"50%\">" . lang("downloads_txt_10", true) . "</th>\r\n                                <th width=\"50%\">" . lang("downloads_txt_11", true) . "</th>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("downloads_txt_12", true) . "</td>\r\n                                <td>" . lang("downloads_txt_13", true) . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("downloads_txt_14", true) . "</td>\r\n                                <td>" . lang("downloads_txt_15", true) . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("downloads_txt_16", true) . "</td>\r\n                                <td>" . lang("downloads_txt_17", true) . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("downloads_txt_18", true) . "</td>\r\n                                <td>" . lang("downloads_txt_19", true) . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("downloads_txt_20", true) . "</td>\r\n                                <td>" . lang("downloads_txt_21", true) . "</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td>" . lang("downloads_txt_22", true) . "</td>\r\n                                <td>" . lang("downloads_txt_23", true) . "</td>\r\n                            </tr>\r\n                        </table>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div class=\"clear\"></div>\r\n        </li>";
        }
        if (mconfig("show_drivers")) {
            echo "\r\n         <li class=\"container_3 archived-news w-addons\" id=\"xprate\">\r\n            <div class=\"w-addon-row\">\r\n                <div class=\"addon-info\">\r\n                    <div style=\"width: 700px;\">\r\n                        <h1>" . lang("downloads_txt_24", true) . "</h1>\r\n                        <table width=\"100%\">\r\n                            <tr>\r\n                                <td width=\"25%\" align=\"center\"><a href=\"https://www.microsoft.com/en-us/download/details.aspx?id=8109\" target=\"_blank\"><img class=\"drivers-img\" src=\"" . __PATH_TEMPLATE__ . "style/images/mark_down_direct.jpg\"></a></td>\r\n                                <td width=\"25%\" align=\"center\"><a href=\"http://www.nvidia.com/Download/index.aspx\" target=\"_blank\"><img class=\"drivers-img\" src=\"" . __PATH_TEMPLATE__ . "style/images/mark_down_nvidea.jpg\"></a></td>\r\n                                <td width=\"25%\" align=\"center\"><a href=\"http://support.amd.com/en-us/download\" target=\"_blank\"><img class=\"drivers-img\" src=\"" . __PATH_TEMPLATE__ . "style/images/mark_down_ati.jpg\"></a></td>\r\n                                <td width=\"25%\" align=\"center\"><a href=\"https://downloadcenter.intel.com\" target=\"_blank\"><img class=\"drivers-img\" src=\"" . __PATH_TEMPLATE__ . "style/images/mark_down_intel.jpg\"></a></td>\r\n                            </tr>\r\n                        </table>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div class=\"clear\"></div>\r\n        </li>";
        }
        echo "</ul>";
    } else {
        message("error", lang("error_47", true));
    }
    echo "\r\n  <div class=\"features-bg\"></div>\r\n</div>\r\n";
}

?>