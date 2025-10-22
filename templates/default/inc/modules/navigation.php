<ul class="top-navigation">
    <li>
        <a id="home" href="<?= __BASE_URL__ ?>news"><p></p></a>

        <p></p>

        <div class="nddm-holder" align="center">
            <div class="navi-dropdown" style="left: 10px;">
                <span><a href="<?= __BASE_URL__ ?>news"><?php echo lang('news_txt_3', true); ?></a></span>
                <span><a href="<?= __BASE_URL__ ?>changelogs"><?php echo lang('changelogs_txt_1', true); ?></a></span>
            </div>
        </div>
    </li>
    <li>
        <a id="forums" href="<?= $config['website_forum_link'] ?>"><p></p></a>

        <p></p>

        <div class="nddm-holder" align="center">
            <div class="navi-dropdown" style="left: 10px;">
                <span><a href="<?= __BASE_URL__ ?>ticket"><?php echo lang('module_titles_txt_30', true); ?></a></span>
                <span><a href="<?= __BASE_URL__ ?>downloads"><?php echo lang('menu_txt_7', true); ?></a></span>
                <span><a href="<?= $config['website_forum_link'] ?>"><?php echo lang('menu_txt_2', true); ?></a></span>
                <span><a href="#"><?php echo lang('template_txt_19', true); ?></a></span>
            </div>
        </div>
    </li>
    <li>
        <a id="media" href="<?= __BASE_URL__ ?>rankings"><p></p></a>

        <p></p>

        <div class="nddm-holder" align="center">
            <div class="navi-dropdown" style="left: 10px;">
                <span><a href="<?= __BASE_URL__ ?>rankings/characters"><?php echo lang('rankings_txt_54', true); ?></a></span>
                <span><a href="<?= __BASE_URL__ ?>rankings/killers"><?php echo lang('rankings_txt_3', true); ?></a></span>
                <span><a href="<?= __BASE_URL__ ?>rankings/guilds"><?php echo lang('rankings_txt_4', true); ?></a></span>
                <span><a href="<?= __BASE_URL__ ?>rankings/gens"><?php echo lang('rankings_txt_8', true); ?></a></span>
                <span><a href="<?= __BASE_URL__ ?>rankings/votes"><?php echo lang('template_txt_13', true); ?></a></span>
            </div>
        </div>
    </li>
    <li id="logo"><a href="<?= __BASE_URL__ ?>"><p></p></a></li>
    <li>
        <a id="features" href="<?= __BASE_URL__ ?>donation"><p></p></a>

        <p></p>

        <div class="nddm-holder" align="center">
            <div class="navi-dropdown">
                <span><a href="<?= __BASE_URL__ ?>donation/paypal"><?php echo lang('module_titles_txt_21', true); ?></a></span>
                <span><a href="<?= __BASE_URL__ ?>donation/paymentwall"><?php echo lang('module_titles_txt_31', true); ?></a></span>
            </div>
        </div>
    </li>
    <li>
        <a id="support" href="<?= __BASE_URL__ ?>webshop"><p></p></a>

        <p></p>

        <div class="nddm-holder" align="center">
            <div class="navi-dropdown" style="left: 20px;">
                <span><a href="<?= __BASE_URL__ ?>webshop/shop"><?php echo lang('itemsinv_txt_2', true); ?></a></span>
                <span><a href="<?= __BASE_URL__ ?>usercp/items"><?php echo lang('itemsinv_txt_1', true); ?></a></span>
            </div>
        </div>
    </li>
    <li>
        <a id="goal" href="<?= __BASE_URL__ ?>about"><p></p></a>

        <p></p>

        <div class="nddm-holder" align="center">
            <div class="navi-dropdown" style="left: 20px;">
                <span><a href="<?= __BASE_URL__ ?>rules"><?php echo lang('rules_txt_1', true); ?></a></span>
                <span><a href="<?= __BASE_URL__ ?>tos"><?php echo lang('tos', true); ?></a></span>
            </div>
        </div>
    </li>
</ul>