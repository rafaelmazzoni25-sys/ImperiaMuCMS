<div class="sidebar">

    <script type="text/javascript" SRC="<?= __PATH_TEMPLATE__ ?>js/tooltip.js"></script>
    <!-- Banners -->
    <div class="banners">
        <a href="<?= $config['website_forum_link'] ?>" id="support"><p></p></a>
        <a href="<?= __BASE_URL__ ?>downloads" id="launcher_dw"><p></p></a>
    </div>
    <!-- Banners . End -->
    <div class="index-status-container home_container">
        <div id="serverstatus"></div>
        <script type="text/javascript">
            function loadServerStatus() {
                $('#serverstatus').load('templates/default/ajax/server_status.php');
            }
            loadServerStatus();
            setInterval(loadServerStatus, 300000);
        </script>
        <div class="ts-status">
            <h3>TEAMSPEAK is <p class="status" id="teeamspeak-status"><font color="#313F09">Online</font></p>
            </h3>
            <a href="http://www.teamspeak.com/?page=downloads" target="_blank" id="download-ts">Download TS3 Client</a>
            <a href="<?= __BASE_URL__ ?>" id="download-htc">How to Connect</a>
        </div>
        <div class="logon-status">
            <div id="logon-status">
                <h3>Server Status: <br/>
                    <p class="status" id="logon-status2"></p>
                    <script type="text/javascript">
                        function loadServerOnline() {
                            $('#logon-status2').load('templates/default/ajax/server_online.php');
                        }
                        loadServerOnline();
                        setInterval(loadServerOnline, 300000);
                    </script>
                </h3>
            </div>
            <div id="server-time">
                <span class="server_time" id="servertime"></span>
            </div>
        </div>
    </div>
    <div class="spotlight home_container">
        <div class="cycle-slideshow" data-cycle-fx="fade" data-cycle-timeout=10000 data-cycle-pager=".example-pager" data-cycle-slides="> div">
            <div align="center">
                <p>
                <div class="sub_header">
                    <h1><?php echo lang('template_txt_30', true); ?></h1>

                    <div class="title_overlay"></div>
                </div>
                <div class="blueberry">
                    <ul class="hof">
                        <li>
                            <p></p>
                            <a href=""><?php echo lang('template_txt_31', true); ?></a>
                            <span>Season 9 EP2</span>
                        </li>
                        <li>
                            <p></p>
                            <a href=""><?php echo lang('template_txt_32', true); ?></a>
                            <span>10x</span>
                        </li>
                        <li>
                            <p></p>
                            <a href=""><?php echo lang('template_txt_33', true); ?></a>
                            <span>40%</span>
                        </li>
                        <li>
                            <p></p>
                            <a href=""><?php echo lang('template_txt_34', true); ?></a>
                            <span>PvP</span>
                        </li>
                        <li>
                            <p></p>
                            <a href=""><?php echo lang('template_txt_35', true); ?></a>
                            <span>5</span>
                        </li>
                    </ul>
                </div>
                </p>
            </div>
            <div>
                <div class="sub_header">
                    <h1><?php echo lang('template_txt_36', true); ?></h1>
                    <div class="title_overlay"></div>
                </div>
                <div class="blueberry">
                    <?php
                    $ranking_data = LoadCacheData('rankings_characters.cache');

                    echo '<table class="top5table" cellspacing="0" width="100%">';

                    $i = 0;
                    foreach ($ranking_data as $rdata) {
                        if ($i > 5) break;
                        if ($rdata[3] == NULL) $rdata[3] = 0;
                        if ($i >= 1) {
                            echo '<tr>';
                            echo '<td class="pos" width="20px">' . $i . '</td>';
                            echo '<td width="120px"><a href="' . __BASE_URL__ . 'profile/player/req/' . hex_encode($rdata[0]) . '/">' . $common->replaceHtmlSymbols($rdata[0]) . '</a></td>';
                            echo '<td width="45px">' . $custom['character_class'][$rdata[1]][1] . '</td>';

                            if (!$config["use_grand_resets"] && !$config["use_resets"]) {
                                echo '<td class="inf" width="80px">' . $rdata[2] . ' [' . $rdata[3] . ']</td>';
                            } else {
                                if (!$config["use_grand_resets"]) {
                                    echo '<td class="inf" width="80px">' . $rdata[2] . ' [' . $rdata[4] . ']</td>';
                                } elseif (!$config["use_resets"]) {
                                    echo '<td class="inf" width="80px">' . $rdata[2] . ' [' . $rdata[5] . ']</td>';
                                } else {
                                    echo '<td class="inf" width="80px">' . $rdata[4] . ' [' . $rdata[5] . ']</td>';
                                }
                            }

                            if ($config["flags"])
                                echo '<td width="20px"><img src="' . __PATH_TEMPLATE__ . 'style/images/blank.png" class="country flag-icon flag-icon-' . $rdata[6] . '" alt="' . $custom['countries'][$rdata[6]] . '" /></td>';

                            echo '</tr>';
                        }
                        $i++;
                    }
                    echo '</table>';
                    ?>
                </div>
            </div>
            <div>
                <div class="sub_header">
                    <h1><?php echo lang('template_txt_37', true); ?></h1>
                    <div class="title_overlay"></div>
                </div>
                <div class="blueberry">
                    <?php
                    $ranking_data = LoadCacheData('rankings_guilds.cache');
                    $rankingsCfg = loadConfigurations('rankings');

                    echo '<table class="top5table" cellspacing="0" width="100%">';

                    $i = 0;
                    foreach ($ranking_data as $rdata) {
                        if ($i > 5) break;
                        if ($rdata[3] == NULL) $rdata[3] = 0;
                        if ($i >= 1) {
                            echo '<tr>';
                            echo '<td class="pos" width="20px">' . $i . '</td>';
                            echo '<td width="180px"><a href="' . __BASE_URL__ . 'profile/guild/req/' . hex_encode($rdata[0]) . '/">' . $common->replaceHtmlSymbols($rdata[0]) . '</a></td>';

                            if ($rankingsCfg['rankings_guild_type']) {
                                if ($config["use_grand_resets"]) {
                                    echo '<td width="60px">' . number_format($rdata[5]) . '</td>';
                                } else if ($config["use_resets"]) {
                                    echo '<td width="60px">' . number_format($rdata[4]) . '</td>';
                                } else {
                                    echo '<td width="60px">' . number_format($rdata[2] + $rdata[3]) . '</td>';
                                }
                            } else {
                                echo '<td width="60px">' . number_format($rdata[8]) . '</td>';
                            }
                            echo '<td width="40px">' . returnGuildLogo($rdata[6], 26) . '</td>';
                            echo '</tr>';
                        }
                        $i++;
                    }
                    echo '</table>';
                    ?>
                </div>
            </div>
        </div>
        <div class="pager">
            <div class="example-pager"></div>
        </div>
    </div>

    <?php

    $Auction = new Auction();
    $Market = new Market();
    $Items = new Items();
    $auctions = $Auction->getLatestAuctions();
    if (is_array($auctions)) {
        echo '<script type="text/javascript" SRC="' . __PATH_TEMPLATE__ . 'js/tooltip.js"></script>';
        echo '
    <div class="spotlight home_container">
        <div class="cycle-slideshow" data-cycle-fx="fade" data-cycle-timeout=10000 data-cycle-pager=".example-pager2" data-cycle-slides="> div">';
        foreach ($auctions as $thisAuction) {
            echo '<div align="center">';
            $currentBid = $Auction->getCurrentBid($thisAuction['id']);
            $totalBids = $Auction->getTotalBids($thisAuction['id']);
            $currency = $Auction->getCurrencyName($thisAuction['currency']);
            $items = $Auction->getItems($thisAuction['id']);
            if (is_array($items)) {
                $itemsTxt = '';
                $totalWidth = 0;
                $moreItems = 0;
                foreach ($items as $thisItem) {
                    $itemInfo = $Items->ItemInfo($thisItem['item']);

                    $luck = '';
                    $skill = '';
                    $option = '';
                    $exl = '';
                    $ancsetopt = '';

                    if ($itemInfo['level']) {
                        $itemInfo['level'] = " +" . $itemInfo['level'];
                    } else {
                        $itemInfo['level'] = NULL;
                    }

                    if (@$itemInfo['luck'])
                        $luck = '<br><font color=#9aadd5>' . $itemInfo['luck'] . '</font>';
                    if (@$itemInfo['skill'])
                        $skill = '<br><font color=#9aadd5>' . $itemInfo['skill'] . '</font>';

                    if (@$itemInfo['opt'])
                        $option = '<font color=#9aadd5>' . $itemInfo['opt'] . '</font>';

                    if (@$itemInfo['exl'])
                        $exl = '<font color=#4d668d>' . str_replace('^^', '<br>', $itemInfo['exl']) . '</font>';

                    if (@$itemInfo['ancsetopt'])
                        $ancsetopt = '<font color=#9aadd5>' . str_replace('^^', '<br>', $itemInfo['ancsetopt']) . '</font>';

                    $width = ($itemInfo['X'] * 32) / 1.5;
                    $height = ($itemInfo['Y'] * 32) / 1.5;

                    $totalWidth += $itemInfo['X'];

                    $width2 = $width + 20;
                    $padding = (85 - $height) / 2;

                    if ($totalWidth <= 6) {
                        $itemsTxt .= '
                    <div style="width: ' . $width2 . 'px; height: 95px; vertical-align: middle; cursor: pointer; display: inline-block; margin: 1px; background-color: #251a15; border: 1px solid #412c28; box-shadow: inset 0 0 8px #000000; padding: 8px;" onmouseover="Tip(\'<center><img src=' . $itemInfo['thumb'] . '><br /><font color=white><br>Durability: ' . $itemInfo['dur'] . '</font><br><font color=#FF99CC>' . $itemInfo['jog'] . '</font><font color=FFCC00>' . $itemInfo['harm'] . '</font><br>' . $option . ' ' . $luck . ' ' . $skill . ' ' . $exl . ' <br>' . $ancsetopt . '<br><font color=#4d668d>' . $itemInfo['socket'] . '</font><br><br><span class=itemTooltipClassReq>' . $itemInfo['classReq'] . '</span></center>\', TITLEFONTCOLOR, \'' . $itemInfo['color'] . '\',TITLE,\'' . addslashes($itemInfo['name']) . $itemInfo['level'] . '\',TITLEBGCOLOR,\'' . $itemInfo['anco'] . '\')" onmouseout="UnTip()">
                        <img src="' . $itemInfo['thumb'] . '" width="' . $width . 'px" height="' . $height . 'px" style="top: ' . $padding . 'px">
                    </div>';
                    } else {
                        $moreItems++;
                    }
                }
            }

            echo '
                <p>
                <div class="sub_header">
                    <h1>' . lang('auction_txt_28', true) . '</h1>
                    <h2><a href="' . __BASE_URL__ . 'usercp/auction/">! ' . lang('auction_txt_29', true) . '</a></h2>
                    <div class="title_overlay"></div>
                </div>
                <div class="blueberry" style="height: 180px;">
                    <div style="padding: 10px">
                    <h3 style="padding-bottom: 6px;">' . $thisAuction['name'] . '</h3>
                    ' . $itemsTxt;

            if ($moreItems > 0) {
                echo '<div style="padding-top: 10px;">' . sprintf(lang('auction_txt_30', true), $moreItems) . '</div>';
            }

            echo '
                    <div style="padding-top: 10px;">' . lang('auction_txt_5', true) . ': <b>' . number_format($currentBid) . ' ' . $currency . '</b> (' . sprintf(lang('auction_txt_6', true), $totalBids) . ')</div>
                    </div>
                </div>
                </p>
            </div>';
        }
        echo '
        </div>
        <div class="pager">
            <div class="example-pager2"></div>
        </div>
    </div>';
    }

    $latestItems = $Market->getLatestMarketItems();
    if (is_array($latestItems)) {
        ?>
        <div class="spotlight home_container">
            <div class="sub_header">
                <h1><?php echo lang('template_txt_43', true); ?></h1>
                <h2><a href="<?php echo __BASE_URL__; ?>usercp/market/"><?php echo lang('template_txt_45', true); ?></a></h2>
                <div class="title_overlay"></div>
            </div>
            <div class="blueberry">
                <?php
                echo '<table style="width: 100%; padding: 10px 15px 10px 15px">';
                foreach ($latestItems as $item) {
                    $itemInfo = $Items->ItemInfo($item['item']);
                    $price = $Market->showStyledPrice($item['price_type'], $item['price']);

                    $luck = '';
                    $skill = '';
                    $option = '';
                    $exl = '';
                    $ancsetopt = '';

                    if ($itemInfo['level']) {
                        $itemInfo['level'] = " +" . $itemInfo['level'];
                    } else {
                        $itemInfo['level'] = NULL;
                    }

                    if (@$itemInfo['luck'])
                        $luck = '<br><font color=#9aadd5>' . $itemInfo['luck'] . '</font>';
                    if (@$itemInfo['skill'])
                        $skill = '<br><font color=#9aadd5>' . $itemInfo['skill'] . '</font>';

                    if (@$itemInfo['opt'])
                        $option = '<font color=#9aadd5>' . $itemInfo['opt'] . '</font>';

                    if (@$itemInfo['exl'])
                        $exl = '<font color=#4d668d>' . str_replace('^^', '<br>', $itemInfo['exl']) . '</font>';

                    if (@$itemInfo['ancsetopt'])
                        $ancsetopt = '<font color=#9aadd5>' . str_replace('^^', '<br>', $itemInfo['ancsetopt']) . '</font>';

                    $exl = str_replace("'", "\'", $exl);

                    echo '<tr>';
                    echo '<td rowspan="2"><img id="icon" src="' . $itemInfo['thumb'] . '" style="width: 40px; height: 40px; box-shadow: inset 0 0 6px #000, 0 0 3px rgba(208, 179, 133, .35);"></td>';
                    echo '<td style="cursor: pointer; text-align: left;" onmouseover="Tip(\'<center><img src=' . $itemInfo['thumb'] . '><br /><font color=yellow><br>' . lang('market_txt_100', true) . ' ' . $itemInfo['sn2'] . $itemInfo['sn'] . '</font><br><font color=white><br>' . lang('market_txt_101', true) . ' ' . $itemInfo['dur'] . '</font><br><font color=#FF99CC>' . $itemInfo['jog'] . '</font><font color=FFCC00>' . $itemInfo['harm'] . '</font><br>' . $option . ' ' . $luck . ' ' . $skill . ' ' . $exl . ' <br>' . $ancsetopt . '<br><font color=#4d668d>' . $itemInfo['socket'] . '</font><br><br><span class=itemTooltipClassReq>' . $itemInfo['classReq'] . '</span></center>\', TITLEFONTCOLOR, \'' . $itemInfo['color'] . '\',TITLE,\'' . $itemInfo['name'] . $itemInfo['level'] . '\',TITLEBGCOLOR,\'' . $itemInfo['anco'] . '\')" onmouseout="UnTip()" <img src="' . $itemInfo['thumb'] . '" class="m"><font style="color:' . $itemInfo['color'] . ';background-color:' . $itemInfo['anco'] . '">' . $itemInfo['name'] . '</font></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td style="cursor: pointer; text-align: left;">' . $price . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                ?>
            </div>
        </div>
    <?php }

    $bossTimerCfg = loadConfigurations('bosstimer');
    if ($bossTimerCfg['active']) {

        ?>

        <script type="text/javascript">

            function getBossData() {
                $.getJSON('<?php echo __BASE_URL__; ?>ajax/boss_timer.php', function (data) {
                    var newTimers = '';
                    var showKiller = '<?php echo $bossTimerCfg['show_killer']; ?>';
                    var showDate = '<?php echo $bossTimerCfg['show_date']; ?>';

                    $.each(data, function (i, item) {
                        if (data[i] != null && data[i] != '') {
                            var timeLeftFormatted = '';
                            var nextTime = '';
                            var totalSecondsLeft = data[i].timeLeft;
                            var hours = Math.floor(data[i].timeLeft / 3600);
                            data[i].timeLeft = data[i].timeLeft % 3600;
                            var minutes = Math.floor(data[i].timeLeft / 60);
                            var seconds = data[i].timeLeft % 60;

                            if (hours.toString().length == 1) hours = '0' + hours;
                            if (minutes.toString().length == 1) minutes = '0' + minutes;
                            if (seconds.toString().length == 1) seconds = '0' + seconds;

                            <?php
                            if ($bossTimerCfg['display_seconds']) {
                                echo 'timeLeftFormatted = hours + \':\' + minutes + \':\' + seconds;';
                            } else {
                                echo 'timeLeftFormatted = hours + \':\' + minutes;';
                            }
                            ?>
                            if (totalSecondsLeft > 86400) {
                                nextTime = data[i].nextTime + ', ' + data[i].nextDate;
                            }

                            if (data[i].nextTime == null) {
                                nextTime = '<?php echo lang('template_txt_54', true); ?>';
                            }

							if (totalSecondsLeft <= 0) {
                                nextTime = '<?php echo lang('template_txt_54', true); ?>';
								data[i].nextTime = null;
                            }

                            var lastKilledBy = '<?php echo lang('template_txt_56', true); ?>';
                            if (data[i].lastKiller != null && data[i].lastKilled != null) {
                                lastKilledBy = data[i].lastKiller + ', ' + data[i].lastKilled;
                            } else if (data[i].lastKiller != null && data[i].lastKilled == null) {
                                lastKilledBy = data[i].lastKiller;
                            } else if (data[i].lastKiller == null && data[i].lastKilled != null) {
                                lastKilledBy = data[i].lastKilled;
                            }

                            var boxHeight = '42px';

                            if (data[i].nextTime != null && (showKiller == "1" || showDate == "1")) {
                                boxHeight = '60px';
                            } else if (data[i].nextTime == null && (showKiller == "0" && showDate == "0")) {
                                boxHeight = '24px';
                            }

                            newTimers +=
                                '<dt class="boss" style="height: ' + boxHeight + '">' +
                                    '<b class="rightfloat">' + nextTime + '</b>' +
                                    '<b>' + data[i].name + '</b>';

                            if (data[i].nextTime != null) {
                                newTimers +=
                                    '<span>' +
                                        '<div class="rightfloat">' + timeLeftFormatted + '</div><?php echo lang('template_txt_57', true);?>' +
                                    '</span>';
                            }

                            if (showKiller == "1" || showDate == "1") {
                                newTimers +=
                                    '<span>' +
                                        '<div class="rightfloat">' + lastKilledBy + '</div><?php echo lang('template_txt_55', true);?>' +
                                    '</span>';
                            }

                            newTimers += '</dt>';
                        }
                    });

                    if (newTimers != '') {
                        $('#bossTimer').html(newTimers);
                    }
                });
            }

            function initBossTimer() {
                setTimeout(function () {
                    getBossData();
                    initBossTimer();
                }, <?php if ($bossTimerCfg['display_seconds']) { echo '1000'; } else { echo '60000'; } ?>);
            }

            getBossData();
            initBossTimer();
        </script>

        <?php

        echo '
    <div class="spotlight home_container">
        <div class="sub_header">
            <h1>' . lang('template_txt_53', true) . '</h1>
            <div class="title_overlay"></div>
        </div>
        <div class="blueberry">
            <dl id="bossTimer"></dl>            
        </div>
    </div>';
    }

    $eventsTimerCfg = loadConfigurations('eventstimer');
    if ($eventsTimerCfg['active']) {
        ?>

        <script type="text/javascript">

            function getEventsData() {
                $.getJSON('<?php echo __BASE_URL__; ?>ajax/events_timer.php', function (data) {
                    var newTimers = '';

                    $.each(data, function (i, item) {
                        if (data[i] != null && data[i] != '') {
                            var timeLeftFormatted = '';
                            var hours = Math.floor(data[i].timeLeft / 3600);
                            data[i].timeLeft = data[i].timeLeft % 3600;
                            var minutes = Math.floor(data[i].timeLeft / 60);
                            var seconds = data[i].timeLeft % 60;

                            if (hours.toString().length == 1) hours = '0' + hours;
                            if (minutes.toString().length == 1) minutes = '0' + minutes;
                            if (seconds.toString().length == 1) seconds = '0' + seconds;

                            var activeEvent = '';
                            if (data[i].isActive) {
                                activeEvent = ' eventActive';
                            }

                            <?php
                            if ($eventsTimerCfg['display_seconds']) {
                                echo 'timeLeftFormatted = hours + \':\' + minutes + \':\' + seconds;';
                            } else {
                                echo 'timeLeftFormatted = hours + \':\' + minutes;';
                            }
                            ?>

                            newTimers += '<dt class="event' + activeEvent + '"><b class="rightfloat">' + data[i].nextTime + '</b><b>' + data[i].name + '</b><span><div class="rightfloat">' + timeLeftFormatted + '</div>' + data[i].text + '</span></dt>';
                        }
                    });

                    if (newTimers != '') {
                        $('#events').html(newTimers);
                    }
                });
            }

            function initEventsTimer() {
                setTimeout(function () {
                    getEventsData();
                    initEventsTimer();
                }, <?php if ($eventsTimerCfg['display_seconds']) { echo '1000'; } else { echo '60000'; } ?>);
            }

            getEventsData();
            initEventsTimer();
        </script>

        <?php

        echo '
    <div class="spotlight home_container">
        <div class="sub_header">
            <h1>' . lang('template_txt_38', true) . '</h1>
            <div class="title_overlay"></div>
        </div>
        <div class="blueberry">
            <dl id="events"></dl>            
        </div>
    </div>';
    }

    /*loadModuleConfigs('eventstimer');
    if (mconfig('active')) {
        echo '
        <div class="spotlight home_container">
            <div class="sub_header">
                <h1>' . lang('template_txt_38', true) . '</h1>
                <div class="title_overlay"></div>
            </div>
            <div class="blueberry">
                <dl id="events">';

        $now = time();
        $currentHour = date('H', $now);
        $currentMinute = date('i', $now);
        $currentSecond = date('s', $now);
        $hoursLeft = 0;
        $minutesLeft = 0;
        $secondsLeft = 0;

        $events = $dB->query_fetch("SELECT * FROM [dbo].[IMPERIAMUCMS_EVENTS_TIMER] WHERE [active] = ? ORDER BY [order] ASC", array(1));
        if (is_array($events)) {
            foreach ($events as $thisEvent) {
                $eventTime = '';
                // find current event time
                // 1:00, 5:00, 9:00, 13:00, 17:00, 21:00
                $times = explode(",", $thisEvent['times']);
                foreach ($times as $thisTime) {
                    $time = explode(':', $thisTime);
                    // $time[0] = hour
                    // $time[1] = minute
                    if ($time[0] > $currentHour) {
                        $eventTime = $thisTime;

                        $hoursLeft = $time[0] - $currentHour;
                        $minutesLeft = $time[1] - $currentMinute;
                        $secondsLeft = 60 - $currentSecond;

                        break;
                    } else if ($time[0] == $currentHour) {
                        if ($time[1] > $currentMinute) {
                            $eventTime = $thisTime;

                            $hoursLeft = $time[0] - $currentHour;
                            $minutesLeft = $time[1] - $currentMinute;
                            $secondsLeft = 60 - $currentSecond;

                            break;
                        }
                    }
                }
                if ($eventTime == '') {
                    $eventTime = $times[0];

                    $hoursLeft = 24 + $time[0] - $currentHour;
                    $minutesLeft = $time[1] - $currentMinute;
                    $secondsLeft = 60 - $currentSecond;
                }

                if ($minutesLeft < 0) {
                    $hoursLeft--;
                    $minutesLeft += 60;
                }

                if ($secondsLeft == 60) {
                    $minutesLeft++;
                    $secondsLeft -= 60;
                }

                if ($minutesLeft == 60) {
                    $hoursLeft++;
                    $minutesLeft -= 60;
                }

                if (strlen($hoursLeft) < 2) {
                    $hoursLeft = '0' . $hoursLeft;
                }
                if (strlen($minutesLeft) < 2) {
                    $minutesLeft = '0' . $minutesLeft;
                }
                if (strlen($secondsLeft) < 2) {
                    $secondsLeft = '0' . $secondsLeft;
                }

                if ($thisEvent['type'] == "0") {
                    // opening
                    $eventText1 = lang('template_txt_39', true);
                    $eventText2 = lang('template_txt_40', true);
                } else {
                    // starting
                    $eventText1 = lang('template_txt_41', true);
                    $eventText2 = lang('template_txt_42', true);
                }

                if ($minutesLeft < 5) {
                    $countdownText = $eventText2;
                } else if ($minutesLeft == 5 && $secondsLeft <= 0) {
                    $countdownText = $eventText2;
                } else {
                    $countdownText = $eventText1;
                }

                $countdown = $hoursLeft . ':' . $minutesLeft . ':' . $secondsLeft;

                echo '<dt class="event"><b class="rightfloat">' . $eventTime . '</b><b>' . $thisEvent['name'] . '</b><span><div class="rightfloat">' . $countdown . '</div>' . $countdownText . '</span></dt>';
            }
        }

        echo '        
                </dl>
            </div>
        </div>';
    }*/

    // Old Events Timer system, if you want to use it, just remove comment "/*" and "*/"
    /*echo '
    <div class="spotlight home_container">
        <div class="sub_header">
            <h1>' . lang('template_txt_38', true) . '</h1>
            <div class="title_overlay"></div>
        </div>
        <div class="blueberry">
            <dl id="events"></dl>
            <script type="text/javascript" src="' . __BASE_URL__ . 'templates/' . $config["website_template"] . '/js/time.js?v=3"></script>
            <script type="text/javascript">
                var serverTime = ' . time() . ';
                var serverOffset = ' . date('Z') . ';
                MuEvents.start(serverTime, serverOffset);
            </script>
        </div>
    </div>';*/

    loadModuleConfigs('ipboardapi');
    $enable_ipb = mconfig('active');
    if ($enable_ipb) {
        ?>

        <div class="spotlight home_container" style="min-height: 285px;">
            <div class="cycle-slideshow" data-cycle-fx="fade" data-cycle-timeout=10000 data-cycle-pager=".ipb-pager" data-cycle-slides="> div" style="min-height: 285px;">
                <div>
                    <div class="sub_header">
                        <h1><?php echo lang('template_txt_46', true); ?></h1>
                        <div class="title_overlay"></div>
                    </div>
                    <div class="blueberry">
                        <?php
                        $latestTopics = $common->IPB_getLatestTopics(5, '?sortBy=date&sortDir=desc&hidden=0');
                        if (is_array($latestTopics)) {
                            echo '<table class="ipb-table" cellspacing="0">';

                            foreach ($latestTopics as $thisTopic) {
                                $title = $thisTopic['title'];
                                if (strlen($title) > 35) {
                                    $title = substr($thisTopic['title'], 0, 35) . '...';
                                }

                                echo '<tr>';
                                echo '<td>';
                                echo '<table width="100%">';
                                echo '<tr>';
                                echo '<td colspan="2" class="title"><a href="' . $thisTopic['url'] . '" target="_blank" title="' . $thisTopic['title'] . '">' . $title . '</a></td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td width="180px">' . sprintf(lang('template_txt_48', true), '<a href="' . $thisTopic['firstPost']['author']['profileUrl'] . '" target="_blank">' . $thisTopic['firstPost']['author']['formattedName'] . '</a>') . '</td>';
                                echo '<td width="97px" align="right">' . date($config["time_date_format"], strtotime($thisTopic['firstPost']['date'])) . '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td width="180px">' . sprintf(lang('template_txt_49', true), '<a href="' . $thisTopic['lastPost']['author']['profileUrl'] . '" target="_blank">' . $thisTopic['lastPost']['author']['formattedName'] . '</a>') . '</td>';
                                echo '<td width="97px" align="right">' . date($config["time_date_format"], strtotime($thisTopic['lastPost']['date'])) . '</td>';
                                echo '</tr>';
                                echo '</table>';
                                echo '</td>';
                                echo '</tr>';
                            }

                            echo '</table>';
                        } else {
                            message('error', lang('template_txt_50', true));
                        }
                        ?>
                    </div>
                </div>
                <!--<div>
                <div class="sub_header">
                    <h1><?php echo lang('template_txt_47', true); ?></h1>
                    <div class="title_overlay"></div>
                </div>
                <div class="blueberry">
                    <?php
                $latestPosts = $common->IPB_getLatestPosts(5, '?sortBy=date&sortDir=desc&hidden=0');
                if (is_array($latestPosts)) {
                    echo '<table class="ipb-table" cellspacing="0">';

                    foreach ($latestPosts as $thisPost) {
                        $content = trim(preg_replace('/^[ \t]*[\r\n]+/m', '', strip_tags(str_replace("&nbsp;", "", $thisPost['content']))));
                        if (strlen($content) > 100) {
                            $content = substr($thisPost['content'], 0, 100) . '...';
                        }

                        echo '<tr>';
                        echo '<td>';
                        echo '<table width="100%">';
                        echo '<tr>';
                        echo '<td width="180px">' . sprintf(lang('template_txt_52', true), '<a href="' . $thisPost['author']['profileUrl'] . '" target="_blank">' . $thisPost['author']['formattedName'] . '</a>') . '</td>';
                        echo '<td width="97px" align="right">' . date($config["time_date_format"], strtotime($thisPost['date'])) . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td colspan="2"><a href="' . $thisPost['url'] . '" target="_blank" title="' . strip_tags($thisPost['content']) . '">' . $content . '</a></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    message('error', lang('template_txt_51', true));
                }
                ?>
                </div>
            </div>-->
            </div>
            <!--<div class="pager">
                <div class="ipb-pager"></div>
            </div>-->
        </div>
        <?php
    }
    ?>

</div>