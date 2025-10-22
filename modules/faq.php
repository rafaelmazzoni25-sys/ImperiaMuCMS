<?php
/**
 * ImperiaMuCMS
 * http://imperiamucms.com/
 *
 * @version 2.0.0
 * @author jacubb <admin@imperiamucms.com>
 * @copyright (c) 2014 - 2019, ImperiaMuCMS
 */

$faq = array(
    array('What is MuOnline?', 'MU Online is a 3D medieval fantasy MMORPG, produced by Webzen, a Korean gaming company. For more information about the game visit the following link: <a href="http://en.wikipedia.org/wiki/Mu_Online" target="_blank">http://en.wikipedia.org/wiki/Mu_Online</a>'),

    array('Where can I find the terms of service?', 'You can find the T.O.S. by <a href="#">clicking here</a>'),

    array('How do I register a new account?', ''),

    array('Which of my personal information do you store and what is it used for?', ''),

    array('How and/or where do I download the game client?', 'You can download the game client at our website <a href="#">downloads page</a>.'),

    array('How do I connect to the server?', ''),

    array('Which operating systems is the game compatible with?', 'MuOnline can be run in the following operating systems:<br /><br /><ul><li>Windows 8</li><li>Windows 7</li><li>Windows Vista</li><li>Windows XP</li></ul>'),

    array('What are the server features and rates?', ''),

    array('What are donations used for?', ''),

    array('How can I earn coins for free?', ''),

    array('What is the vote & reward system?', ''),

    array('How do I level up?', ''),

    array('What are the character resets?', 'When you reach the maximum level (400) you can perform a RESET at the website. This will reset your character\'s level back to 1 but you will keep your current stats, money, inventory and equipment. <br /><br /> By doing resets you can achieve the player\'s max stats.'),

    array('What are the max stats?', 'The max stats for all character classes is 32767.'),

    array('What is the maximum amount of resets my character can have?', ''),

    array('Where can I find detailed gameplay tutorials, guides and tips?', ''),

    array('What is a game master?', ''),

    array('How can I contact the server staff and administrators?', ''),

    array('Where can I get technical support?', ''),

    array('Where do I report a game issue or bug?', ''),

    array('Where do I report a scammer?', ''),

    array('I forgot my account password. How can I recover it?', ''),

    array('I have problems using the website. Where can I get assistance?', ''),

    array('Can I request a complete deletion of my account and data stored in the server?', ''),
);

echo "
<script type=\"text/javascript\">
<!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
</script>";

echo '
<div class="sub-page-title">
  <div id="title"><h1>' . lang('module_titles_txt_14', true) . '<p></p><span></span></h1></div>
</div>
<div class="container_2" align="center">
  <div class="container_3 archived-news" align="left">
    <div id="accordion" class="ui-accordion ui-widget ui-helper-reset ui-accordion-icons" role="tablist">';

$i = 1;
foreach ($faq as $thisFAQ) {
    if (check_value($thisFAQ[1])) {
        echo '
        <ul class="howto-row">
          <li onclick="toggle_visibility(\'faq' . $i . '\');" class="howto-row-title ui-accordion-header ui-helper-reset ui-state-active ui-corner-top"><span class="ui-icon ui-icon-triangle-1-s"></span>' . $thisFAQ[0] . '</li>
          <div id="faq' . $i . '" style="width:90%; padding: 10px 0 20px 36px; display: none;">
            <p>' . $thisFAQ[1] . '</p>
          </div>
        </ul>';
        $i++;
    }
}

echo '      
    </div>
  </div>
</div>';

?>