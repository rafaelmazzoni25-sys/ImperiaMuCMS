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
        ' . lang('privacypolicy_txt_1', true) . '
        ' . $breadcrumb . '
    </h3>
    <div class="row">
        <div class="col-xs-12 text-justify">
            ' . lang('privacypolicy_txt_2', true) . '
        </div>
    </div>';
}