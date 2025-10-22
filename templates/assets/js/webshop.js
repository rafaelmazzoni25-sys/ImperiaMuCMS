/**
 * Webshop JavaScript
 * Copyright (c) 2014 - 2019, ImperiaMuCMS
 * @author  jacubb
 */

function changeCurrency(newCurrency) {
    curr_currency = newCurrency;
    $("#payment-currency").val(curr_currency);

    recalcItemPrice();
    recalcOptionsPrice();
    recalcTotalPrice();
}

function changeAncient(newAnc) {
    var newOptions = '';
    if (newAnc == null || newAnc == '') {
        newOptions = '<option value="">' + empty_option + '</option>';
        $("select[name='item-stamina']").html(newOptions);
        $("select[name='item-stamina']").attr('disabled', 'disabled');

        if (enable_harmony == "1") {
            $("select[name='item-harmony']").parent().show();
            $("#harmony-line").show();
        }

        if ($("input[name='item-exc-1']").length > 0) {
            $("input[name='item-exc-1']").parent().show();
            $("#exc-line").show();
        }
        if ($("input[name='item-exc-2']").length > 0) {
            $("input[name='item-exc-2']").parent().show();
        }
        if ($("input[name='item-exc-3']").length > 0) {
            $("input[name='item-exc-3']").parent().show();
        }
        if ($("input[name='item-exc-4']").length > 0) {
            $("input[name='item-exc-4']").parent().show();
        }
        if ($("input[name='item-exc-5']").length > 0) {
            $("input[name='item-exc-5']").parent().show();
        }
        if ($("input[name='item-exc-6']").length > 0) {
            $("input[name='item-exc-6']").parent().show();
        }
    } else {
        newOptions = '<option value="5">+5</option>';
        newOptions += '<option value="10">+10</option>';
        $("select[name='item-stamina']").html(newOptions);
        $("select[name='item-stamina']").val(5);
        $("select[name='item-stamina']").removeAttr('disabled');

        if (enable_anc_harm == "0") {
            $("select[name='item-harmony']").val(null);
            $("select[name='item-harmony']").parent().hide();
            $("#harmony-line").hide();
        }

        if (enable_anc_exc == "0") {
            if ($("input[name='item-exc-1']").length > 0) {
                $("input[name='item-exc-1']").attr('checked', false);
                $("input[name='item-exc-1']").parent().hide();
                $("#exc-line").hide();
            }
            if ($("input[name='item-exc-2']").length > 0) {
                $("input[name='item-exc-2']").attr('checked', false);
                $("input[name='item-exc-2']").parent().hide();
            }
            if ($("input[name='item-exc-3']").length > 0) {
                $("input[name='item-exc-3']").attr('checked', false);
                $("input[name='item-exc-3']").parent().hide();
            }
            if ($("input[name='item-exc-4']").length > 0) {
                $("input[name='item-exc-4']").attr('checked', false);
                $("input[name='item-exc-4']").parent().hide();
            }
            if ($("input[name='item-exc-5']").length > 0) {
                $("input[name='item-exc-5']").attr('checked', false);
                $("input[name='item-exc-5']").parent().hide();
            }
            if ($("input[name='item-exc-6']").length > 0) {
                $("input[name='item-exc-6']").attr('checked', false);
                $("input[name='item-exc-6']").parent().hide();
            }
        }
    }
}

function changeSocket(id, val) {
    if (enable_same_socket == "0") {
        var socketIndex = 0;
        var socketIndexTmp = id.split("-");
        socketIndex = socketIndexTmp[2];
        var valTmp = val.split(":");
        var socket_seed = valTmp[2];

        if (socket_seed != "-1") {
            var soc = [];
            var socTmp = [];
            soc[1] = $("select[name='item-socket-1']").val();
            soc[2] = $("select[name='item-socket-2']").val();
            soc[3] = $("select[name='item-socket-3']").val();
            soc[4] = $("select[name='item-socket-4']").val();
            soc[5] = $("select[name='item-socket-5']").val();
            socTmp[1] = -999; socTmp[2] = -999; socTmp[3] = -999; socTmp[4] = -999; socTmp[5] = -999;

            if (soc[1] != null) {
                socTmp[1] = soc[1].split(":");
                socTmp[1] = socTmp[1][2];
            }
            if (soc[2] != null) {
                socTmp[2] = soc[2].split(":");
                socTmp[2] = socTmp[2][2];
            }
            if (soc[3] != null) {
                socTmp[3] = soc[3].split(":");
                socTmp[3] = socTmp[3][2];
            }
            if (soc[4] != null) {
                socTmp[4] = soc[4].split(":");
                socTmp[4] = socTmp[4][2];
            }
            if (soc[5] != null) {
                socTmp[5] = soc[5].split(":");
                socTmp[5] = socTmp[5][2];
            }

            if (socketIndex != "1") {
                $("#item-socket-1").find("option").each(function () {
                    if (this.value.length > 0) {
                        var thisOptVal = this.value.split(":");
                        if ((thisOptVal[2] == socTmp[2] || thisOptVal[2] == socTmp[3]
                            || thisOptVal[2] == socTmp[4] || thisOptVal[2] == socTmp[5])
                            && thisOptVal[2] != "-1") {
                            $(this).attr('disabled', 'disabled');
                        } else {
                            $(this).removeAttr('disabled');
                        }
                    }
                });
            }
            if (socketIndex != "2") {
                $("#item-socket-2").find("option").each(function () {
                    if (this.value.length > 0) {
                        var thisOptVal = this.value.split(":");
                        if ((thisOptVal[2] == socTmp[1] || thisOptVal[2] == socTmp[3]
                            || thisOptVal[2] == socTmp[4] || thisOptVal[2] == socTmp[5])
                            && thisOptVal[2] != "-1") {
                            $(this).attr('disabled', 'disabled');
                        } else {
                            $(this).removeAttr('disabled');
                        }
                    }
                });
            }
            if (socketIndex != "3") {
                $("#item-socket-3").find("option").each(function () {
                    if (this.value.length > 0) {
                        var thisOptVal = this.value.split(":");
                        if ((thisOptVal[2] == socTmp[1] || thisOptVal[2] == socTmp[2]
                            || thisOptVal[2] == socTmp[4] || thisOptVal[2] == socTmp[5])
                            && thisOptVal[2] != "-1") {
                            $(this).attr('disabled', 'disabled');
                        } else {
                            $(this).removeAttr('disabled');
                        }
                    }
                });
            }
            if (socketIndex != "4") {
                $("#item-socket-4").find("option").each(function () {
                    if (this.value.length > 0) {
                        var thisOptVal = this.value.split(":");
                        if ((thisOptVal[2] == socTmp[1] || thisOptVal[2] == socTmp[2]
                            || thisOptVal[2] == socTmp[3] || thisOptVal[2] == socTmp[5])
                            && thisOptVal[2] != "-1") {
                            $(this).attr('disabled', 'disabled');
                        } else {
                            $(this).removeAttr('disabled');
                        }
                    }
                });
            }
            if (socketIndex != "5") {
                $("#item-socket-5").find("option").each(function () {
                    if (this.value.length > 0) {
                        var thisOptVal = this.value.split(":");
                        if ((thisOptVal[2] == socTmp[1] || thisOptVal[2] == socTmp[2]
                            || thisOptVal[2] == socTmp[3] || thisOptVal[2] == socTmp[4])
                            && thisOptVal[2] != "-1") {
                            $(this).attr('disabled', 'disabled');
                        } else {
                            $(this).removeAttr('disabled');
                        }
                    }
                });
            }
        }
    }
}

function checkHarmony(currLvl) {
    if ($("select[name='item-harmony']").length > 0) {
        var harmOpts = $("select[name='item-harmony'] option");
        for (var i = 0; i < harmOpts.length; i++) {
            var opt = $(harmOpts[i]).val().split(":");
            if (parseInt(opt[3]) <= parseInt(currLvl)) {
                $(harmOpts[i]).removeAttr('disabled');
            } else {
                $(harmOpts[i]).attr('disabled', 'disabled');
                if ($("select[name='item-harmony'] option:selected").val() == $(harmOpts[i]).val()) {
                    $("select[name='item-harmony']").val(null);
                }
            }
        }
        /*if (currLvl > 0) {
            $("select[name='item-harmony']").removeAttr('disabled');
        } else {
            $("select[name='item-harmony']").attr('disabled', 'disabled');
            $("select[name='item-harmony']").val(null);
        }*/
    }
}

function changeGrade(id, val) {
    var gradeIndex = 0;
    var gradeIndexTmp = id.split("-");
    gradeIndex = gradeIndexTmp[2];

    var exc1 = $("select[name='item-exc-1']").val();
    var exc2 = $("select[name='item-exc-2']").val();
    var exc3 = $("select[name='item-exc-3']").val();
    var exc4 = $("select[name='item-exc-4']").val();
    var exc1Tmp, exc2Tmp, exc3Tmp, exc4Tmp;

    if (exc1 != null) {
        exc1Tmp = exc1.split(":");
        exc1Tmp = exc1Tmp[0];
    }
    if (exc2 != null) {
        exc2Tmp = exc2.split(":");
        exc2Tmp = exc2Tmp[0];
    }
    if (exc3 != null) {
        exc3Tmp = exc3.split(":");
        exc3Tmp = exc3Tmp[0];
    }
    if (exc4 != null) {
        exc4Tmp = exc4.split(":");
        exc4Tmp = exc4Tmp[0];
    }

    if (gradeIndex != "1") {
        $("#item-exc-1").find("option").each(function () {
            if (this.value.length > 0) {
                var thisOptVal = this.value.split(":");
                if (thisOptVal[0] == exc2Tmp || thisOptVal[0] == exc3Tmp || thisOptVal[0] == exc4Tmp) {
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).removeAttr('disabled');
                }
            }
        });
    }
    if (gradeIndex != "2") {
        $("#item-exc-2").find("option").each(function () {
            if (this.value.length > 0) {
                var thisOptVal = this.value.split(":");
                if (thisOptVal[0] == exc1Tmp || thisOptVal[0] == exc3Tmp || thisOptVal[0] == exc4Tmp) {
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).removeAttr('disabled');
                }
            }
        });
    }
    if (gradeIndex != "3") {
        $("#item-exc-3").find("option").each(function () {
            if (this.value.length > 0) {
                var thisOptVal = this.value.split(":");
                if (thisOptVal[0] == exc1Tmp || thisOptVal[0] == exc2Tmp || thisOptVal[0] == exc4Tmp) {
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).removeAttr('disabled');
                }
            }
        });
    }
    if (gradeIndex != "4") {
        $("#item-exc-4").find("option").each(function () {
            if (this.value.length > 0) {
                var thisOptVal = this.value.split(":");
                if (thisOptVal[0] == exc1Tmp || thisOptVal[0] == exc2Tmp || thisOptVal[0] == exc3Tmp) {
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).removeAttr('disabled');
                }
            }
        });
    }
}

function getCurrRatio(currCode) {
    if (currCode == "1") {
        return ratio_platinum;
    } else if (currCode == "2") {
        return ratio_gold;
    } else if (currCode == "3") {
        return ratio_silver;
    } else if (currCode == "11") {
        return ratio_wcoin;
    } else if (currCode == "13") {
        return ratio_gp;
    }
}

function recalcItemPrice() {
    var currRatio = getCurrRatio(curr_currency);
    var itemPrice = Math.floor(item_price * currRatio);
    $(".webshop-item-price").html(itemPrice);
}

function recalcOptionsPrice() {
    var currRatio = getCurrRatio(curr_currency);
    var optionsPrice = 0;

    // Level
    if ($("select[name='item-level']").length > 0) {
        var currLvl = parseInt($("select[name='item-level']").val());
        var currLvlPrice = currLvl * price_level;
        optionsPrice = optionsPrice + (currLvlPrice * currRatio);
    }

    // Life
    if ($("select[name='item-life']").length > 0) {
        var currLife = parseInt($("select[name='item-life']").val());
        var currLifePrice = currLife * price_life;
        optionsPrice = optionsPrice + (currLifePrice * currRatio);
    }

    // Luck
    if ($("input[name='item-luck']").length > 0) {
        var currLuckPrice = 0;
        if ($("input[name='item-luck']").prop('checked') == true) {
            currLuckPrice = price_luck * currRatio;
            optionsPrice = optionsPrice + currLuckPrice;
        }
    }

    // Skill
    if ($("input[name='item-skill']").length > 0) {
        var currSkillPrice = 0;
        if ($("input[name='item-skill']").prop('checked') == true) {
            currSkillPrice = price_skill * currRatio;
            optionsPrice = optionsPrice + currSkillPrice;
        }
    }

    // Excellent options
    if ($("input[name='item-exc-1']").length > 0) {
        var currExc1Price = 0;
        if ($("input[name='item-exc-1']").prop('checked') == true) {
            currExc1Price = exc1_price * currRatio;
            optionsPrice = optionsPrice + currExc1Price;
        }
    }
    if ($("input[name='item-exc-2']").length > 0) {
        var currExc2Price = 0;
        if ($("input[name='item-exc-2']").prop('checked') == true) {
            currExc2Price = exc2_price * currRatio;
            optionsPrice = optionsPrice + currExc2Price;
        }
    }
    if ($("input[name='item-exc-3']").length > 0) {
        var currExc3Price = 0;
        if ($("input[name='item-exc-3']").prop('checked') == true) {
            currExc3Price = exc3_price * currRatio;
            optionsPrice = optionsPrice + currExc3Price;
        }
    }
    if ($("input[name='item-exc-4']").length > 0) {
        var currExc4Price = 0;
        if ($("input[name='item-exc-4']").prop('checked') == true) {
            currExc4Price = exc4_price * currRatio;
            optionsPrice = optionsPrice + currExc4Price;
        }
    }
    if ($("input[name='item-exc-5']").length > 0) {
        var currExc5Price = 0;
        if ($("input[name='item-exc-5']").prop('checked') == true) {
            currExc5Price = exc5_price * currRatio;
            optionsPrice = optionsPrice + currExc5Price;
        }
    }
    if ($("input[name='item-exc-6']").length > 0) {
        var currExc6Price = 0;
        if ($("input[name='item-exc-6']").prop('checked') == true) {
            currExc6Price = exc6_price * currRatio;
            optionsPrice = optionsPrice + currExc6Price;
        }
    }

    // Ancient
    if ($("select[name='item-ancient']").length > 0) {
        var currAncient = $("select[name='item-ancient']").val();
        if (currAncient != null && currAncient != '' && currAncient != undefined) {
            var ancTier = currAncient.split(":");
            var currStamina = $("select[name='item-stamina']").val();

            var currAncPrice = 0;
            if (ancTier[1] == "1") {
                currAncPrice = anc1_price;
            } else if (ancTier[1] == "2") {
                currAncPrice = anc2_price;
            } else if (ancTier[1] == "3") {
                currAncPrice = anc3_price;
            } else if (ancTier[1] == "4") {
                currAncPrice = anc4_price;
            }

            optionsPrice = optionsPrice + (currAncPrice * currRatio);
            optionsPrice = optionsPrice + (currStamina * price_stamina * currRatio);
        }
    }

    // Harmony
    if ($("select[name='item-harmony']").length > 0) {
        var currHarmony = $("select[name='item-harmony']").val();
        if (currHarmony != null && currHarmony != '' && currHarmony != undefined) {
            var harmonyData = currHarmony.split(":");
            var currHarmonyPrice = 0;
            if (parseInt(harmonyData[2]) > 0) {
                currHarmonyPrice = parseInt(harmonyData[2]);
            }
            optionsPrice = optionsPrice + (currHarmonyPrice * currRatio);
        }
    }

    // 380 lvl
    if ($("input[name='item-380lvl']").length > 0) {
        var curr380lvlPrice = 0;
        if ($("input[name='item-380lvl']").prop('checked') == true) {
            curr380lvlPrice = price_380lvl * currRatio;
            optionsPrice = optionsPrice + curr380lvlPrice;
        }
    }

    // Sockets
    if ($("select[name='item-socket-1']").length > 0) {
        var currSocket1 = $("select[name='item-socket-1']").val();
        if (currSocket1 != null && currSocket1 != '' && currSocket1 != undefined) {
            var socket1Data = currSocket1.split(":");
            var currSocket1Price = 0;
            if (parseInt(socket1Data[3]) > 0) {
                currSocket1Price = parseInt(socket1Data[3]);
            }
            optionsPrice = optionsPrice + (currSocket1Price * currRatio);
        }
    }
    if ($("select[name='item-socket-2']").length > 0) {
        var currSocket2 = $("select[name='item-socket-2']").val();
        if (currSocket2 != null && currSocket2 != '' && currSocket2 != undefined) {
            var socket2Data = currSocket2.split(":");
            var currSocket2Price = 0;
            if (parseInt(socket2Data[3]) > 0) {
                currSocket2Price = parseInt(socket2Data[3]);
            }
            optionsPrice = optionsPrice + (currSocket2Price * currRatio);
        }
    }
    if ($("select[name='item-socket-3']").length > 0) {
        var currSocket3 = $("select[name='item-socket-3']").val();
        if (currSocket3 != null && currSocket3 != '' && currSocket3 != undefined) {
            var socket3Data = currSocket3.split(":");
            var currSocket3Price = 0;
            if (parseInt(socket3Data[3]) > 0) {
                currSocket3Price = parseInt(socket3Data[3]);
            }
            optionsPrice = optionsPrice + (currSocket3Price * currRatio);
        }
    }
    if ($("select[name='item-socket-4']").length > 0) {
        var currSocket4 = $("select[name='item-socket-4']").val();
        if (currSocket4 != null && currSocket4 != '' && currSocket4 != undefined) {
            var socket4Data = currSocket4.split(":");
            var currSocket4Price = 0;
            if (parseInt(socket4Data[3]) > 0) {
                currSocket4Price = parseInt(socket4Data[3]);
            }
            optionsPrice = optionsPrice + (currSocket4Price * currRatio);
        }
    }
    if ($("select[name='item-socket-5']").length > 0) {
        var currSocket5 = $("select[name='item-socket-5']").val();
        if (currSocket5 != null && currSocket5 != '' && currSocket5 != undefined) {
            var socket5Data = currSocket5.split(":");
            var currSocket5Price = 0;
            if (parseInt(socket5Data[3]) > 0) {
                currSocket5Price = parseInt(socket5Data[3]);
            }
            optionsPrice = optionsPrice + (currSocket5Price * currRatio);
        }
    }
    if ($("select[name='item-socket-bonus']").length > 0) {
        var currSocketBonus = $("select[name='item-socket-bonus']").val();
        if (currSocketBonus != null && currSocketBonus != '' && currSocketBonus != undefined) {
            var socketBonusData = currSocketBonus.split(":");
            var currSocketBonusPrice = 0;
            if (parseInt(socketBonusData[1]) > 0) {
                currSocketBonusPrice = parseInt(socketBonusData[1]);
            }
            optionsPrice = optionsPrice + (currSocketBonusPrice * currRatio);
        }
    }

    // 4th Wings
    if ($("select[name='item-exc-1']").length > 0) {
        var currExc1 = $("select[name='item-exc-1']").val();
        if (currExc1 != null && currExc1 != '' && currExc1 != undefined) {
            var exc1Data = currExc1.split(":");
            var currExc1Price = 0;
            if (parseInt(exc1Data[2]) > 0) {
                currExc1Price = parseInt(exc1Data[2]);
            }
            optionsPrice = optionsPrice + (currExc1Price * currRatio) + (parseInt(exc1Data[1]) * parseInt(price_exc_opt_wings_4th_grade) * currRatio);
        }
    }
    if ($("select[name='item-exc-2']").length > 0) {
        var currExc2 = $("select[name='item-exc-2']").val();
        if (currExc2 != null && currExc2 != '' && currExc2 != undefined) {
             var exc2Data = currExc2.split(":");
             var currExc2Price = 0;
             if (parseInt(exc2Data[2]) > 0) {
                 currExc2Price = parseInt(exc2Data[2]);
             }
             optionsPrice = optionsPrice + (currExc2Price * currRatio) + (parseInt(exc2Data[1]) * parseInt(price_exc_opt_wings_4th_grade) * currRatio);
        }
    }
    if ($("select[name='item-exc-3']").length > 0) {
        var currExc3 = $("select[name='item-exc-3']").val();
        if (currExc3 != null && currExc3 != '' && currExc3 != undefined) {
            var exc3Data = currExc3.split(":");
            var currExc3Price = 0;
            if (parseInt(exc3Data[2]) > 0) {
                currExc3Price = parseInt(exc3Data[2]);
            }
            optionsPrice = optionsPrice + (currExc3Price * currRatio) + (parseInt(exc3Data[1]) * parseInt(price_exc_opt_wings_4th_grade) * currRatio);
        }
    }
    if ($("select[name='item-exc-4']").length > 0) {
        var currExc4 = $("select[name='item-exc-4']").val();
        if (currExc4 != null && currExc4 != '' && currExc4 != undefined) {
            var exc4Data = currExc4.split(":");
            var currExc4Price = 0;
            if (parseInt(exc4Data[2]) > 0) {
                currExc4Price = parseInt(exc4Data[2]);
            }
            optionsPrice = optionsPrice + (currExc4Price * currRatio) + (parseInt(exc4Data[1]) * parseInt(price_exc_opt_wings_4th_grade) * currRatio);
        }
    }
    if ($("select[name='item-pentagram-main']").length > 0) {
        var currPentMain = $("select[name='item-pentagram-main']").val();
        if (currPentMain != null && currPentMain != '' && currPentMain != undefined) {
            var pentMainData = currPentMain.split(":");
            var currPentMainPrice = 0;
            if (parseInt(pentMainData[2]) > 0) {
                currPentMainPrice = parseInt(pentMainData[2]);
            }
            optionsPrice = optionsPrice + (currPentMainPrice * currRatio) + (parseInt(pentMainData[1]) * parseInt(price_pent_main_wings_4th_lvl) * currRatio);
        }
    }
    if ($("select[name='item-pentagram-add']").length > 0) {
        var currPentAdd = $("select[name='item-pentagram-add']").val();
        if (currPentAdd != null && currPentAdd != '' && currPentAdd != undefined) {
            var pentAddData = currPentAdd.split(":");
            var currPentAddPrice = 0;
            if (parseInt(pentAddData[2]) > 0) {
                currPentAddPrice = parseInt(pentAddData[2]);
            }
            optionsPrice = optionsPrice + (currPentAddPrice * currRatio) + (parseInt(pentAddData[1]) * parseInt(price_pent_add_wings_4th_lvl) * currRatio);
        }
    }

    // Pentagrams
    if ($("select[name='element']").length > 0) {
        var currElement = $("select[name='element']").val();
        if (currElement != null && currElement != '' && currElement != undefined) {
            var elementData = currElement.split(":");
            var currElementPrice = 0;
            if (parseInt(elementData[1]) > 0) {
                currElementPrice = parseInt(elementData[1]);
            }
            optionsPrice = optionsPrice + (currElementPrice * currRatio);
        }
    }
    for (var angerIndex = 1; angerIndex <= 5; angerIndex++) {
        var currName = 'anger' + angerIndex;
        if ($("select[name=" + currName + "]").length > 0) {
            var currElement = $("select[name=" + currName + "]").val();
            if (currElement != null && currElement != '' && currElement != undefined) {
                var elementData = currElement.split(":");
                var currElementPrice = 0;
                var currElementPriceLvl = 0;
                var currElementLvl = 0;
                if (parseInt(elementData[2]) > 0) {
                    currElementLvl = parseInt(elementData[2]);
                }
                if (parseInt(elementData[1]) > 0) {
                    currElementPrice = parseInt(elementData[1]);
                }
                if (parseInt(elementData[3]) > 0) {
                    currElementPriceLvl = parseInt(elementData[3]);
                }
                optionsPrice = optionsPrice + (currElementPrice * currRatio) + (currElementLvl * currElementPriceLvl * currRatio);
            }
        }
    }
    for (var blessingIndex = 1; blessingIndex <= 5; blessingIndex++) {
        var currName = 'blessing' + blessingIndex;
        if ($("select[name=" + currName + "]").length > 0) {
            var currElement = $("select[name=" + currName + "]").val();
            if (currElement != null && currElement != '' && currElement != undefined) {
                var elementData = currElement.split(":");
                var currElementPrice = 0;
                var currElementPriceLvl = 0;
                var currElementLvl = 0;
                if (parseInt(elementData[2]) > 0) {
                    currElementLvl = parseInt(elementData[2]);
                }
                if (parseInt(elementData[1]) > 0) {
                    currElementPrice = parseInt(elementData[1]);
                }
                if (parseInt(elementData[3]) > 0) {
                    currElementPriceLvl = parseInt(elementData[3]);
                }
                optionsPrice = optionsPrice + (currElementPrice * currRatio) + (currElementLvl * currElementPriceLvl * currRatio);
            }
        }
    }
    for (var integrityIndex = 1; integrityIndex <= 5; integrityIndex++) {
        var currName = 'integrity' + integrityIndex;
        if ($("select[name=" + currName + "]").length > 0) {
            var currElement = $("select[name=" + currName + "]").val();
            if (currElement != null && currElement != '' && currElement != undefined) {
                var elementData = currElement.split(":");
                var currElementPrice = 0;
                var currElementPriceLvl = 0;
                var currElementLvl = 0;
                if (parseInt(elementData[2]) > 0) {
                    currElementLvl = parseInt(elementData[2]);
                }
                if (parseInt(elementData[1]) > 0) {
                    currElementPrice = parseInt(elementData[1]);
                }
                if (parseInt(elementData[3]) > 0) {
                    currElementPriceLvl = parseInt(elementData[3]);
                }
                optionsPrice = optionsPrice + (currElementPrice * currRatio) + (currElementLvl * currElementPriceLvl * currRatio);
            }
        }
    }
    for (var divinityIndex = 1; divinityIndex <= 5; divinityIndex++) {
        var currName = 'divinity' + divinityIndex;
        if ($("select[name=" + currName + "]").length > 0) {
            var currElement = $("select[name=" + currName + "]").val();
            if (currElement != null && currElement != '' && currElement != undefined) {
                var elementData = currElement.split(":");
                var currElementPrice = 0;
                var currElementPriceLvl = 0;
                var currElementLvl = 0;
                if (parseInt(elementData[2]) > 0) {
                    currElementLvl = parseInt(elementData[2]);
                }
                if (parseInt(elementData[1]) > 0) {
                    currElementPrice = parseInt(elementData[1]);
                }
                if (parseInt(elementData[3]) > 0) {
                    currElementPriceLvl = parseInt(elementData[3]);
                }
                optionsPrice = optionsPrice + (currElementPrice * currRatio) + (currElementLvl * currElementPriceLvl * currRatio);
            }
        }
    }
    for (var galeIndex = 1; galeIndex <= 5; galeIndex++) {
        var currName = 'gale' + galeIndex;
        if ($("select[name=" + currName + "]").length > 0) {
            var currElement = $("select[name=" + currName + "]").val();
            if (currElement != null && currElement != '' && currElement != undefined) {
                var elementData = currElement.split(":");
                var currElementPrice = 0;
                var currElementPriceLvl = 0;
                var currElementLvl = 0;
                if (parseInt(elementData[2]) > 0) {
                    currElementLvl = parseInt(elementData[2]);
                }
                if (parseInt(elementData[1]) > 0) {
                    currElementPrice = parseInt(elementData[1]);
                }
                if (parseInt(elementData[3]) > 0) {
                    currElementPriceLvl = parseInt(elementData[3]);
                }
                optionsPrice = optionsPrice + (currElementPrice * currRatio) + (currElementLvl * currElementPriceLvl * currRatio);
            }
        }
    }

    optionsPrice = Math.floor(optionsPrice);
    $(".webshop-options-price").html(optionsPrice);
}

function recalcTotalPrice() {
    var itemPrice = parseInt($(".webshop-item-price").html());
    var optionsPrice = parseInt($(".webshop-options-price").html());
    var totalPrice = Math.floor(itemPrice + optionsPrice);
    if (global_discount > 0) {
        totalPrice = totalPrice - Math.floor(totalPrice * (global_discount / 100));
        $(".webshop-total-price").html(totalPrice + '&nbsp;<sup class="webshop-item-on-sale">-' + global_discount + '%</sup>');
    } else {
        $(".webshop-total-price").html(totalPrice);
    }
}