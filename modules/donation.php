<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

if (defined(__RESPONSIVE__) && __RESPONSIVE__ == "TRUE") {
    $breadcrumb = generateBreadcrumb();
    echo "\n    <h3>\n        " . lang("donation_txt_3", true) . "\n        " . $breadcrumb . "\n    </h3>";
    if (mconfig("active")) {
        echo "\n        <div class=\"row desc-row\">\n            <div class=\"col-xs-12\">" . lang("donation_txt_4", true) . "</div>\n        </div>\n        <div class=\"row donation-row\">";
        loadModuleConfigs("donation.paypal");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/paypal\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/paypal.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.paygol");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/paygol\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/paygol.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.paymentwall");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/paymentwall\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/paymentwall.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.paynl");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/paynl\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/paynl.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.superrewards");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/superrewards\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/superrewards.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.pagseguro");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/pagseguro\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/pagseguro.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.westernunion");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/westernunion\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/westernunion.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.homepaypl");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/homepaypl\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/homepaypl.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.payu");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/payu\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/payu.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.mercadopago");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/mercadopago\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/mercadopago.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.interkassa");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/interkassa\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/interkassa.png\" height=\"65px\"/></div></a>";
        }
        loadModuleConfigs("donation.nganluong");
        if (mconfig("active")) {
            echo "<a href=\"" . __BASE_URL__ . "donation/nganluong\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/nganluong.png\" height=\"65px\"/></div></a>";
        }
        $General = new xGeneral();
        if ($General->ftanHCIfo_canUse_j8GsnawwvJ_Module("manual_donation")) {
            loadModuleConfigs("manualdonation");
            if (mconfig("active")) {
                if (mconfig("enable_viettel")) {
                    echo "<a href=\"" . __BASE_URL__ . "donation/manualdonation/gateway/viettel\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/viettel.png\" height=\"65px\"/></div></a>";
                }
                if (mconfig("enable_mobifone")) {
                    echo "<a href=\"" . __BASE_URL__ . "donation/manualdonation/gateway/mobifone\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/mobifone.png\" height=\"65px\"/></div></a>";
                }
                if (mconfig("enable_vinaphone")) {
                    echo "<a href=\"" . __BASE_URL__ . "donation/manualdonation/gateway/vinaphone\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/vinaphone.png\" height=\"65px\"/></div></a>";
                }
            }
        }
        $xml = simplexml_load_file(__PATH_INCLUDES__ . "config/modules/donation.xml");
        if ($xml !== false && $xml->custom->children() != NULL) {
            foreach ($xml->custom->children() as $tag => $method) {
                if ($tag == "method") {
                    echo "<a href=\"" . $method["link"] . "\"><div class=\"col-xs-12 col-sm-6 col-md-4 donation-method\"><img src=\"" . __PATH_TEMPLATE_ASSETS__ . "donation/" . $method["image"] . "\" height=\"65px\"/></div></a>";
                }
            }
        }
        echo "\n        </div>";
    } else {
        message("error", lang("error_47", true));
    }
} else {
    echo "\n<div class=\"sub-page-title\">\n    <div id=\"title\"><h1>" . lang("module_titles_txt_3", true) . "<p></p><span></span></h1></div>\n</div>\n<div class=\"container_2 account\" align=\"center\">\n    <div class=\"cont-image\">\n        <div class=\"container_3 account_sub_header\">\n            <div class=\"grad\">\n                <div class=\"page-title\">" . lang("donation_txt_3", true) . "</div>\n                <a href=\"" . __BASE_URL__ . "usercp\">" . lang("global_module_1", true) . "</a>\n            </div>\n        </div>";
    if (mconfig("active")) {
        echo "\n        <div class=\"page-desc-holder\">\n            <b>" . lang("donation_txt_4", true) . "</b><br/><br/>\n        </div>\n        <div class=\"container_3 account-wide\" align=\"center\">\n            <div class=\"buy-coins\">\n                <ul class=\"payment_methods\">";
        loadModuleConfigs("donation.paypal");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/paypal\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/paypal.png\"/></a></li>";
        }
        loadModuleConfigs("donation.paygol");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/paygol\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/paygol.png\"/></a></li>";
        }
        loadModuleConfigs("donation.paymentwall");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/paymentwall\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/paymentwall.png\"/></a></li>";
        }
        loadModuleConfigs("donation.paynl");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/paynl\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/paynl.png\"/></a></li>";
        }
        loadModuleConfigs("donation.superrewards");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/superrewards\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/superrewards.png\"/></a></li>";
        }
        loadModuleConfigs("donation.pagseguro");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/pagseguro\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/pagseguro.png\"/></a></li>";
        }
        loadModuleConfigs("donation.westernunion");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/westernunion\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/westernunion.png\"/></a></li>";
        }
        loadModuleConfigs("donation.homepaypl");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/homepaypl\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/homepaypl.png\"/></a></li>";
        }
        loadModuleConfigs("donation.payu");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/payu\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/payu.png\"/></a></li>";
        }
        loadModuleConfigs("donation.mercadopago");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/mercadopago\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/mercadopago.png\" height=\"65px\"/></a></li>";
        }
        loadModuleConfigs("donation.interkassa");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/interkassa\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/interkassa.png\" height=\"65px\"/></a></li>";
        }
        loadModuleConfigs("donation.nganluong");
        if (mconfig("active")) {
            echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/nganluong\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/nganluong.png\" height=\"65px\"/></a></li>";
        }
        loadModuleConfigs("manualdonation");
        if (mconfig("active")) {
            if (mconfig("enable_viettel")) {
                echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/manualdonation/gateway/viettel/\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/viettel.png\"/></a></li>";
            }
            if (mconfig("enable_mobifone")) {
                echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/manualdonation/gateway/mobifone/\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/mobifone.png\"/></a></li>";
            }
            if (mconfig("enable_vinaphone")) {
                echo "<li id=\"method\"><a href=\"" . __BASE_URL__ . "donation/manualdonation/gateway/vinaphone/\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/vinaphone.png\"/></a></li>";
            }
        }
        $xml = simplexml_load_file(__PATH_INCLUDES__ . "config/modules/donation.xml");
        if ($xml !== false && $xml->custom->children() != NULL) {
            foreach ($xml->custom->children() as $tag => $method) {
                if ($tag == "method") {
                    echo "<li id=\"method\"><a href=\"" . $method["link"] . "\"> <img src=\"" . __PATH_TEMPLATE__ . "style/images/" . $method["image"] . "\"/></a></li>";
                }
            }
        }
        echo "\n              </ul>\n              " . lang("donation_txt_5", true) . "\n            </div>\n          </div>";
    } else {
        message("error", lang("error_47", true));
    }
    echo "\n    </div>\n</div>";
}

?>