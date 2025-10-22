<div class="col-md-6 col-xs-12">
    <div>
        <span class="footerCopyright"><?php echo lang('res_template_txt_24', true); ?></span>
        <span class="footerDesc"><?php echo lang('res_template_txt_25', true); ?></span>

        <span class="footerDesc">
            <a href="<?= __BASE_URL__ ?>privacy-policy" style="padding-right: 10px;"><?php echo lang('res_template_txt_26', true); ?></a>
            |<a href="<?= __BASE_URL__ ?>tos" style="padding: 0 10px 0 10px;"><?php echo lang('res_template_txt_12', true); ?></a>
            |<a href="<?= __BASE_URL__ ?>rules" style="padding-left: 10px;"><?php echo lang('res_template_txt_11', true); ?></a>
            <?php

            if ($config["language_switch_active"]) {
                echo '
            <div style="padding: 0 10px 0 10px; display: inline;" class="hidden-xs">|</div>
            <span>' . lang('res_template_txt_27', true);

                foreach ($config["languages"] as $thisLang) {
                    echo '<a href="' . __BASE_URL__ . 'language/switch/?to=' . $thisLang[1] . '" data-toggle="tooltip" data-placement="top" title="' . $thisLang[0] . '"><img src="' . __PATH_TEMPLATE__ . 'images/blank.png" class="flag-icon flag-icon-' . $thisLang[2] . ' footerFlag" alt="' . $custom['countries'][$thisLang[2]] . '" title="' . $thisLang[0] . '" /></a> ';
                }

                echo '
            </span>';
            }

            ?>
        </span>

        <div class="row footerTime">
            <div class="col-md-4 col-xs-12 text-center">
                <img src="<?= __PATH_TEMPLATE__ ?>images/footer_logo.png" class="footerLogo"/>
            </div>
            <div class="col-md-4 col-xs-6 text-center">
                <span><?= lang('res_template_txt_15', true) ?></span><br/>
                <span class="footer-time" id="footerServerTime">00:00</span><br/>
                <span class="footer-date" id="footerServerDate"></span>
            </div>
            <div class="col-md-4 col-xs-6 text-center">
                <span><?= lang('res_template_txt_16', true) ?></span><br/>
                <span class="footer-time" id="footerLocalTime">00:00</span><br/>
                <span class="footer-date" id="footerLocalDate"></span>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-xs-12">
    <div class="col-md-12">
        <h6><?= lang('res_template_txt_17', true) ?></h6>
    </div>
    <div class="col-md-4 col-xs-4">
        <ul class="list-unstyled footerQuickNav">
            <li><a href="<?= __BASE_URL__ ?>news"><?php echo lang('news_txt_3', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>changelogs"><?php echo lang('changelogs_txt_1', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>guides"><?php echo lang('guides_txt_1', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>about"><?php echo lang('about_txt_1', true); ?></a></li>
            <li><a href="<?= $config['website_forum_link'] ?>"><?php echo lang('res_template_txt_28', true); ?></a></li>
        </ul>
    </div>
    <div class="col-md-4 col-xs-4">
        <ul class="list-unstyled footerQuickNav">
            <li><a href="<?= __BASE_URL__ ?>register"><?php echo lang('res_template_txt_1', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>downloads"><?php echo lang('res_template_txt_2', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>rankings"><?php echo lang('res_template_txt_3', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>usercp/webshop"><?php echo lang('res_template_txt_14', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>usercp"><?php echo lang('res_template_txt_18', true); ?></a></li>
        </ul>
    </div>
    <div class="col-md-4 col-xs-4">
        <ul class="list-unstyled footerQuickNav">
            <li><a href="<?= __BASE_URL__ ?>privacy-policy"><?php echo lang('res_template_txt_26', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>rules"><?php echo lang('res_template_txt_11', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>tos"><?php echo lang('res_template_txt_12', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>donation"><?php echo lang('res_template_txt_9', true); ?></a></li>
            <li><a href="<?= __BASE_URL__ ?>ticket"><?php echo lang('res_template_txt_29', true); ?></a></li>
        </ul>
    </div>
</div>