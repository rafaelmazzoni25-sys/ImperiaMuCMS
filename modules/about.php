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
        ' . lang('about_txt_1', true) . '
        ' . $breadcrumb . '
    </h3>';

    if (mconfig('active')) {
        echo '
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
                <div class="table-responsive rankings-table">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th colspan="2">' . lang('about_txt_3', true) . '</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_4', true) . '</td>
                                <td align="right" width="50%">MIDGARD SERVER</td>
                            </tr>
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_5', true) . '</td>
                                <td align="right" width="50%">Season 15</td>
                            </tr>
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_6', true) . '</td>
                                <td align="right" width="50%">x1000</td>
                            </tr>
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_7', true) . '</td>
                                <td align="right" width="50%">40%</td>
                            </tr>
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_8', true) . '</td>
                                <td align="right" width="50%">PvP</td>
                            </tr>
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_9', true) . '</td>
                                <td align="right" width="50%">400</td>
                            </tr>
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_10', true) . '</td>
                                <td align="right" width="50%">520</td>
                            </tr>';

        if ($config['use_resets']) {
            echo '
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_11', true) . '</td>
                                <td align="right" width="50%">100</td>
                            </tr>';
        }

        if ($config['use_grand_resets']) {
            echo '
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_12', true) . '</td>
                                <td align="right" width="50%">100</td>
                            </tr>';
        }

        echo '
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_13', true) . '</td>
                                <td align="right" width="50%">5/7</td>
                            </tr>
                            <tr>
                                <td align="left" width="50%">' . lang('about_txt_14', true) . '</td>
                                <td align="right" width="50%">1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>';
    } else {
        message('error', lang('error_47', true));
    }
} else {
    echo '
<div class="sub-page-title">
  <div id="title">
    <h1>' . lang('about_txt_1', true) . '<p></p><span></span></h1>
  </div>
</div>

  <div class="container_2 account" align="center">
    <div class="cont-image">';

    if (mconfig('active')) {

        echo '<div class="page-desc-holder">' . lang('about_txt_2', true) . '</div>';
        echo '<div class="container_3" style="padding:0;" align="center">';
        echo '<table class="general-table-ui" cellspacing="0">';
        echo '<tr><th colspan="2">' . lang('about_txt_3', true) . '</th></tr>';
        echo '<tr><td align="left" width="50%">' . lang('about_txt_4', true) . '</td><td align="right" width="50%">MIDGARD SERVER</td></tr>';
        echo '<tr><td align="left" width="50%">' . lang('about_txt_5', true) . '</td><td align="right" width="50%">Season 15</td></tr>';
        echo '<tr><td align="left" width="50%">' . lang('about_txt_6', true) . '</td><td align="right" width="50%">x1000</td></tr>';
        echo '<tr><td align="left" width="50%">' . lang('about_txt_7', true) . '</td><td align="right" width="50%">40%</td></tr>';
        echo '<tr><td align="left" width="50%">' . lang('about_txt_8', true) . '</td><td align="right" width="50%">PvP</td></tr>';
        echo '<tr><td align="left" width="50%">' . lang('about_txt_9', true) . '</td><td align="right" width="50%">400</td></tr>';
        echo '<tr><td align="left" width="50%">' . lang('about_txt_10', true) . '</td><td align="right" width="50%">330</td></tr>';
        if ($config['use_resets'])
            echo '<tr><td align="left" width="50%">' . lang('about_txt_11', true) . '</td><td align="right" width="50%">100</td></tr>';
        if ($config['use_grand_resets'])
            echo '<tr><td align="left" width="50%">' . lang('about_txt_12', true) . '</td><td align="right" width="50%">100</td></tr>';
        echo '<tr><td align="left" width="50%">' . lang('about_txt_13', true) . '</td><td align="right" width="50%">5/7</td></tr>';
        echo '<tr><td align="left" width="50%">' . lang('about_txt_14', true) . '</td><td align="right" width="50%">1</td></tr>';
        echo '</table>';
        echo '</div>';

        echo '<div class="container_3" style="padding:0;" align="center">';
        echo '<table class="general-table-ui" cellspacing="0">';
        echo '<tr><th colspan="2">' . lang('about_txt_15', true) . '</th></tr>';
        echo '<tr><td align="left" width="50%">Summoner</td><td align="right" width="50%">0</td></tr>';
        echo '<tr><td align="left" width="50%">Magic Gladiator</td><td align="right" width="50%">0</td></tr>';
        echo '<tr><td align="left" width="50%">Dark Lord</td><td align="right" width="50%">0</td></tr>';
        echo '<tr><td align="left" width="50%">Rage Fighter</td><td align="right" width="50%">0</td></tr>';
        echo '<tr><td align="left" width="50%">Grow Lancer</td><td align="right" width="50%">0</td></tr>';
		echo '<tr><td align="left" width="50%">Rune Wizard</td><td align="right" width="50%">0</td></tr>';
		echo '<tr><td align="left" width="50%">Slayer</td><td align="right" width="50%">0</td></tr>';
        echo '</table>';
        echo '</div>';

        echo '<div class="container_3" style="padding:0;" align="center">';
        echo '<table class="general-table-ui" cellspacing="0">';
        echo '<tr><th colspan="2">' . lang('about_txt_16', true) . '</th></tr>';
        echo '<tr><td align="left" width="50%">' . lang('currency_bless', true) . '</td><td align="right" width="50%">100%</td></tr>';
        echo '<tr><td align="left" width="50%">' . lang('currency_soul', true) . '</td><td align="right" width="50%">50%</td></tr>';
        echo '<tr><td align="left" width="50%">' . lang('currency_life', true) . '</td><td align="right" width="50%">50%</td></tr>';
        echo '</table>';
        echo '</div>';

        echo '<div class="container_3" style="padding:0;" align="center">';
        echo '<table class="general-table-ui" cellspacing="0">';
        echo '<tr><th colspan="2">' . lang('about_txt_17', true) . '</th></tr>';
        echo '<tr><td align="left" width="50%">' . sprintf(lang('about_txt_18', true), "+10") . '</td><td align="right" width="50%">' . sprintf(lang('about_txt_19', true), "70%", "90%") . '</td></tr>';
        echo '<tr><td align="left" width="50%">' . sprintf(lang('about_txt_18', true), "+11") . '</td><td align="right" width="50%">' . sprintf(lang('about_txt_19', true), "65%", "85%") . '</td></tr>';
        echo '<tr><td align="left" width="50%">' . sprintf(lang('about_txt_18', true), "+12") . '</td><td align="right" width="50%">' . sprintf(lang('about_txt_19', true), "60%", "80%") . '</td></tr>';
        echo '<tr><td align="left" width="50%">' . sprintf(lang('about_txt_18', true), "+13") . '</td><td align="right" width="50%">' . sprintf(lang('about_txt_19', true), "55%", "75%") . '</td></tr>';
        echo '<tr><td align="left" width="50%">' . sprintf(lang('about_txt_18', true), "+14") . '</td><td align="right" width="50%">' . sprintf(lang('about_txt_19', true), "50%", "70%") . '</td></tr>';
        echo '<tr><td align="left" width="50%">' . sprintf(lang('about_txt_18', true), "+15") . '</td><td align="right" width="50%">' . sprintf(lang('about_txt_19', true), "45%", "65%") . '</td></tr>';
        echo '</table>';
        echo '</div>';

    } else {
        message('error', lang('error_47', true));
    }

    echo '
	</div>
</div>
';
}