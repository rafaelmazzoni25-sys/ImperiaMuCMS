<?php

$castleData = LoadCacheData('castle_siege.cache');
$cwData = $dB->query_fetch_single("SELECT TOP 1 * FROM MuCrywolf_DATA WHERE MAP_SVR_GROUP = '1'");

if ($cwData['CRYWOLF_STATE'] == '0')
    $cwStatus = 'Unprotected';
else
    $cwStatus = 'Protected';

$castleSiege = $dB->query_fetch_single("SELECT TOP 1 * FROM MuCastle_DATA");
$siegeStart = $castleSiege['SIEGE_START_DATE'];

loadModuleConfigs('castlesiege');

$now = time();

$csstartTime = explode(":", mconfig('cs_period_start_time'));
$siegeStartCSStart = strtotime($siegeStart) + (mconfig('cs_period_start_day') * 86400) + ($csstartTime[0] * 3600) + ($csstartTime[1] * 60);
$periodCSStart = date('Y-m-d H:i', $siegeStartCSStart);

$csendTime = explode(":", mconfig('cs_period_end_time'));
$siegeStartCSEnd = strtotime($siegeStart) + (mconfig('cs_period_end_day') * 86400) + ($csendTime[0] * 3600) + ($csendTime[1] * 60);
$periodCSEnd = date('Y-m-d H:i', $siegeStartCSEnd);

if ($siegeStartCSStart <= $now) {
    $siegeStartCSStart = strtotime($siegeStart) + (mconfig('cs_period_start_day') * 86400) + ($csstartTime[0] * 3600) + ($csstartTime[1] * 60) + (mconfig('cs_period_cycle_day') * 86400);
    $periodCSStart = date('Y-m-d H:i', $siegeStartCSStart);

    $siegeStartCSEnd = strtotime($siegeStart) + (mconfig('cs_period_end_day') * 86400) + ($csendTime[0] * 3600) + ($csendTime[1] * 60) + (mconfig('cs_period_cycle_day') * 86400);
    $periodCSEnd = date('Y-m-d H:i', $siegeStartCSEnd);
}

$periodCSStart = date($config["time_format"], strtotime($periodCSStart));
$periodCSEnd = date($config["time_format"] . ', ' . $config["date_format"], strtotime($periodCSEnd));

?>

    <div class="index_cs home_container">
        <div class="sub_header">
            <h1><?php echo lang('template_txt_4', true); ?></h1>
            <h2><a href="<?php __BASE_URL__ ?>castlesiege"><?php echo lang('template_txt_5', true); ?></a></h2>
            <span class="title_overlay"></span>
        </div>
        <div class="cont_container2">
            <table width="100%" class="bottom-cs-table">
                <tr>
                    <td rowspan="4" width="125px">
                        <div id="guild_logo">
                            <div style="padding:0 3px 3px 3px;">
                                <?= returnGuildLogo($castleData[1][1], 112) ?>
                            </div>
                            <p></p>
                        </div>
                    </td>
                    <td align="center"><?php echo lang('template_txt_6', true); ?></td>
                    <td><b><?= $common->replaceHtmlSymbols($castleData[1][0]) ?></b></td>
                </tr>
                <tr>
                    <td align="center"><?php echo lang('template_txt_7', true); ?></td>
                    <td><b><?= $common->replaceHtmlSymbols($castleData[1][6]) ?></b></td>
                </tr>
                <tr>
                    <td align="center"><?php echo lang('template_txt_8', true); ?></td>
                    <td><b><?= number_format($castleData[1][2]) ?></b></td>
                </tr>
                <tr>
                    <td align="center"><?php echo lang('template_txt_9', true); ?></td>
                    <td><b><?= number_format($castleData[1][5]) ?></b></td>
                </tr>
                <tr>
                    <td style="padding-top: 16px; font-size: 16px;"><?php echo lang('template_txt_10', true); ?></td>
                    <td colspan="2" style="padding-top: 16px; font-size: 16px;">
                        <b><?php echo $periodCSStart . ' - ' . $periodCSEnd; ?></b></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="index_cw home_container">
        <div class="sub_header">
            <h1><?php echo lang('template_txt_11', true); ?></h1>
            <span class="title_overlay"></span>
        </div>
        <div class="cont_container2">
            <table width="100%" class="bottom-cw-table" style="margin-top:20px;">
                <tr>
                    <td align="center"
                        style="font-size:16px;"><?php echo lang('template_txt_12', true); ?> <?= $cwStatus ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="top_voters home_container">
        <div class="sub_header">
            <h1><?php echo lang('template_txt_13', true); ?></h1>

            <h2><?php echo lang('template_txt_14', true); ?></h2>
            <span class="title_overlay"></span>
        </div>
        <div class="cont_container">
            <ul class="top_voters_list">
                <?php

                $Character = new Character();
                $ranking_data = LoadCacheData('monthly_rankings/rankings_votes.cache');
                $i = 0;
                foreach ($ranking_data as $rdata) {
                    if ($i >= 1 && $i <= 5) {
                        $accountInfo = $common->accountInformation($rdata[0]);
                        $characterName = $Character->AccountCharacterIDC($accountInfo[_CLMN_USERNM_]);
                        if ($characterName == NULL) $characterName = $accountInfo[_CLMN_USERNM_];
                        echo '<li>';
                        echo '<p>' . $i . '</p>';
                        echo '<a href="' . __BASE_URL__ . 'profile/player/req/' . hex_encode($characterName) . '/">' . $common->replaceHtmlSymbols($characterName) . '</a>';
                        echo '<span>' . $rdata[1];

                        if ($config["flags"])
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="' . __PATH_TEMPLATE__ . 'style/images/blank.png" class="flag-icon flag-icon-' . $rdata[2] . '" alt="' . $custom['countries'][$rdata[2]] . '" title="' . $custom['countries'][$rdata[2]] . '" />';
                        else
                            echo '</span>';

                        echo '</li>';
                    }
                    $i++;
                }

                loadModuleConfigs('usercp.vote');

                if (mconfig('reward_type') == 1)
                    $reward_type = lang('currency_platinum', true);
                elseif (mconfig('reward_type') == 2)
                    $reward_type = lang('currency_gold', true);
                elseif (mconfig('reward_type') == 3)
                    $reward_type = lang('currency_silver', true);
                elseif (mconfig('reward_type') == 4)
                    $reward_type = lang('currency_wcoinc', true);
                elseif (mconfig('reward_type') == 5)
                    $reward_type = lang('currency_gp', true);
                elseif (mconfig('reward_type') == 6)
                    $reward_type = '' . lang('currency_zen', true) . '';
                ?>

            </ul>
            <div class="gift_box">
                <div class="gift_image"></div>
                <h2>
                    <?php echo lang('template_txt_15', true); ?>
                    1st: <?= mconfig('reward_amount') ?>,
                    2nd: <?= mconfig('reward_amount') - mconfig('reward_amount_decrease') ?>,
                    3rd: <?= mconfig('reward_amount') - (mconfig('reward_amount_decrease') * 2) ?>,
                    4th: <?= mconfig('reward_amount') - (mconfig('reward_amount_decrease') * 3) ?>,
                    5th: <?= mconfig('reward_amount') - (mconfig('reward_amount_decrease') * 4) ?> [<?= $reward_type ?>]
                </h2>
            </div>
        </div>
    </div>

    <?php include('arkawar_widget-enc.php'); ?>