<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

$Rankings = new Rankings();
if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\r\n    <h3>\r\n        " . lang("module_titles_txt_10", true) . "\r\n        " . $breadcrumb . "\r\n    </h3>";
    $menu = $Rankings->rankingsMenu(false);
    echo $menu;
    loadModuleConfigs("rankings");
    if (mconfig("active") && mconfig("rankings_enable_afk")["@attributes"]["general"]) {
        $ranking_data = LoadCacheData("rankings_afk.cache");
        echo "\r\n        <div class=\"table-responsive rankings-table\">\r\n            <table class=\"table table-hover text-center\">\r\n                <thead>\r\n                    <tr>";
        if (mconfig("rankings_show_place_number")) {
            echo "<th>#</th>";
        }
        echo "<th>" . lang("rankings_txt_10", true) . "</th>";
        if (mconfig("rankings_afk_order1") == "TotalTime") {
            echo "<th>" . lang("rankings_txt_72", true) . "</th>";
        } else {
            if (mconfig("rankings_afk_order1") == "TotalDmg") {
                echo "<th>" . lang("rankings_txt_73", true) . "</th>";
            } else {
                if (mconfig("rankings_afk_order1") == "TotalElDmg") {
                    echo "<th>" . lang("rankings_txt_74", true) . "</th>";
                } else {
                    if (mconfig("rankings_afk_order1") == "TotalKills") {
                        echo "<th>" . lang("rankings_txt_75", true) . "</th>";
                    } else {
                        if (mconfig("rankings_afk_order1") == "TotalExp") {
                            echo "<th>" . lang("rankings_txt_76", true) . "</th>";
                        }
                    }
                }
            }
        }
        if (mconfig("rankings_afk_order2") == "TotalTime") {
            echo "<th>" . lang("rankings_txt_72", true) . "</th>";
        } else {
            if (mconfig("rankings_afk_order2") == "TotalDmg") {
                echo "<th>" . lang("rankings_txt_73", true) . "</th>";
            } else {
                if (mconfig("rankings_afk_order2") == "TotalElDmg") {
                    echo "<th>" . lang("rankings_txt_74", true) . "</th>";
                } else {
                    if (mconfig("rankings_afk_order2") == "TotalKills") {
                        echo "<th>" . lang("rankings_txt_75", true) . "</th>";
                    } else {
                        if (mconfig("rankings_afk_order2") == "TotalExp") {
                            echo "<th>" . lang("rankings_txt_76", true) . "</th>";
                        }
                    }
                }
            }
        }
        if (mconfig("rankings_afk_order3") == "TotalTime") {
            echo "<th>" . lang("rankings_txt_72", true) . "</th>";
        } else {
            if (mconfig("rankings_afk_order3") == "TotalDmg") {
                echo "<th>" . lang("rankings_txt_73", true) . "</th>";
            } else {
                if (mconfig("rankings_afk_order3") == "TotalElDmg") {
                    echo "<th>" . lang("rankings_txt_74", true) . "</th>";
                } else {
                    if (mconfig("rankings_afk_order3") == "TotalKills") {
                        echo "<th>" . lang("rankings_txt_75", true) . "</th>";
                    } else {
                        if (mconfig("rankings_afk_order3") == "TotalExp") {
                            echo "<th>" . lang("rankings_txt_76", true) . "</th>";
                        }
                    }
                }
            }
        }
        if (mconfig("rankings_afk_order4") == "TotalTime") {
            echo "<th>" . lang("rankings_txt_72", true) . "</th>";
        } else {
            if (mconfig("rankings_afk_order4") == "TotalDmg") {
                echo "<th>" . lang("rankings_txt_73", true) . "</th>";
            } else {
                if (mconfig("rankings_afk_order4") == "TotalElDmg") {
                    echo "<th>" . lang("rankings_txt_74", true) . "</th>";
                } else {
                    if (mconfig("rankings_afk_order4") == "TotalKills") {
                        echo "<th>" . lang("rankings_txt_75", true) . "</th>";
                    } else {
                        if (mconfig("rankings_afk_order4") == "TotalExp") {
                            echo "<th>" . lang("rankings_txt_76", true) . "</th>";
                        }
                    }
                }
            }
        }
        if (mconfig("rankings_afk_order5") == "TotalTime") {
            echo "<th>" . lang("rankings_txt_72", true) . "</th>";
        } else {
            if (mconfig("rankings_afk_order5") == "TotalDmg") {
                echo "<th>" . lang("rankings_txt_73", true) . "</th>";
            } else {
                if (mconfig("rankings_afk_order5") == "TotalElDmg") {
                    echo "<th>" . lang("rankings_txt_74", true) . "</th>";
                } else {
                    if (mconfig("rankings_afk_order5") == "TotalKills") {
                        echo "<th>" . lang("rankings_txt_75", true) . "</th>";
                    } else {
                        if (mconfig("rankings_afk_order5") == "TotalExp") {
                            echo "<th>" . lang("rankings_txt_76", true) . "</th>";
                        }
                    }
                }
            }
        }
        if ($config["flags"]) {
            echo "<th>" . lang("global_module_11", true) . "</th>";
        }
        echo "\r\n                    </tr>\r\n                </thead>\r\n                <tbody>";
        $i = 0;
        foreach ($ranking_data as $rdata) {
            if (1 <= $i) {
                $rdata[2] = floor($rdata[2] / 60);
                $days = floor($rdata[2] / 1440);
                $rdata[2] = $rdata[2] % 1440;
                $hours = floor($rdata[2] / 60);
                $rdata[2] = $rdata[2] % 60;
                $minutes = $rdata[2];
                if (10000 <= $rdata[3]) {
                    $dmg = number_format(floor($rdata[3] / 1000)) . "k";
                } else {
                    $dmg = number_format($rdata[3]);
                }
                if (10000 <= $rdata[4]) {
                    $elemDmg = number_format(floor($rdata[4] / 1000)) . "k";
                } else {
                    $elemDmg = number_format($rdata[4]);
                }
                if (10000 <= $rdata[5]) {
                    $monsterKills = number_format(floor($rdata[5] / 1000)) . "k";
                } else {
                    $monsterKills = number_format($rdata[5]);
                }
                if (10000 <= $rdata[6]) {
                    $exp = number_format(floor($rdata[6] / 1000)) . "k";
                } else {
                    $exp = number_format($rdata[6]);
                }
                echo "<tr>";
                if (mconfig("rankings_show_place_number")) {
                    echo "<td>" . $i . "</td>";
                }
                echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                if (mconfig("rankings_afk_order1") == "TotalTime") {
                    echo "<td>";
                    if (0 < $days) {
                        echo $days . " " . lang("rankings_txt_50", true) . ", ";
                        echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    } else {
                        if (0 < $hours) {
                            echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        }
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    }
                    echo "</td>";
                } else {
                    if (mconfig("rankings_afk_order1") == "TotalDmg") {
                        echo "<td>" . $dmg . "</td>";
                    } else {
                        if (mconfig("rankings_afk_order1") == "TotalElDmg") {
                            echo "<td>" . $elemDmg . "</td>";
                        } else {
                            if (mconfig("rankings_afk_order1") == "TotalKills") {
                                echo "<td>" . $monsterKills . "</td>";
                            } else {
                                if (mconfig("rankings_afk_order1") == "TotalExp") {
                                    echo "<td>" . $exp . "</td>";
                                }
                            }
                        }
                    }
                }
                if (mconfig("rankings_afk_order2") == "TotalTime") {
                    echo "<td>";
                    if (0 < $days) {
                        echo $days . " " . lang("rankings_txt_50", true) . ", ";
                        echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    } else {
                        if (0 < $hours) {
                            echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        }
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    }
                    echo "</td>";
                } else {
                    if (mconfig("rankings_afk_order2") == "TotalDmg") {
                        echo "<td>" . $dmg . "</td>";
                    } else {
                        if (mconfig("rankings_afk_order2") == "TotalElDmg") {
                            echo "<td>" . $elemDmg . "</td>";
                        } else {
                            if (mconfig("rankings_afk_order2") == "TotalKills") {
                                echo "<td>" . $monsterKills . "</td>";
                            } else {
                                if (mconfig("rankings_afk_order2") == "TotalExp") {
                                    echo "<td>" . $exp . "</td>";
                                }
                            }
                        }
                    }
                }
                if (mconfig("rankings_afk_order3") == "TotalTime") {
                    echo "<td>";
                    if (0 < $days) {
                        echo $days . " " . lang("rankings_txt_50", true) . ", ";
                        echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    } else {
                        if (0 < $hours) {
                            echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        }
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    }
                    echo "</td>";
                } else {
                    if (mconfig("rankings_afk_order3") == "TotalDmg") {
                        echo "<td>" . $dmg . "</td>";
                    } else {
                        if (mconfig("rankings_afk_order3") == "TotalElDmg") {
                            echo "<td>" . $elemDmg . "</td>";
                        } else {
                            if (mconfig("rankings_afk_order3") == "TotalKills") {
                                echo "<td>" . $monsterKills . "</td>";
                            } else {
                                if (mconfig("rankings_afk_order3") == "TotalExp") {
                                    echo "<td>" . $exp . "</td>";
                                }
                            }
                        }
                    }
                }
                if (mconfig("rankings_afk_order4") == "TotalTime") {
                    echo "<td>";
                    if (0 < $days) {
                        echo $days . " " . lang("rankings_txt_50", true) . ", ";
                        echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    } else {
                        if (0 < $hours) {
                            echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        }
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    }
                    echo "</td>";
                } else {
                    if (mconfig("rankings_afk_order4") == "TotalDmg") {
                        echo "<td>" . $dmg . "</td>";
                    } else {
                        if (mconfig("rankings_afk_order4") == "TotalElDmg") {
                            echo "<td>" . $elemDmg . "</td>";
                        } else {
                            if (mconfig("rankings_afk_order4") == "TotalKills") {
                                echo "<td>" . $monsterKills . "</td>";
                            } else {
                                if (mconfig("rankings_afk_order4") == "TotalExp") {
                                    echo "<td>" . $exp . "</td>";
                                }
                            }
                        }
                    }
                }
                if (mconfig("rankings_afk_order5") == "TotalTime") {
                    echo "<td>";
                    if (0 < $days) {
                        echo $days . " " . lang("rankings_txt_50", true) . ", ";
                        echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    } else {
                        if (0 < $hours) {
                            echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        }
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    }
                    echo "</td>";
                } else {
                    if (mconfig("rankings_afk_order5") == "TotalDmg") {
                        echo "<td>" . $dmg . "</td>";
                    } else {
                        if (mconfig("rankings_afk_order5") == "TotalElDmg") {
                            echo "<td>" . $elemDmg . "</td>";
                        } else {
                            if (mconfig("rankings_afk_order5") == "TotalKills") {
                                echo "<td>" . $monsterKills . "</td>";
                            } else {
                                if (mconfig("rankings_afk_order5") == "TotalExp") {
                                    echo "<td>" . $exp . "</td>";
                                }
                            }
                        }
                    }
                }
                if ($config["flags"]) {
                    echo "<td><img src=\"" . __PATH_TEMPLATE__ . "images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[7] . "\" alt=\"" . $custom["countries"][$rdata[7]] . "\" title=\"" . $custom["countries"][$rdata[7]] . "\" /></td>";
                }
                echo "</tr>";
            }
            $i++;
        }
        echo "\r\n                </tbody>\r\n            </table>\r\n        </div>";
        if (mconfig("rankings_show_date")) {
            echo "<div class=\"rankings-update-time\">";
            echo lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
            echo "</div>";
        }
    } else {
        message("error", lang("error_44", true));
    }
} else {
    $menu = $Rankings->rankingsMenu(true);
    echo $menu;
    loadModuleConfigs("rankings");
    echo "\r\n  <div class=\"container_2 account\" align=\"center\">\r\n    <div class=\"cont-image\">";
    if (mconfig("active") && mconfig("rankings_enable_afk")["@attributes"]["general"]) {
        $ranking_data = LoadCacheData("rankings_afk.cache");
        echo "<div class=\"container_3 account-wide\" align=\"center\"><table class=\"general-table-ui\" cellspacing=\"0\" width=\"100%\"><tr>";
        if (mconfig("rankings_show_place_number")) {
            echo "<th style=\"font-weight:bold;\">#</th>";
        }
        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_10", true) . "</th>";
        if (mconfig("rankings_afk_order1") == "TotalTime") {
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_72", true) . "</th>";
        } else {
            if (mconfig("rankings_afk_order1") == "TotalDmg") {
                echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_73", true) . "</th>";
            } else {
                if (mconfig("rankings_afk_order1") == "TotalElDmg") {
                    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_74", true) . "</th>";
                } else {
                    if (mconfig("rankings_afk_order1") == "TotalKills") {
                        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_75", true) . "</th>";
                    } else {
                        if (mconfig("rankings_afk_order1") == "TotalExp") {
                            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_76", true) . "</th>";
                        }
                    }
                }
            }
        }
        if (mconfig("rankings_afk_order2") == "TotalTime") {
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_72", true) . "</th>";
        } else {
            if (mconfig("rankings_afk_order2") == "TotalDmg") {
                echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_73", true) . "</th>";
            } else {
                if (mconfig("rankings_afk_order2") == "TotalElDmg") {
                    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_74", true) . "</th>";
                } else {
                    if (mconfig("rankings_afk_order2") == "TotalKills") {
                        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_75", true) . "</th>";
                    } else {
                        if (mconfig("rankings_afk_order2") == "TotalExp") {
                            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_76", true) . "</th>";
                        }
                    }
                }
            }
        }
        if (mconfig("rankings_afk_order3") == "TotalTime") {
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_72", true) . "</th>";
        } else {
            if (mconfig("rankings_afk_order3") == "TotalDmg") {
                echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_73", true) . "</th>";
            } else {
                if (mconfig("rankings_afk_order3") == "TotalElDmg") {
                    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_74", true) . "</th>";
                } else {
                    if (mconfig("rankings_afk_order3") == "TotalKills") {
                        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_75", true) . "</th>";
                    } else {
                        if (mconfig("rankings_afk_order3") == "TotalExp") {
                            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_76", true) . "</th>";
                        }
                    }
                }
            }
        }
        if (mconfig("rankings_afk_order4") == "TotalTime") {
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_72", true) . "</th>";
        } else {
            if (mconfig("rankings_afk_order4") == "TotalDmg") {
                echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_73", true) . "</th>";
            } else {
                if (mconfig("rankings_afk_order4") == "TotalElDmg") {
                    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_74", true) . "</th>";
                } else {
                    if (mconfig("rankings_afk_order4") == "TotalKills") {
                        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_75", true) . "</th>";
                    } else {
                        if (mconfig("rankings_afk_order4") == "TotalExp") {
                            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_76", true) . "</th>";
                        }
                    }
                }
            }
        }
        if (mconfig("rankings_afk_order5") == "TotalTime") {
            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_72", true) . "</th>";
        } else {
            if (mconfig("rankings_afk_order5") == "TotalDmg") {
                echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_73", true) . "</th>";
            } else {
                if (mconfig("rankings_afk_order5") == "TotalElDmg") {
                    echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_74", true) . "</th>";
                } else {
                    if (mconfig("rankings_afk_order5") == "TotalKills") {
                        echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_75", true) . "</th>";
                    } else {
                        if (mconfig("rankings_afk_order5") == "TotalExp") {
                            echo "<th style=\"font-weight:bold;\">" . lang("rankings_txt_76", true) . "</th>";
                        }
                    }
                }
            }
        }
        if ($config["flags"]) {
            echo "<th style=\"font-weight:bold;\">" . lang("global_module_11", true) . "</th>";
        }
        echo "</tr>";
        $i = 0;
        foreach ($ranking_data as $rdata) {
            if (1 <= $i) {
                $rdata[2] = floor($rdata[2] / 60);
                $days = floor($rdata[2] / 1440);
                $rdata[2] = $rdata[2] % 1440;
                $hours = floor($rdata[2] / 60);
                $rdata[2] = $rdata[2] % 60;
                $minutes = $rdata[2];
                if (10000 <= $rdata[3]) {
                    $dmg = number_format(floor($rdata[3] / 1000)) . "k";
                } else {
                    $dmg = number_format($rdata[3]);
                }
                if (10000 <= $rdata[4]) {
                    $elemDmg = number_format(floor($rdata[4] / 1000)) . "k";
                } else {
                    $elemDmg = number_format($rdata[4]);
                }
                if (10000 <= $rdata[5]) {
                    $monsterKills = number_format(floor($rdata[5] / 1000)) . "k";
                } else {
                    $monsterKills = number_format($rdata[5]);
                }
                if (10000 <= $rdata[6]) {
                    $exp = number_format(floor($rdata[6] / 1000)) . "k";
                } else {
                    $exp = number_format($rdata[6]);
                }
                echo "<tr>";
                if (mconfig("rankings_show_place_number")) {
                    echo "<td>" . $i . "</td>";
                }
                echo "<td><a href=\"" . __BASE_URL__ . "profile/player/req/" . hex_encode($rdata[0]) . "/\">" . $common->replaceHtmlSymbols($rdata[0]) . "</a></td>";
                if (mconfig("rankings_afk_order1") == "TotalTime") {
                    echo "<td>";
                    if (0 < $days) {
                        echo $days . " " . lang("rankings_txt_50", true) . ", ";
                        echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    } else {
                        if (0 < $hours) {
                            echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        }
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    }
                    echo "</td>";
                } else {
                    if (mconfig("rankings_afk_order1") == "TotalDmg") {
                        echo "<td>" . $dmg . "</td>";
                    } else {
                        if (mconfig("rankings_afk_order1") == "TotalElDmg") {
                            echo "<td>" . $elemDmg . "</td>";
                        } else {
                            if (mconfig("rankings_afk_order1") == "TotalKills") {
                                echo "<td>" . $monsterKills . "</td>";
                            } else {
                                if (mconfig("rankings_afk_order1") == "TotalExp") {
                                    echo "<td>" . $exp . "</td>";
                                }
                            }
                        }
                    }
                }
                if (mconfig("rankings_afk_order2") == "TotalTime") {
                    echo "<td>";
                    if (0 < $days) {
                        echo $days . " " . lang("rankings_txt_50", true) . ", ";
                        echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    } else {
                        if (0 < $hours) {
                            echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        }
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    }
                    echo "</td>";
                } else {
                    if (mconfig("rankings_afk_order2") == "TotalDmg") {
                        echo "<td>" . $dmg . "</td>";
                    } else {
                        if (mconfig("rankings_afk_order2") == "TotalElDmg") {
                            echo "<td>" . $elemDmg . "</td>";
                        } else {
                            if (mconfig("rankings_afk_order2") == "TotalKills") {
                                echo "<td>" . $monsterKills . "</td>";
                            } else {
                                if (mconfig("rankings_afk_order2") == "TotalExp") {
                                    echo "<td>" . $exp . "</td>";
                                }
                            }
                        }
                    }
                }
                if (mconfig("rankings_afk_order3") == "TotalTime") {
                    echo "<td>";
                    if (0 < $days) {
                        echo $days . " " . lang("rankings_txt_50", true) . ", ";
                        echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    } else {
                        if (0 < $hours) {
                            echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        }
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    }
                    echo "</td>";
                } else {
                    if (mconfig("rankings_afk_order3") == "TotalDmg") {
                        echo "<td>" . $dmg . "</td>";
                    } else {
                        if (mconfig("rankings_afk_order3") == "TotalElDmg") {
                            echo "<td>" . $elemDmg . "</td>";
                        } else {
                            if (mconfig("rankings_afk_order3") == "TotalKills") {
                                echo "<td>" . $monsterKills . "</td>";
                            } else {
                                if (mconfig("rankings_afk_order3") == "TotalExp") {
                                    echo "<td>" . $exp . "</td>";
                                }
                            }
                        }
                    }
                }
                if (mconfig("rankings_afk_order4") == "TotalTime") {
                    echo "<td>";
                    if (0 < $days) {
                        echo $days . " " . lang("rankings_txt_50", true) . ", ";
                        echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    } else {
                        if (0 < $hours) {
                            echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        }
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    }
                    echo "</td>";
                } else {
                    if (mconfig("rankings_afk_order4") == "TotalDmg") {
                        echo "<td>" . $dmg . "</td>";
                    } else {
                        if (mconfig("rankings_afk_order4") == "TotalElDmg") {
                            echo "<td>" . $elemDmg . "</td>";
                        } else {
                            if (mconfig("rankings_afk_order4") == "TotalKills") {
                                echo "<td>" . $monsterKills . "</td>";
                            } else {
                                if (mconfig("rankings_afk_order4") == "TotalExp") {
                                    echo "<td>" . $exp . "</td>";
                                }
                            }
                        }
                    }
                }
                if (mconfig("rankings_afk_order5") == "TotalTime") {
                    echo "<td>";
                    if (0 < $days) {
                        echo $days . " " . lang("rankings_txt_50", true) . ", ";
                        echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    } else {
                        if (0 < $hours) {
                            echo $hours . " " . lang("rankings_txt_51", true) . ", ";
                        }
                        echo $minutes . " " . lang("rankings_txt_52", true) . "";
                    }
                    echo "</td>";
                } else {
                    if (mconfig("rankings_afk_order5") == "TotalDmg") {
                        echo "<td>" . $dmg . "</td>";
                    } else {
                        if (mconfig("rankings_afk_order5") == "TotalElDmg") {
                            echo "<td>" . $elemDmg . "</td>";
                        } else {
                            if (mconfig("rankings_afk_order5") == "TotalKills") {
                                echo "<td>" . $monsterKills . "</td>";
                            } else {
                                if (mconfig("rankings_afk_order5") == "TotalExp") {
                                    echo "<td>" . $exp . "</td>";
                                }
                            }
                        }
                    }
                }
                if ($config["flags"]) {
                    echo "<td><img src=\"" . __PATH_TEMPLATE__ . "style/images/blank.png\" class=\"flag-icon flag-icon-" . $rdata[7] . "\" alt=\"" . $custom["countries"][$rdata[7]] . "\" title=\"" . $custom["countries"][$rdata[7]] . "\" /></td>";
                }
                echo "</tr>";
            }
            $i++;
        }
        echo "</table>";
        if (mconfig("rankings_show_date")) {
            echo "<div class=\"rankings-update-time\">";
            echo "" . lang("rankings_txt_20", true) . " " . date($config["time_date_format"], $ranking_data[0][0]);
            echo "</div>";
        }
        echo "</div>";
    } else {
        message("error", lang("error_44", true));
    }
    echo "\r\n  </div>\r\n</div>";
}

?>