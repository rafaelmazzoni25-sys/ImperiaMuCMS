/************************************************************************
 Add by misoka
 *************************************************************************/

function InitCategoryList() {
    $('.itemPricePlatinum').hide();
    $('.itemPriceGold').hide();
    $('.itemPriceSilver').hide();

    setPriceVisibility();

    $('.chItemPrice').change(function () {
        if ($('.chItemPrice:checked').length < 2) {
            $('.chItemPrice').prop('disabled', false);
            $('.chItemPrice').removeClass('disabled');
        }
        else {
            $('.chItemPrice').each(function () {
                if (!$(this).prop('checked')) {
                    $(this).prop('disabled', true);
                    $(this).addClass('disabled');
                }
            });
        }

        setPriceVisibility();
    });
}

function setPriceVisibility() {
    $('.chItemPrice').each(function () {
        var id = $(this).attr('id');
        var show = $(this).prop('checked');

        switch (id) {
            case "chShowPlatinum":
                if (show) $('.itemPricePlatinum').show(); else $('.itemPricePlatinum').hide();
                break;
            case "chShowGold":
                if (show) $('.itemPriceGold').show(); else $('.itemPriceGold').hide();
                break;
            case "chShowSilver":
                if (show) $('.itemPriceSilver').show(); else $('.itemPriceSilver').hide();
                break;
        }
    });
}

function InitItemForm(activeCredit) {
    $('.creditTypeName').html(creditType[activeCredit]["name"]);
    recalculateItemForm();

    $('.btn_type4').click(function () {
        $('.btn_type4').removeClass('on');
        $(this).addClass('on');
        var id = $(this).attr('id');

        switch (id) {
            case "btnPlatinum":
                recalculateOptions(0);
                break;
            case "btnGold":
                recalculateOptions(1);
                break;
            case "btnSilver":
                recalculateOptions(2);
                break;
        }

        recalculateItemForm();
    });

    $('.chk').change(function () {
        var id = $(this).attr('id');
        if (this.checked)
            showOptionInfo(id);
        else
            hideOptionInfo(id);

        checkMaxExtOpt();
        recalculateItemForm();
    });

    if (ancExc == 0) {
        $('.excOpt').change(function () {
            setAncientVisibility();
        });
    }

    $('#dOptionLevel').change(function () {
        setOptionLevel($(this).val());
        setHarmonyOption($(this).val());
        setHarmony($('#harmony').val());
        setAncientVisibility();
        recalculateItemForm();
    });

    $('#dOptionLife').change(function () {
        setOptionLife($(this).val());
        recalculateItemForm();
    });

    $('#harmony').change(function () {
        setHarmony($(this).val());
        recalculateItemForm();
        setAncientVisibility();
    });

    $('#ancopt').change(function () {
        var className = $('#ancopt option:selected').attr('class');
        setStaminaOption($(this).val(), className);
        setHarmonyVisibility();
        setExcVisibility();
        recalculateItemForm();
    });

    $('#stamina').change(function () {
        setStaminaPrice();
        recalculateItemForm();
    });

    for (var i = 1; i <= maxSocket; i++) {
        $("#socket" + i).change({socketId: i}, function (event) {
            var val = $(this).val();
            setSocket(val, event.data.socketId);
            recalculateItemForm();
            setSocketsOption();
        });
    }

    $("#socket99").change({socketId: i}, function (event) {
        var val = $(this).val();
        setBonusSocket(val);
        recalculateItemForm();
        setSocketsOption();
    });
}

function recalculateItemForm() {
    var itemPrice = Math.ceil($('#dPriceBit').html() * activeRatio);
    var optionPrice = 0;

    var level = $('#dOptionLevel').val();
    var levelBit = $('#dOptionLevelBit').html();
    if (level)
        optionPrice += Math.ceil(level * activeRatio * levelBit);

    var life = $('#dOptionLife').val();
    var lifeBit = $('#dOptionLifeBit').html();
    if (life)
        optionPrice += Math.ceil(life * activeRatio * lifeBit);

    optionPrice += getStaminaPrice();

    var harmonyVal = $('#harmony').val();
    if (harmonyVal) {
        var price = 0;
        for (var hoption in harmony) {
            for (var hid in harmony[hoption]) {
                if (hid == harmonyVal) {
                    price = parseInt(harmony[hoption][hid]['price']);
                    break;
                }
            }
            if (price != 0)
                break;
        }

        optionPrice += Math.ceil(price * activeRatio);
    }

    $('.chk').each(function () {
        var id = $(this).attr('id');
        if (this.checked) {
            var infoBit = $('#' + id + 'Bit');

            if (infoBit.length)
                optionPrice += Math.ceil(infoBit.html() * activeRatio);
        }
    });

    for (var i = 1; i <= maxSocket; i++) {
        var s = $('#socket' + i).val();
        if (s) optionPrice += Math.ceil(sockets[s]['price'] * activeRatio);
    }

    var bs = $('#socket99').val();
    if (bs) optionPrice += Math.ceil(bsockets[bs]['price'] * activeRatio);

    var total = itemPrice + optionPrice;

    $('#dPriceCoinC').html(itemPrice);
    $('#optPriceCoinC').html(optionPrice);
    $('#totPriceCoinC').html(total);
}

function recalculateOptions(type) {
    if (creditType[type]) {
        activeRatio = creditType[type]["ratio"];

        $('.creditTypeName').html(creditType[type]["name"]);
        $('#activeCredit').val(type);

        $('.chk').each(function () {
            var id = $(this).attr('id');
            if (this.checked)
                showOptionInfo(id);
            else
                hideOptionInfo(id);
        });

        setOptionLevel($('#dOptionLevel').val());
        setOptionLife($('#dOptionLife').val());
        setStaminaPrice();
        setHarmony($('#harmony').val());

        for (var i = 1; i <= maxSocket; i++) {
            setSocket($('#socket' + i).val(), i);
        }
        setBonusSocket($('#socket99').val());
    }
}

function checkMaxExtOpt() {
    var check = true;
    if (ancExc == 0) {
        var val = $('#ancopt').val();
        if (val)
            check = false;
    }

    if (check) {
        if ($('.excOpt:checked').length < maxExcOpt) {
            $('.excOpt').prop('disabled', false);
            $('.excOpt').removeClass('disabled');
        }
        else {
            $('.excOpt').each(function () {
                if (!$(this).prop('checked')) {
                    $(this).prop('disabled', true);
                    $(this).addClass('disabled');
                }
            });
        }
    }
}

function setOptionLevel(val) {
    if (val) {
        var bit = $('#dOptionLevelBit').html();
        var text = '+' + Math.ceil(bit * activeRatio * val);
        $('#dOptionLevelCoinC').html(text);
        $('#dOptionLevelCoinC').show();
    }
    else
        $('#dOptionLevelCoinC').hide();
}

function setOptionLife(val) {
    if (val) {
        var bit = $('#dOptionLifeBit').html();
        var text = '+' + Math.ceil(bit * activeRatio * val);
        $('#dOptionLifeCoinC').html(text);
        $('#dOptionLifeCoinC').show();
    }
    else
        $('#dOptionLifeCoinC').hide();
}

function setSocket(val, id) {
    if (val) {
        var price = sockets[val]['price'];
        var text = '+' + Math.ceil(price * activeRatio);
        $('#socket' + id + 'CoinC').html(text);
        $('#socket' + id + 'CoinC').show();
    }
    else
        $('#socket' + id + 'CoinC').hide();
}

function setBonusSocket(val) {
    if (val) {
        var price = bsockets[val]['price'];
        var text = '+' + Math.ceil(price * activeRatio);
        $('#socket99CoinC').html(text);
        $('#socket99CoinC').show();
    }
    else
        $('#socket99CoinC').hide();
}

function setSocketsOption() {
    if (allowSameSocket == 0) {
        var disableType = [];

        for (var i = 1; i <= maxSocket; i++) {
            var val = $('#socket' + i).val();
            if (val) {
                var type = sockets[val]['type'];
                if (type != -1)
                    disableType[i] = type;
            }
        }

        for (var i = 1; i <= maxSocket; i++) {
            $('#socket' + i + ' option').each(function () {
                var val = $(this).val();
                if (val) {
                    var type = sockets[val]['type'];
                    var index = $.inArray(type, disableType);
                    if (index > -1 && index != i)
                        //$(this).attr("disabled", "disabled");
                        $(this).hide();
                    else
                        //$(this).removeAttr("disabled");
                        $(this).show();
                }
            });
        }
    }
}

function showOptionInfo(id) {
    var info = $('#' + id + 'CoinC');
    var bit = $('#' + id + 'Bit');
    var val = '';

    if (bit.length)
        val = '+' + Math.ceil(bit.html() * activeRatio);

    if (info.length) {
        info.html(val);
        info.show();
    }
}

function hideOptionInfo(id) {
    var info = $('#' + id + 'CoinC');
    if (info.length)
        info.hide();
}

function setStaminaOption(val, tier) {
    var stamina = $('#stamina');

    if (stamina.length) {
        if (val) {
            stamina.find('option').remove().end();
            if (tier == 'anc21' || tier == 'anc22') {
                stamina.append('<option value="6" class="anc21">+5</option>')
                    .append('<option value="10" class="anc22">+10</option>');
            }
            else {
                stamina.append('<option value="5" class="anc11">+5</option>')
                    .append('<option value="9" class="anc12">+10</option>');
            }
            setStaminaPrice();
        }
        else {
            stamina.find('option').remove().end().append('<option value="">None</option>');
            setStaminaPrice();
        }

        var x = stamina.next();
        if (typeof x.attr('id') != 'undefined') {
            if (x.attr('id') == 'stamina')
                x.remove();
            stamina.SelectTransform();
        }
    }
}

function setStaminaPrice() {
    var val = $('#stamina').val();
    var tier = $('#stamina option:selected').attr('class');
    if (val && tier) {
        var bit = $('#' + tier).html();
        var text = '+' + Math.ceil(bit * activeRatio);
        $('#staminaCoinC').html(text);
        $('#staminaCoinC').show();
    }
    else
        $('#staminaCoinC').hide();
}

function getStaminaPrice() {
    var price = 0;
    var val = $('#stamina').val();
    var tier = $('#stamina option:selected').attr('class');
    if (val && tier) {
        var bit = $('#' + tier).html();
        price = Math.ceil(bit * activeRatio);
    }

    return price;
}

function setHarmonyOption(level) {
    var h = $('#harmony');

    if (h.length) {
        h.find('option').remove().end().append('<option value="">None</option>');

        if (level != undefined) {
            level = parseInt(level);
            for (var hoption in harmony) {
                var max = -1;
                var maxValue = -1;
                for (var id in harmony[hoption]) {
                    if (harmony[hoption][id] != undefined) {
                        var hVal = parseInt(harmony[hoption][id]['hvalue']);
                        if (hVal <= level) {
                            if (maxValue < hVal) {
                                max = id;
                                maxValue = hVal;
                            }
                        }
                    }
                    if (maxValue >= level)
                        break;
                }

                if (max != -1) {
                    if (harmony[hoption][max] != undefined) {
                        var value = harmony[hoption][max]['name'];  //+' ['+hoption+']['+harmony[hoption][max]['hvalue']+']';
                        h.append($("<option></option>").attr("value", max).text(value));
                    }
                }
            }
        }

        var x = h.next();
        if (typeof x.attr('id') != 'undefined') {
            if (x.attr('id') == 'harmony')
                x.remove();
            h.SelectTransform();
        }
    }
}

function setHarmony(val) {
    if (val) {
        var price = 0;

        for (var hoption in harmony) {
            for (var id in harmony[hoption]) {
                if (id == val) {
                    price = harmony[hoption][id]['price'];
                    break;
                }
            }
        }

        var text = '+' + Math.ceil(price * activeRatio);
        $('#harmonyCoinC').html(text);
        $('#harmonyCoinC').show();
    }
    else
        $('#harmonyCoinC').hide();
}

function setExcVisibility() {
    if (ancExc == 0) {
        var val = $('#ancopt').val();
        if (val) {
            $('.excOpt').prop('disabled', true);
            $('.excOpt').addClass('disabled');
        }
        else {
            $('.excOpt').prop('disabled', false);
            $('.excOpt').removeClass('disabled');
        }
    }
}

function setHarmonyVisibility() {
    if (ancHarm == 0) {
        var ancSet = $('#ancopt');
        if (ancSet) {
            var val = ancSet.val();
            if (val == '' || val == undefined) {
                $('#harmony').prop('disabled', false);
                $('#harmony').removeClass('disabled');
            }
            else {
                $('#harmony').prop('disabled', true);
                $('#harmony').addClass('disabled');
            }
        }
    }
}

function setAncientVisibility() {
    if (ancHarm == 0 || ancExc == 0) {
        var enable = true;
        var harmonyVal = $('#harmony').val();
        var l = $('.excOpt:checked').length;

        if (ancHarm == 0 && ancExc == 0) {
            enable = (l == 0 && harmonyVal == '');
        }
        else if (ancHarm == 0) {
            enable = harmonyVal == '';
        }
        else if (ancExc == 0) {
            enable = l == 0;
        }

        if (enable) {
            $('#ancopt').prop('disabled', false);
            $('#ancopt').removeClass('disabled');
            $('#stamina').prop('disabled', false);
            $('#stamina').removeClass('disabled');
        }
        else {
            $('#ancopt').prop('disabled', true);
            $('#ancopt').addClass('disabled');
            $('#stamina').prop('disabled', true);
            $('#stamina').addClass('disabled');

            $('#ancopt').val('');
            setHarmonyVisibility();
            setStaminaOption('', '');
        }
    }
}
