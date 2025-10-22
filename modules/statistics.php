<?php
/**
 * ImperiaMuCMS
 * http://imperiamucms.com/
 *
 * @version 2.0.0
 * @author jacubb <admin@imperiamucms.com>
 * @copyright (c) 2014 - 2019, ImperiaMuCMS
 */

if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo '
    <h3>
        ' . lang('server_statistics_1', true) . '
        ' . $breadcrumb . '
    </h3>';

    if (mconfig('active')) {
        $srvInfoCache = LoadCacheData('server_info.cache');
        if (is_array($srvInfoCache)) {
            $srvInfo = explode("|", $srvInfoCache[1][0]);

            $castleData = LoadCacheData('castle_siege.cache');
            $castleSiege = $dB->query_fetch_single("SELECT TOP 1 * FROM MuCastle_DATA");
            $siegeStart = $castleSiege['SIEGE_START_DATE'];

            $csSettings = loadConfigurations('castlesiege');

            $now = time();

            $csstartTime = explode(":", $csSettings['cs_period_start_time']);
            $siegeStartCSStart = strtotime($siegeStart) + ($csSettings['cs_period_start_day'] * 86400) + ($csstartTime[0] * 3600) + ($csstartTime[1] * 60);
            $periodCSStart = date('Y-m-d H:i', $siegeStartCSStart);

            $csendTime = explode(":", $csSettings['cs_period_end_time']);
            $siegeStartCSEnd = strtotime($siegeStart) + ($csSettings['cs_period_end_day'] * 86400) + ($csendTime[0] * 3600) + ($csendTime[1] * 60);
            $periodCSEnd = date('Y-m-d H:i', $siegeStartCSEnd);

            if ($siegeStartCSStart <= $now) {
                $siegeStartCSStart = strtotime($siegeStart) + ($csSettings['cs_period_start_day'] * 86400) + ($csstartTime[0] * 3600) + ($csstartTime[1] * 60) + ($csSettings['cs_period_cycle_day'] * 86400);
                $periodCSStart = date('Y-m-d H:i', $siegeStartCSStart);

                $siegeStartCSEnd = strtotime($siegeStart) + ($csSettings['cs_period_end_day'] * 86400) + ($csendTime[0] * 3600) + ($csendTime[1] * 60) + ($csSettings['cs_period_cycle_day'] * 86400);
                $periodCSEnd = date('Y-m-d H:i', $siegeStartCSEnd);
            }

            $periodCSStart = date($config["time_format"], strtotime($periodCSStart));
            $periodCSEnd = date($config["time_format"] . ', ' . $config["date_format"], strtotime($periodCSEnd));

            echo '
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="table-responsive rankings-table">
                <table class="table table-hover text-center">
                    <tbody>
                        <tr>
                            <th class="headerRow" colspan="2">' . lang('server_statistics_2', true) . '</th>
                        </tr>
                        <tr>
                            <td align="left" width="50%">' . lang('server_statistics_3', true) . '</td>
                            <td align="right" width="50%">' . $srvInfo[0] . '</td>
                        </tr>
                        <tr>
                            <td align="left">' . lang('server_statistics_4', true) . '</td>
                            <td align="right">' . $srvInfo[1] . '</td>
                        </tr>
                        <tr>
                            <td align="left">' . lang('server_statistics_5', true) . '</td>
                            <td align="right">' . $srvInfo[2] . '</td>
                        </tr>
                        <tr>
                            <td align="left">' . lang('server_statistics_6', true) . '</td>
                            <td align="right">' . $srvInfo[3] . '</td>
                        </tr>
                        <tr>
                            <td align="left">' . lang('server_statistics_7', true) . '</td>
                            <td align="right">' . $srvInfo[4] . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="table-responsive rankings-table">
                <table class="table table-hover text-center">
                    <tbody>
                        <tr>
                            <th class="headerRow" colspan="2">' . lang('server_statistics_8', true) . '</th>
                        </tr>
                        <tr>
                            <td colspan="2">' . lang($srvInfo[5], true) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="table-responsive rankings-table">
                <table class="table table-hover text-center">
                    <tbody>
                        <tr>
                            <th class="headerRow" colspan="2">' . lang('server_statistics_9', true) . '</th>
                        </tr>
                        <tr>
                            <td align="left" width="50%">' . lang('server_statistics_10', true) . '</td>
                            <td align="right" width="50%">' . returnGuildLogo($castleData[1][1], 20) . ' ' . $common->replaceHtmlSymbols($castleData[1][0]) . '</td>
                        </tr>
                        <tr>
                            <td align="left">' . lang('server_statistics_11', true) . '</td>
                            <td align="right">' . $common->replaceHtmlSymbols($castleData[1][6]) . '</td>
                        </tr>
                        <tr>
                            <td align="left">' . lang('server_statistics_12', true) . '</td>
                            <td align="right">' . $periodCSStart . ' - ' . $periodCSEnd . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="table-responsive rankings-table">
                <table class="table table-hover text-center">
                    <tbody>
                        <tr>
                            <th class="headerRow" colspan="2">' . lang('server_statistics_15', true) . '</th>
                        </tr>
                        <tr>
                            <td align="left" width="50%">' . lang('server_statistics_16', true) . '</td>
                            <td align="right" width="50%">' . $srvInfo[9] . '</td>
                        </tr>
                        <tr>
                            <td align="left">' . lang('server_statistics_17', true) . '</td>
                            <td align="right">' . $srvInfo[10] . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-4">
            <div class="table-responsive rankings-table">
                <table class="table table-hover text-center">
                    <tbody>
                        <tr>
                            <th class="headerRow" colspan="2">' . lang('server_statistics_18', true) . '</th>
                        </tr>
                        <tr>
                            <td align="left" width="50%">' . lang('server_statistics_19', true) . '</td>
                            <td align="right" width="50%">' . $srvInfo[11] . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>';
        }
    } else {
        message('error', lang('error_47', true));
    }
} else {
    echo '
<div class="sub-page-title">
  <div id="title">
    <h1>Statistics<p></p><span></span></h1>
  </div>
</div>

  <div class="container_2 account" align="center">
    <div class="cont-image">';

    if (mconfig('active')) {

        $srvInfoCache = LoadCacheData('server_info.cache');
        if (is_array($srvInfoCache)) {
            $srvInfo = explode("|", $srvInfoCache[1][0]);
            echo '<div class="container_3" style="padding:0;" align="center">';
            echo '<table class="general-table-ui" cellspacing="0">';
            echo '<tr><th colspan="2">Server Statistics</th></tr>';
            echo '<tr><td align="left" width="50%">' . lang('sidebar_srvinfo_txt_2', true) . '</td><td align="right" width="50%">' . $srvInfo[0] . '</td></tr>';
            echo '<tr><td align="left">' . lang('sidebar_srvinfo_txt_3', true) . '</td><td align="right">' . $srvInfo[1] . '</td></tr>';
            echo '<tr><td align="left">' . lang('sidebar_srvinfo_txt_4', true) . '</td><td align="right">' . $srvInfo[2] . '</td></tr>';
            echo '<tr><td align="left">' . lang('sidebar_srvinfo_txt_5', true) . '</td><td style="color:#00ff00;" align="right">' . $srvInfo[3] . '</td></tr>';
            echo '<tr><td align="left">Active in 24 hours</td><td align="right">' . $srvInfo[4] . '</td></tr>';
            echo '</table>';
            echo '</div>';
            echo '<div class="container_3" style="padding:0;" align="center">';
            echo '<table class="general-table-ui" cellspacing="0">';
            echo '<tr><th colspan="2">CryWolf Info</th></tr>';
            echo '<tr><td align="center" colspan="2">' . $srvInfo[5] . '</td></tr>';
            echo '</table>';
            echo '</div>';
            echo '<div class="container_3" style="padding:0;" align="center">';
            echo '<table class="general-table-ui" cellspacing="0">';
            echo '<tr><th colspan="2">Castle Siege Info</th></tr>';
            echo '<tr><td align="left">Owner Guild</td><td align="right">' . $srvInfo[6] . '</td></tr>';
            echo '<tr><td align="left">Castle Lord</td><td align="right">' . $srvInfo[7] . '</td></tr>';
            echo '<tr><td align="left">Next Siege</td><td align="right">' . $srvInfo[8] . '</td></tr>';
            echo '</table>';
            echo '</div>';
            echo '<div class="container_3" style="padding:0;" align="center">';
            echo '<table class="general-table-ui" cellspacing="0">';
            echo '<tr><th colspan="2">Market Statistics</th></tr>';
            echo '<tr><td align="left">Items in Market</td><td align="right">' . $srvInfo[9] . '</td></tr>';
            echo '<tr><td align="left">Items Sold</td><td align="right">' . $srvInfo[10] . '</td></tr>';
            echo '</table>';
            echo '</div>';
            echo '<div class="container_3" style="padding:0;" align="center">';
            echo '<table class="general-table-ui" cellspacing="0">';
            echo '<tr><th colspan="2">Webshop Statistics</th></tr>';
            echo '<tr><td align="left">Items Sold</td><td align="right">' . $srvInfo[11] . '</td></tr>';
            echo '</table>';
            echo '</div>';
        }

    } else {
        message('error', lang('error_47', true));
    }

    echo '
	</div>
</div>';
}