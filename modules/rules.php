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
        ' . lang('rules_txt_1', true) . '
        ' . $breadcrumb . '
    </h3>
    <div class="row">
        <div class="col-xs-12 text-justify">
            ' . lang('rules_txt_2', true) . '
        </div>
    </div>';
} else {
    ?>
    <div class="sub-page-title">
        <div id="title">
            <h1><?php echo lang('rules_txt_1', true); ?><p></p><span></span></h1>
        </div>
    </div>
    <div class="container_2" align="center">
        <div class="container_3 rules-wide rules" align="left">
            <?php echo lang('rules_txt_2', true); ?>
        </div>
    </div>
    <?php
}