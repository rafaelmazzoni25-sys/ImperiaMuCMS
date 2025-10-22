/************************************************************************
cntnt : 카테고리 선택(검색부분 Selectbox) 
param : ctgySeq -> 카테고리 번호 
*************************************************************************/
function fnCategorySelect(ctgySeq)
{
    $("#srchCategory").val(ctgySeq);
}

/************************************************************************
cntnt : 검색창에서 엔터클릭시
param : ev -> 이벤트
*************************************************************************/
function fnSrchEnter(ev)
{
    var evCode = (window.netscape) ? ev.which : event.keyCode;
    if (evCode == 13) {
        fnItemSearch();
    }
}

/************************************************************************
cntnt : 검색창에서 아이템검색시
*************************************************************************/
function fnItemSearch()
{
    var url = "/webshop/shop/";
    var str = encodeURIComponent($.trim($("#q").val()));
    var type = $("#srchCategory").val();
    
    if (str.length < 2)
    {
        alert(Message.A009);
        return;
    }

    if (str != "") {
        url += "?q=" + str;
    }
    
    if (type != "") {
        if (url.indexOf('?') > 0) {
            url += "&srchCtgy=" + type;
        }
        else {
            url += "?srchCtgy=" + type;
        }
    }

    document.location.href = url;    
}

/************************************************************************
cntnt : shop 리스트에서 정렬시
*************************************************************************/
function fnItemSort() {
    var url = "/webshop/shop/";
    var str = encodeURIComponent($.trim($("#q").val()));
    var type = $("#srchCategory").val();
    var orderType = $("#orderType option:selected").val();

    if (str != "") {
        url += "?q=" + str;
    }

    if (type != "") {
        if (url.indexOf('?') > 0) {
            url += "&srchCtgy=" + type;
        }
        else {
            url += "?srchCtgy=" + type;
        }
    }
    
    if (orderType != "") {
        if (url.indexOf('?') > 0) {
            url += "&orderType=" + orderType;
        } else {
            var arr = window.location.href.split('?');
            url = arr[0] + "?orderType=" + orderType;
        }
    }
    
    document.location.href = url;
}

/************************************************************************
cntnt : 사용자지정아이템, 프리미엄 레이어에서 전체 활성화 또는 비활성화 
param : type -> t:비활성화, f:활성화 
*************************************************************************/
function fnAllDisabled(type) {
    if (type == "t") {
        type = true;
        $("small").addClass("disabled");
    }
    else {
        type = false;
        $("small").removeClass("disabled");
    }
    $(".itemsel input").attr("disabled", type);
    $(".itemsel select").attr("disabled", type);
    $(".choice_itemsel li a").attr("onclick", "").unbind("click");
}

/************************************************************************
cntnt : 사용자지정아이템 레이어에서 아이템선택한 것 리셋 
*************************************************************************/
function fnItemReset() {
    var depth_info = $("select[id='dOption4']").val();
    if (depth_info === undefined) { // undefined 의 경우 타입까지 구분해야함 
    }
    else {
        if ((depth_info != "") && (depth_info != "undefined")) {
            $("select[id='dOption4']").val("");
        }
    }

    if (fnOptionExist('gpDExist')) {
        $("input[name='cbdOption']").attr("checked", false);
    }
    if (fnOptionExist('gpPExcellentExist')) {
        $("input[name='cbpOption']").attr("disabled", false).attr("checked", false);
        
    }
    if (fnOptionExist('gpPSocketExist')) {
        $("input[name='cbpOptionSocket']").attr("disabled", true).attr("checked", false);
        $("select[name='sbpOptionSocket']").val("").attr("disabled", true);
        $("input[name='cbpOptionSocket']:eq(0)").attr("disabled", false);
        $("input[name='cbpOptionSocket']:eq(0)").attr("disabled", false);
        var obj = $("select[name='sbpOptionSocket']");
        $(obj[0]).val("").attr("disabled", false);
        
    }
    if (fnOptionExist('gpP380Exist')) {
        $("input[name='cbpOption380']").attr("disabled", false).attr("checked", false);
    }
    if (fnOptionExist('gpPHarmonyExist')) {
        $("#pOptionHarmony").val("").attr("disabled", false);
    }

    $("#multi").hide();

    $(".itemsel .opt_wp .opt_prt").css("display", "none");
    $("small").removeClass("disabled");
    $("#Bit").val("0");

    $("#Level").val("");
    $("#Skill").val("");
    $("#Lucky").val("");
    $("#Option").val("");
    $("#ExcellentOption1").val("");
    $("#ExcellentOption2").val("");
    $("#ExcellentOption3").val("");
    $("#ExcellentOption4").val("");
    $("#ExcellentOption5").val("");
    $("#ExcellentOption6").val("");
    $("#JewelHarmonyOption").val("");
    $("#Lv380Option").val("");

    $("#Socket1Option").val("");
    $("#Socket2Option").val("");
    $("#Socket3Option").val("");
    $("#Socket4Option").val("");
    $("#Socket5Option").val("");

    fnNormalPriceCalc();
}

/************************************************************************
cntnt : 체크박스 선택한것이 있는지 여부 (선택한거 있으면 true, 없으면 false
param : trgt -> 확인하고자 하는 대상의 name
*************************************************************************/
function getCheckboxCheckYN(trgt) {
    var len = $("input:checkbox[name='" + trgt + "']:checked").length;
    if (len <= 0) {
        return false;
    }
    else {
        return true;
    }
}

/************************************************************************
cntnt : 금액표시 세자리마다 콤마(,) 표시 
param : number -> 표현하고자 하는 숫자 
*************************************************************************/
function fnSetComma(number) {
    var nArr = String(number).split('').join(',').split('');
    for (var i = nArr.length - 1, j = 1; i >= 0; i--, j++) {
        if (j % 6 != 0 && j % 2 == 0) {
            nArr[i] = '';
        }
    }
    return nArr.join('');
}



/************************************************************************
cntnt : 사용자지정아이템 레이어에서 아이템 체크시 계산값 반환 
*************************************************************************/
function fnNormalPriceCalc() {
    var coinType = $("#coinType").val().toUpperCase();
    var dPrice = $("#dPriceCoin" + coinType).text().replace(",", "");
    var optPrice = 0;
    var obj = $(".itemsel .opt_wp .opt_prt:visible");
    obj.each(function (i) {
        //var price = $(this).html();
        var price = $(this).text();
        //var price = obj[i].innerText;
        price = price.replace("+", "").replace(",", "");
        optPrice += Number(price);
    });

    if (coinType == "F") {
        var checkCnt = 0;
        if (fnOptionExist('gpPExcellentExist')) {
            if (getCheckboxCheckYN('cbpOption')) {
                checkCnt++;
            }
        }
        if (fnOptionExist('gpPSocketExist')) {
            if (getCheckboxCheckYN('cbpOptionSocket')) {
                checkCnt++;
            }
        }
        if (fnOptionExist('gpP380Exist')) {
            if (getCheckboxCheckYN('cbpOption380')) {
                checkCnt++;
            }
        }
        if (fnOptionExist('gpPHarmonyExist')) {
            if ($("#pOptionHarmony option:selected").val() != "") {
                checkCnt++;
            }
        }
        
        if (checkCnt >= 2) {
            $("#multi").show();
            $("#dPriceCoin" + coinType).text(Number(dPrice));
            $("#optPriceCoin" + coinType).text(Number(optPrice));
            $("#totPriceCoin" + coinType).text((Number(dPrice) + Number(optPrice)) * 10);
        }
        else {
            $("#multi").hide();
            $("#dPriceCoin" + coinType).text(Number(dPrice));
            $("#optPriceCoin" + coinType).text(Number(optPrice));
            $("#totPriceCoin" + coinType).text(Number(dPrice) + Number(optPrice));
        }
    }
    else {
        $("#dPriceCoin" + coinType).text(Number(dPrice));
        $("#optPriceCoin" + coinType).text(Number(optPrice));
        $("#totPriceCoin" + coinType).text(Number(dPrice) + Number(optPrice));
    }
}

/************************************************************************
cntnt : 패키지아이템 레이어에서 아이템 체크시 계산값 반환 
*************************************************************************/
function fnPackagePriceCalc() {
    var totPrice = $("#totPriceCoin").text().replace(",", "");
    $("#totPriceCoin").text(Number(totPrice));
}

/************************************************************************
cntnt : 사용자지정아이템 레이어에서 체크박스 체크시 해당 부분 가격 보여주는 함수
param : trgt -> 확인하고자 하는 대상의 id
*************************************************************************/
function fnCbPriceControl(trgt) {
    var coinType = $("#coinType").val();
    if ($("#" + trgt).is(":checked")) {
        switch (coinType) {
            case "c": $("#" + trgt + "CoinC").show(); $("#" + trgt + "CoinP").hide(); $("#" + trgt + "CoinF").hide(); break;
            case "p": $("#" + trgt + "CoinC").hide(); $("#" + trgt + "CoinP").show(); $("#" + trgt + "CoinF").hide(); break;
            case "f": $("#" + trgt + "CoinC").hide(); $("#" + trgt + "CoinP").hide(); $("#" + trgt + "CoinF").show(); break;
        }
    }
    else {
        $("#" + trgt + "CoinC").hide();
        $("#" + trgt + "CoinP").hide();
        $("#" + trgt + "CoinF").hide();
    }
}

/************************************************************************
cntnt : 사용자지정아이템 레이어에서 셀렉트박스 체크시 해당 부분 가격 보여주는 함수
param : trgt -> 확인하고자 하는 대상의 id
*************************************************************************/
function fnSbPriceControl(trgt) {
    if ($("#" + trgt + " option").index($("#" + trgt + " option:selected")) > 0) {
        var coinType = $("#coinType").val();
        switch (coinType) {
            case "c": $("#" + trgt + "CoinC").show(); $("#" + trgt + "CoinP").hide(); $("#" + trgt + "CoinF").hide(); break;
            case "p": $("#" + trgt + "CoinC").hide(); $("#" + trgt + "CoinP").show(); $("#" + trgt + "CoinF").hide(); break;
            case "f": $("#" + trgt + "CoinC").hide(); $("#" + trgt + "CoinP").hide(); $("#" + trgt + "CoinF").show(); break;
        }
    }
    else {
        $("#" + trgt + "CoinC").hide();
        $("#" + trgt + "CoinP").hide();
        $("#" + trgt + "CoinF").hide();
    }
}

/************************************************************************
cntnt : 사용자지정아이템 레이어에서 해당 그룹의 존재여부 확인 
param : trgt -> 확인하고자 하는 대상의 id
*************************************************************************/
function fnOptionExist(trgt) {
    if ($("#" + trgt).val() == "y")
        return true;
    else
        return false;
}

/************************************************************************
cntnt : 사용자지정아이템 레이어에서 기본그룹 체크 시 
param : trgt -> 확인하고자 하는 대상의 id
*************************************************************************/
function fnDGroup(trgt) {
    if ($("#" + trgt).attr("type") == "checkbox") {
        fnCbPriceControl(trgt);
    }
    else {
        fnSbPriceControl(trgt);
    }
    
    fnNormalPriceCalc();
}

/************************************************************************
cntnt : 사용자지정아이템 레이어에서 고급그룹(엑설런트) 체크 시 
param : trgt -> 확인하고자 하는 대상의 id
*************************************************************************/
function fnPGroupExcellent(trgt) {
    //if ($("#coinType").val() == "c") {
    //    if (getCheckboxCheckYN('cbpOption')) {
    //        if (fnOptionExist('gpPSocketExist')) {
    //            $("input[name='cbpOptionSocket']").attr("disabled", true).attr("checked", false);
    //            $("input[name='cbpOptionSocket']").siblings("small").addClass("disabled");
    //            $("select[name='sbpOptionSocket']").attr("disabled", true);
    //        }
    //        if (fnOptionExist('gpP380Exist')) {
    //            $("input[name='cbpOption380']").attr("disabled", true).attr("checked", false);
    //            $("input[name='cbpOption380']").siblings("small").addClass("disabled");
    //        }
    //        if (fnOptionExist('gpPHarmonyExist')) {
    //            var obj = $("select[name='sbpOptionHarmony']");
    //            $(obj[0]).attr("disabled", true);
    //            $(obj).siblings("small").addClass("disabled");
    //        }
    //    }
    //    else {
    //        if (fnOptionExist('gpPSocketExist')) {
    //            $("input[name='cbpOptionSocket']:eq(0)").attr("disabled", false);
    //            $("input[name='cbpOptionSocket']").siblings("small").removeClass("disabled");
    //            var obj = $("select[name='sbpOptionSocket']");
    //            $(obj[0]).attr("disabled", false);
    //        }
    //        if (fnOptionExist('gpP380Exist')) {
    //            $("input[name='cbpOption380']").attr("disabled", false);
    //            $("input[name='cbpOption380']").siblings("small").removeClass("disabled");
    //        }
    //        if (fnOptionExist('gpPHarmonyExist')) {
    //            var obj = $("select[name='sbpOptionHarmony']");
    //            $(obj[0]).attr("disabled", false);
    //            $(obj).siblings("small").removeClass("disabled");
    //        }
    //    }
    //}
    
    fnCbPriceControl(trgt);
    fnNormalPriceCalc();
}

/************************************************************************
cntnt : 사용자지정아이템 레이어에서 고급그룹(소켓부분) 체크 시 
param : trgt -> 확인하고자 하는 대상의 id
*************************************************************************/
function fnPGroupSocket(trgt) {
    var cbObj = $("input[name='cbpOptionSocket']");
    var sbObj = $("select[name='sbpOptionSocket']");

    if (getCheckboxCheckYN('cbpOptionSocket')) {
        cbObj.each(function (i) {
            if (i < cbObj.length - 1) {
                if ($(cbObj[i]).is(":checked")) {
                    $(cbObj[i + 1]).attr("disabled", false);
                    $(cbObj[i + 1].id).siblings("small").removeClass("disabled");
                    $(sbObj[i + 1]).attr("disabled", false);
                }
                else {
                    $(cbObj[i + 1]).attr("disabled", true).attr("checked", false);
                    $(cbObj[i + 1].id).siblings("small").addClass("disabled");
                    $(sbObj[i + 1]).val("").attr("disabled", true);
                }
            }

            if (!$(cbObj[i]).is(":checked")) {
                $("#Socket" + (i + 1) + "Option").val("");
            }
            
            fnCbPriceControl(cbObj[i].id);
        });
        
    }
    else {
        cbObj.each(function (i) {
            if (i < cbObj.length - 1) {
                $(cbObj[i + 1]).attr("disabled", true).attr("checked", false);
                $(cbObj[i + 1].id).siblings("small").addClass("disabled");
                $(sbObj[i + 1]).val("").attr("disabled", true);
            }

            if (!$(cbObj[i]).is(":checked")) {
                $("#Socket" + (i + 1) + "Option").val("");
            }
           
            fnCbPriceControl(cbObj[i].id);
        });
    }

    //if ($("#coinType").val() == "c") {
    //    if (getCheckboxCheckYN('cbpOptionSocket')) {
    //        if (fnOptionExist('gpPExcellentExist')) {
    //            $("input[name='cbpOption']").attr("disabled", true).attr("checked", false);
    //            $("input[name='cbpOption']").siblings("small").addClass("disabled");
    //        }
    //        if (fnOptionExist('gpP380Exist')) {
    //            $("input[name='cbpOption380']").attr("disabled", true).attr("checked", false);
    //            $("input[name='cbpOption380']").siblings("small").addClass("disabled");
    //        }
    //        if (fnOptionExist('gpPHarmonyExist')) {
    //            var obj = $("select[name='sbpOptionHarmony']");
    //            $(obj[0]).attr("disabled", true);
    //            $(obj).siblings("small").addClass("disabled");
    //        }
    //    }
    //    else {
    //        if (fnOptionExist('gpPExcellentExist')) {
    //            $("input[name='cbpOption']").attr("disabled", false);
    //            $("input[name='cbpOption']").siblings("small").removeClass("disabled");
    //        }
    //        if (fnOptionExist('gpP380Exist')) {
    //            $("input[name='cbpOption380']").attr("disabled", false);
    //            $("input[name='cbpOption380']").siblings("small").removeClass("disabled");
    //        }
    //        if (fnOptionExist('gpPHarmonyExist')) {
    //            var obj = $("select[name='sbpOptionHarmony']");
    //            $(obj[0]).attr("disabled", false);
    //            $(obj).siblings("small").removeClass("disabled");
    //        }
    //    }
    //}

    fnNormalPriceCalc();
}

/************************************************************************
cntnt : 사용자지정아이템 레이어에서 고급그룹(380부분) 체크 시 
param : trgt -> 확인하고자 하는 대상의 id
*************************************************************************/
function fnPGroup380(trgt) {
    //if ($("#coinType").val() == "c") {
    //    if (getCheckboxCheckYN('cbpOption380')) {
    //        if (fnOptionExist('gpPExcellentExist')) {
    //            $("input[name='cbpOption']").attr("disabled", true).attr("checked", false);
    //            $("input[name='cbpOption']").siblings("small").addClass("disabled");
    //        }
    //        if (fnOptionExist('gpPSocketExist')) {
    //            $("input[name='cbpOptionSocket']").attr("disabled", true).attr("checked", false);
    //            $("input[name='cbpOptionSocket']").siblings("small").addClass("disabled");
    //            $("select[name='sbpOptionSocket']").attr("disabled", true);
    //        }
    //        if (fnOptionExist('gpPHarmonyExist')) {
    //            var obj = $("select[name='sbpOptionHarmony']");
    //            $(obj[0]).attr("disabled", true);
    //            $(obj).siblings("small").addClass("disabled");
    //        }
    //    }
    //    else {
    //        if (fnOptionExist('gpPExcellentExist')) {
    //            $("input[name='cbpOption']").attr("disabled", false);
    //            $("input[name='cbpOption']").siblings("small").removeClass("disabled");
    //        }
    //        if (fnOptionExist('gpPSocketExist')) {
    //            $("input[name='cbpOptionSocket']:eq(0)").attr("disabled", false);
    //            $("input[name='cbpOptionSocket']:eq(0)").siblings("small").removeClass("disabled");
    //            var obj = $("select[name='sbpOptionSocket']");
    //            $(obj[0]).attr("disabled", false);
    //        }
    //        if (fnOptionExist('gpPHarmonyExist')) {
    //            var obj = $("select[name='sbpOptionHarmony']");
    //            $(obj[0]).attr("disabled", false);
    //            $(obj).siblings("small").removeClass("disabled");
    //        }
    //    }
    //}
    
    fnCbPriceControl(trgt);
    fnNormalPriceCalc();
}

/************************************************************************
cntnt : 사용자지정아이템 레이어에서 고급그룹(하모니 부분) 체크 시 
param : trgt -> 확인하고자 하는 대상의 id
*************************************************************************/
function fnPGroupHarmony(trgt) {
    //if ($("#coinType").val() == "c") {
    //    var index = $("select[name='sbpOptionHarmony'] option").index($("select[name='sbpOptionHarmony'] option:selected"));
    //    if (index > 0) {
    //        if (fnOptionExist('gpPExcellentExist')) {
    //            $("input[name='cbpOption']").attr("disabled", true).attr("checked", false);
    //            $("input[name='cbpOption']").siblings("small").addClass("disabled");
    //        }
    //        if (fnOptionExist('gpPSocketExist')) {
    //            $("input[name='cbpOptionSocket']").attr("disabled", true).attr("checked", false);
    //            $("input[name='cbpOptionSocket']").siblings("small").addClass("disabled");
    //            $("select[name='sbpOptionSocket']").attr("disabled", true);
    //        }
    //        if (fnOptionExist('gpP380Exist')) {
    //            $("input[name='cbpOption380']").attr("disabled", true);
    //            $("input[name='cbpOption380']").siblings("small").addClass("disabled");
    //        }
    //    }
    //    else {
    //        if (fnOptionExist('gpPExcellentExist')) {
    //            $("input[name='cbpOption']").attr("disabled", false);
    //            $("input[name='cbpOption']").siblings("small").removeClass("disabled");
    //        }
    //        if (fnOptionExist('gpPSocketExist')) {
    //            $("input[name='cbpOptionSocket']:eq(0)").attr("disabled", false);
    //            $("input[name='cbpOptionSocket']:eq(0)").siblings("small").removeClass("disabled");
    //            var obj = $("select[name='sbpOptionSocket']");
    //            $(obj[0]).attr("disabled", false);
    //        }
    //        if (fnOptionExist('gpP380Exist')) {
    //            $("input[name='cbpOption380']").attr("disabled", false);
    //            $("input[name='cbpOption380']").siblings("small").removeClass("disabled");
    //        }
    //    }
    //}
    
    fnSbPriceControl(trgt);
    fnNormalPriceCalc();
}

/************************************************************************
cntnt : 텝메뉴 캐쉬타입 변경시 
param : type -> 캐쉬타입 (c, p, f)
*************************************************************************/
function fnTabCoinType(type) {
    $(".choice_itemsel > li > a").removeClass("on");
    $("#coinType").val(type);
    var itemType = $("#itemType").val();
    var classNm = "coin_c";
    switch (type) {
        case "c": $(".choice_itemsel .coin_c > a").addClass("on");
            if (itemType == 6) {
                $("#dPriceCoinC").show(); $("#optPriceCoinC").show();
                $("#dPriceCoinP").hide(); $("#optPriceCoinP").hide();
                $("#dPriceCoinF").hide(); $("#optPriceCoinF").hide();
            }
            $("#totPriceCoinC").show();
            $("#totPriceCoinP").hide();
            $("#totPriceCoinF").hide();
            break;
        case "p": $(".choice_itemsel .coin_p > a").addClass("on"); classNm = "coin_p";
            if (itemType == 6) {
                $("#dPriceCoinC").hide(); $("#optPriceCoinC").hide(); 
                $("#dPriceCoinP").show(); $("#optPriceCoinP").show(); 
                $("#dPriceCoinF").hide(); $("#optPriceCoinF").hide();
            }
            $("#totPriceCoinC").hide();
            $("#totPriceCoinP").show();
            $("#totPriceCoinF").hide();
            break;
        case "f": $(".choice_itemsel .coin_free > a").addClass("on"); classNm = "coin_free";
            if (itemType == 6) {
                $("#dPriceCoinC").hide(); $("#optPriceCoinC").hide(); 
                $("#dPriceCoinP").hide(); $("#optPriceCoinP").hide(); 
                $("#dPriceCoinF").show(); $("#optPriceCoinF").show(); 
            }
            $("#totPriceCoinC").hide();
            $("#totPriceCoinP").hide();
            $("#totPriceCoinF").show();
            break;
        default: $(".choice_itemsel .coin_c > a").addClass("on");
            if (itemType == 6) {
                $("#dPriceCoinC").show(); $("#optPriceCoinC").show();
                $("#dPriceCoinP").hide(); $("#optPriceCoinP").hide();
                $("#dPriceCoinF").hide(); $("#optPriceCoinF").hide();
            }
            $("#totPriceCoinC").show();
            $("#totPriceCoinP").hide();
            $("#totPriceCoinF").hide();
            break;
    }
    /*
    if (type == "c" && itemType == 6) {
        $("#coin_c_msg").show();
    }
    else {
        $("#coin_c_msg").hide();
    }*/

    $(".item_buy_wp dl").attr("class", classNm);

    if (type == "f") {
        $(".item_buy_wp dl span").html("Free Credit");
    }
    else {
        $(".item_buy_wp dl span").html("Wcoin");
    }

    if (itemType == 6) {
        fnItemReset();
    }
}

/************************************************************************
cntnt : 상품타입에 따른 레이어 타입 반환 
param : itemType -> 아이템타입 (1~6)
*************************************************************************/
function fnLayerType(itemType)
{
    var url = "";
    switch (itemType)
    {
        case "1": url = "/webshop/shop/NormalItemLayer"; break;  // 단일
        case "2": url = "/webshop/shop/PackageItemLayer"; break; // 패키지
        case "3": url = "/webshop/shop/PremiumItemLayer"; break; // 프리미엄
        case "5": url = "/webshop/shop/LotteryItemLayer"; break; // 복권
        case "6": url = "/webshop/shop/NormalItemLayer"; break;  // 단일사용자지정
        default: url = "/webshop/shop/NormalItemLayer"; break;
    }
    return url;
}

/************************************************************************
cntnt : 상품 구입시 (buy, gift)
param : buyType -> 구매타입 (buy, gift)
        trgt -> 레이어 표시 대상 id
        itemNo -> 아이템번호
        itemType -> 아이템타입 
        cnt -> 레이어 위치 cnt
*************************************************************************/
function fnItemLayer(buyType, trgt, itemNo, itemType) { 
    $(".layerAreaItem").html("");
   
    $("#layerName").val(trgt);
    $.ajax({
        type: "POST",
        data: {
            itemNo: itemNo,
            buyType: buyType,
            itemType: itemType
        },
        url: fnLayerType(itemType),
        dataType: "html",
        //cache: false,
        success: function (html) {
            $("#" + trgt).html("").html(html);
        },
        error: function (em) {
            alert("Error Mu-R");
        }
    });
}

/************************************************************************
cntnt : 복권아이템 구매 후, 3초간 이미지 보여주는 함수 
param : type -> s:이미지 보여줌, h: 안보여줌
*************************************************************************/
function fnLottryImg(type)
{
    if (type == "h") {
        $("#partPrice").hide();
        $("#lotteryImg").show();
    }
    else {
        $("#partPrice").show();
        $("#lotteryImg").hide();
    }
}

/************************************************************************
cntnt : 상품구매 레이어에서 Buy 클릭시 
*************************************************************************/
function fnItemBuy()
{
    /*
    var str = "string";
    var encoded = btoa(str); // encode a string (base64)
    var decoded = atob(encoded); //decode the string 
    alert(["string base64 encoded:", encoded, "\r\n", "string base64 decoded:", decoded].join(''));
    */
    if (!gp.Util.IsLogin()) {
        gp.GNB.OpenLogInLayer(500, 500);
        return;
    }
    else {
        var coinType = $("#coinType").val().toUpperCase();
        var defPrice = $("#dPriceCoin" + coinType).text().replace(",", "");
        var totPrice = $("#totPriceCoin" + coinType).text().replace(",", "");
        var itemType = $("#itemType").val();
        var buyType = $("#buyType").val();
        if (itemType == 6) {
            if (getCheckboxCheckYN('cbpOptionSocket')) {
                var cbObj = $("input[name='cbpOptionSocket']");
                var sbObj = $("select[name='sbpOptionSocket']");
                var cnt = 0;
                cbObj.each(function (i) {
                    if ($(cbObj[i]).is(":checked") && $(sbObj[i]).val() == "") {
                        cnt++;
                    }
                });
                if (cnt > 0) {
                    $("#alertMsg").removeClass("success");
                    $("#alertMsg").text("Please select socket options");
                    return;
                }
            }

            $("#DefPrice").val(defPrice);
            fnBitCalc();
        }
        else {
            $("#DefPrice").val(totPrice);
        }
        $("#TotPrice").val(totPrice);

        if (buyType == "gift")
        {
            if ($("#searchName").val() == "")
            {
                $("#alertMsg").removeClass("success");
                $("#alertMsg").text(Message.MR375);
                return;
            }
            if ($("#sendMsg").val() == "")
            {
                $("#alertMsg").removeClass("success");
                $("#alertMsg").text(Message.MR376);
                return;
            }
        }

        $.ajax({
            type: "POST",
            url: "/webshop/shop/itemBuy",
            dataType: "json",
            async: false,
            data: $("form[id='frmItem']").serialize() + "&auth=" + fnAuth(),
            success: function (item) {
                var data = item.data;
                if (data.result == 0) {
                    if (data.itemType == 5) {
                        setInterval("fnLottryImg('s');", 3000);
                        fnLottryImg('h')
                        $("#lotteryItem").show();
                        $("#itemName").text(data.itemName);
                    }

                    if (data.buyType == "buy") {
                        $("#itemH5").text(Message.MR361);
                        $("#buyBtnPrev").hide();
                        $("#buyBtnAfter").show();
                        $("#alertMsg").addClass("success");
                        $("#alertMsg").text(Message.MR364);
                    }

                    if (data.buyType == "gift") {
                        $("#itemH5").text(Message.MR371);
                        $("#giftPrev").hide();
                        $("#giftAfter").show();
                        $("#sendUser").text(data.sendUser);
                        $("#sendMsgChk").text(data.sendMsg);
                        $("#giftBtnPrev").hide();
                        $("#giftBtnAfter").show();
                        $("#alertMsg").addClass("success");
                        $("#alertMsg").text(Message.MR377);
                    }
                    
                    $("#myCcoin").text(Number(data.coinC));
                    $("#myPcoin").text(Number(data.coinP));
                    $("#myFcoin").text(Number(data.coinF));
                    
                    fnAllDisabled('t');
                }
                else {
                    var msg = Message.MR362;
                    if (buyType == "gift")
                    {
                        msg = Message.MR374;
                    }
                    switch (data.result) {
                        case "-16": msg = Message.M016; break;
                        case "-363": msg = Message.MR363; break;
                        case "-372": msg = Message.MR372; break;
                        case "-373": msg = Message.MR373; break;
                        case "-375": msg = Message.MR375; break;
                        case "-444": msg = Message.MR363; break;
                        case "-666": msg = Message.MR363; break;
                        case "-888": msg = Message.MR363; break;
                    }
                    $("#alertMsg").removeClass("success");
                    $("#alertMsg").text(msg);
                    return;
                }
            },
            error: function (result) {
                alert("Error Mu-R");
                return;
            }
        });
    }
}

/************************************************************************
cntnt : 프리미엄 상품구매 레이어에서 Buy 클릭시 
*************************************************************************/
function fnPremiumItemBuy() {
    if (!gp.Util.IsLogin()) {
        gp.GNB.OpenLogInLayer(500, 500);
        return;
    }
    else {
        var coinType = $("#coinType").val().toUpperCase();
        var serverList = $("#serverList option:selected").val();
        var characterList = $("#characterList option:selected").val();
        var purchasablePoint = Number($("#purchasablePoint").text());
        var diplayPoint = Number($("#diplayPoint").val());
        //var pointPrice = Number($("#PointPrice").val());
        
        if (serverList == "" || characterList == "")
        {
            return;
        }
        if (diplayPoint > purchasablePoint || diplayPoint <= 0)
        {
            return;
        }
        //if (pointPrice != 3000)
        //{
        //    return;
        //}

        var totPrice = $("#totPriceCoin" + coinType).text().replace(",", "");
        var itemType = $("#itemType").val();
        $("#Count").val(diplayPoint);
        $("#TotPrice").val(totPrice);
        
        $.ajax({
            type: "POST",
            url: "/webshop/shop/itemBuy",
            dataType: "json",
            async : false,
            data: $("form[id='frmItem']").serialize() + "&auth=" + fnPremAuth(),
            success: function (item) {
                var data = item.data;
                if (data.result == 0) {
                    
                    $("#itemH5").text(Message.MR361);
                    $("#buyBtnPrev").hide();
                    $("#buyBtnAfter").show();
                    
                    $("#myCcoin").text(Number(data.coinC));
                    $("#myPcoin").text(Number(data.coinP));
                    $("#myFcoin").text(Number(data.coinF));
                    $("#alertMsg").addClass("success");
                    $("#alertMsg").text(Message.MR364);
                    fnAllDisabled('t');
                }
                else {
                    var msg = Message.MR362;
                    switch (data.result) {
                        case "-16": msg = Message.M016; break;
                        case "-372": msg = Message.MR372; break;
                        case "-373": msg = Message.MR373; break;
                        case "-375": msg = Message.MR375; break;
                        case "-444": msg = Message.MR363; break;
                        case "-666": msg = Message.MR363; break;
                        case "-888": msg = Message.MR363; break;
                    }
                    $("#alertMsg").removeClass("success");
                    $("#alertMsg").text(msg);
                    return;
                }
            },
            error: function (result) {
                alert("error");
                return;
            }
        });
    }
}

/************************************************************************
cntnt : 구매 레이어 닫기 
*************************************************************************/
function fnLayerClose()
{
    var trgt = $("#layerName").val();
    $("#" + trgt).html("");
}

/************************************************************************
cntnt : textarea 길이제한 체크
param : trgt -> 대상 ID 
        maxlen -> 제한길이
*************************************************************************/
function fnTextAreaLength(trgt, maxlen) {
    var temp;
    var msglen;
    var tmpstr = "";
    var value = $("#" + trgt).val();
    msglen = maxlen;
    var cnt = value.length;
    if (cnt != 0) {
        for (k = 0; k < cnt; k++) {
            temp = value.charAt(k);

            if (escape(temp).length > 4)
                msglen -= 2;
            else
                msglen--;

            if (msglen < 0) {
                //alert("최대 " + maxlen + " 글자까지만 기재하실 수 있습니다.");
                $("#" + trgt).val(tmpstr);
                break;
            }
            else {
                tmpstr += temp;
            }
        }
    }
}

/************************************************************************
cntnt : Bit 연산계산
param : trgt -> 대상 ID 
*************************************************************************/
function fnSetBit(trgt)
{
    if ($("#" + trgt).attr("type") == "checkbox") {
        if ($("#" + trgt).is(":checked")) {
            $("#" + trgt + "Bit").addClass("bit");
        }
        else {
            $("#" + trgt + "Bit").removeClass("bit");
        }
    }
    else {
        if ($("#" + trgt).val() != "") {
            $("#" + trgt + "Bit").addClass("bit");
        }
        else {
            $("#" + trgt + "Bit").removeClass("bit");
        }
    }
}

/************************************************************************
cntnt : Life값 설정 
param : trgt -> 대상 ID 
*************************************************************************/
function fnDataLife(trgt)
{
    $("#Option").val($("#" + trgt).val());
    fnSetBit(trgt);
}

/************************************************************************
cntnt : 값 설정 (체크박스로 구성된것들)
param : trgt1 -> 나의 ID 
        trgt2 -> 대상 ID 
        trgt1V -> 대상 ID에 설정할 값 
        trgt2V -> 나의 ID에 설정할 값 
*************************************************************************/
function fnDataSet(trgt1, trgt2, trgt1V, trgt2V)
{
    if ($("#" + trgt1).is(":checked")) {
        $("#" + trgt2).val(trgt1V);
    } else {
        $("#" + trgt2).val(trgt2V);
    }
    fnSetBit(trgt1);
}

/************************************************************************
cntnt : 소켓 값 설정 (체크박스) 
param : trgt -> 대상 ID 
        i -> 증가값 
*************************************************************************/
function fnDataSocketCb(trgt, i) {
    if ($("#" + trgt).is(":checked")) {
        $("#Socket" + i + "Option").val($("#sb" + trgt + " option:selected").val());        
    }
    fnSetBit(trgt);
}

/************************************************************************
cntnt : 소켓 값 설정 (셀렉트 박스) 
param : trgt -> 대상 ID 
        i -> 증가값 
*************************************************************************/
function fnDataSocket(trgt, i)
{
    var checkboxID = trgt.replace("sb", "");
    if ($("#" + checkboxID).is(":checked")) {
        $("#Socket" + i + "Option").val($("#" + trgt + " option:selected").val());
    }
    fnSetBit(trgt);
}

/************************************************************************
cntnt : 하모니켓 값 설정 
param : trgt -> 대상 ID 
*************************************************************************/
function fnDataHarmony(trgt) {
    $("#JewelHarmonyOption").val($("#" + trgt + "  option:selected").val());
    fnSetBit(trgt);
}

/************************************************************************
cntnt : 비트 값 계산
*************************************************************************/
function fnBitCalc()
{
    var obj = $(".bit");
    var bit = 0;
    obj.each(function (i) {
        bit += Number($(this).text());
    });

    $("#Bit").val(bit);
}

/************************************************************************
cntnt : 프리미엄서비스에서 숫자 클릭시 
param : str -> 숫자
*************************************************************************/
function fnPress(str)
{
    if ($("#diplayPoint").attr("disabled")) {
        return;
    }
    var coinType = $("#coinType").val().toUpperCase();
    var point = $("#diplayPoint").val();
    point = point + str;
    if (point.length > 3) {
        point = point.substring(1, point.length);
    }
    $("#diplayPoint").val(point);
    
    if ($("#currentPoint").text() == "100") {
        $("#diplayPoint").attr("disabled", true);
    }
    else {
        $("#diplayPoint").attr("disabled", false);
    }

    if (point > Number($("#purchasablePoint").text())) {
        $("#errPointOver").show();
    }
    else {
        $("#errPointOver").hide();
    }

    if (point == "")
    {
        point = 0;
    }
    
    var pointPrice = Number($("#dPriceCoin" + coinType).text());
    //var tot = point * Number($("#PointPrice").val()) + Number($("#DefPrice").val());
    var tot = point * pointPrice;
    $("#totPriceCoin" + coinType).text(tot);
}

/************************************************************************
cntnt : 프리미엄서비스에서 <- 클릭시  
*************************************************************************/
function fnBack()
{
    if ($("#diplayPoint").attr("disabled")) {
        return;
    }
    var coinType = $("#coinType").val().toUpperCase();
    var point = $("#diplayPoint").val();
    if (point.length > 0)
    {
        point = point.substring(0, point.length - 1);
    }
    $("#diplayPoint").val(point);
    if ($("#currentPoint").text() == "100") {
        $("#diplayPoint").attr("disabled", true);
    }
    else {
        $("#diplayPoint").attr("disabled", false);
    }

    if (point > Number($("#purchasablePoint").text())) {
        $("#errPointOver").show();
    }
    else {
        $("#errPointOver").hide();
    }

    if (point == "") {
        point = 0;
    }

    var pointPrice = Number($("#dPriceCoin" + coinType).text());
    //var tot = point * Number($("#PointPrice").val()) + Number($("#DefPrice").val());
    var tot = point * pointPrice;
    $("#totPriceCoin" + coinType).text(tot);
}

/************************************************************************
cntnt : 케릭터변경시 기타사항 체크
*************************************************************************/
function fnChangeCharacter() {
    var character = $("#characterList option:selected").val();
    var coinType = $("#coinType").val().toUpperCase();
    if (character == "") {
        $("#errMsg").text(Message.MR380);
        $("#currentPoint").hide();
        $("#errMsgSpan").show();
        $("#purchasablePoint").text(0);
        $("#diplayPoint").val("").attr("disabled", true);
    }
    else {
        if ($("#Is3rdClassType" + character).text().toLowerCase() == "false") {
            $("#errMsg").text(Message.MR389);
            $("#currentPoint").hide();
            $("#errMsgSpan").show();
            $("#purchasablePoint").text(0);
            $("#diplayPoint").val("").attr("disabled", true);
        }
        else {
            var masterPoint = Number($("#masterLevelPoint" + character).text());
            $("#currentPoint").show().text(masterPoint);
            $("#purchasablePoint").text(100 - masterPoint);
            $("#errMsgSpan").hide();
            $("#diplayPoint").val("").attr("disabled", false);
        }
    }
    $("#errPointOver").hide();
    $("#totPriceCoin" + coinType).text($("#dPriceCoin" + coinType).text());
}

/************************************************************************
cntnt : 서버 변경시 케릭터 리스트 정보 반환
param : serverCode -> 서버코드
*************************************************************************/
function fnChangeServer() {
    if (!gp.Util.IsLogin()) {
        gp.GNB.OpenLogInLayer(500, 500);
        return;
    }
    else {
        var coinType = $("#coinType").val().toUpperCase();
        var serverCode = $("#serverList option:selected").val();
        if (serverCode == "") {
            $("#characterList").attr("disabled", true).val("");
            $("#errMsg").text(Message.MR380);
            $("#currentPoint").hide();
            $("#errMsgSpan").show();
            $("#purchasablePoint").text(0);
            $("#diplayPoint").val("").attr("disabled", true);
        }
        else {
            $("#characterList").attr("disabled", false);
        }

        $.ajax({
            type: "POST",
            cache: false,
            url: "/webshop/shop/getCharList",
            dataType: "json",
            data: {
                ServerCode: serverCode
            },
            async: false,
            success: function (data) {
                $("#errPointOver").hide();
                $("#totPriceCoin" + coinType).text($("#dPriceCoin" + coinType).text());

                if (data != null) {
                    $("#characterList").html("");
                    $("#characterList").append("<option value =''>"+Message.A096+"</option>");
                    for (var i = 0; i < data.length; i++) {
                        $("#characterList").append("<option value='" + i + "'>" + data[i]["Name"] + "</option>");
                        $("#characterList").append("<span id='masterLevelPoint" + i + "' style='display:none;'>" + data[i]["MasterLevelPoint"] + "</span>");
                        $("#characterList").append("<span id='Is3rdClassType" + i + "' style='display:none;'>" + data[i]["Is3rdClassType"] + "</span>");
                    }    
                }
                else {
                    return false;
                }
            },
            error: function (result) {
                return false;
            }
        });
    }
}

/************************************************************************
cntnt : 숫자 확인 및 포인트 체크
*************************************************************************/
function fnPointCheck(ev)
{
    var coinType = $("#coinType").val().toUpperCase();
    var evCode = (window.netscape) ? ev.which : event.keyCode;
    var num = eventKeyCode(evCode);
    
    if (digit(num)) {
        var point = $("#diplayPoint").val();
        
        if (point.length > 3) {
            point = point.substring(1, point.length);
        }
        $("#diplayPoint").val(point);

        if ($("#currentPoint").text() == "100") {
            $("#diplayPoint").attr("disabled", true);
        }
        else {
            $("#diplayPoint").attr("disabled", false);
        }

        if (point > Number($("#purchasablePoint").text())) {
            $("#errPointOver").show();
        }
        else {
            $("#errPointOver").hide();
        }

        if (point == "") {
            point = 0;
        }

        var pointPrice = Number($("#dPriceCoin" + coinType).text());
        //var tot = point * Number($("#PointPrice").val()) + Number($("#DefPrice").val());
        var tot = point * pointPrice;
        $("#totPriceCoin" +coinType).text(tot);
        return;
    }
    else {
        $("#diplayPoint").val("");
        return;
    }
}

/************************************************************************
cntnt : 숫자 확인 / true, false 반환 
        숫자만 포함되어 있으면 true 리턴
        숫자가 아닌 문자가 포함되어 있으면 false 리턴
parm : str (확인 string)
*************************************************************************/
function digit(str) {
    var valid = "0123456789";
    return isValid_chk(valid, str);
}

/************************************************************************
cntnt : 확인 / true, false 반환 
parm : valid (제한 string)
       str (확인 string)
*************************************************************************/
function isValid_chk(valid, str) {
    for (var i = 0; i < str.length; i++) {
        if (valid.indexOf(str.charAt(i)) == -1) {
            return false;
        }
    }
    return true;
}

/************************************************************************
cntnt : 키이벤트 숫자 반환 
parm : evCode 이벤트 코드
*************************************************************************/
function eventKeyCode(evCode)
{
    var num = "NotNumber";
    switch (evCode)
    {
        case 48: num = 0; break;
        case 49: num = 1; break;
        case 50: num = 2; break;
        case 51: num = 3; break;
        case 52: num = 4; break;
        case 53: num = 5; break;
        case 54: num = 6; break;
        case 55: num = 7; break;
        case 56: num = 8; break;
        case 57: num = 9; break;

        case 96: num = 0; break;
        case 97: num = 1; break;
        case 98: num = 2; break;
        case 99: num = 3; break;
        case 100: num = 4; break;
        case 101: num = 5; break;
        case 102: num = 6; break;
        case 103: num = 7; break;
        case 104: num = 8; break;
        case 105: num = 9; break;
    }
    return num;
}

function fnPremTabCoinType(type)
{
    $(".choice_itemsel > li > a").removeClass("on");
    $("#coinType").val(type);

    var coinType = type.toUpperCase();
    $("#totPriceCoin" + coinType).text($("#dPriceCoin" + coinType).text());

    var StoragePropertyName = $("#StoragePropertyName").val();
    var classNm = "coin_c";
    switch (type) {
        case "c": $(".choice_itemsel .coin_c > a").addClass("on");
            $("#totPriceCoinC").show();
            $("#totPriceCoinP").hide();
            $("#totPriceCoinF").hide();
            break;
        case "p": $(".choice_itemsel .coin_p > a").addClass("on");
            classNm = "coin_p";
            $("#totPriceCoinC").hide();
            $("#totPriceCoinP").show();
            $("#totPriceCoinF").hide();
            break;
        case "f": $(".choice_itemsel .coin_free > a").addClass("on");
            classNm = "coin_free";
            $("#totPriceCoinC").hide();
            $("#totPriceCoinP").hide();
            $("#totPriceCoinF").show();
            break;
        default: $(".choice_itemsel .coin_c > a").addClass("on");
            $("#totPriceCoinC").show();
            $("#totPriceCoinP").hide();
            $("#totPriceCoinF").hide();
            break;
    }

    $(".item_buy_wp dl").attr("class", classNm);

    if (type == "f") {
        $(".item_buy_wp dl span").html("Free Credit");
    }
    else {
        $(".item_buy_wp dl span").html("Wcoin");
    }

    if (StoragePropertyName == 5)
    {
        $("select[id='serverList']").val("");
        fnChangeServer();
    }
}
/*
function fnAuthPart(tmp) {
    if ($("#coinType").val().toLowerCase() == "f") {
        var checkCnt = 0;
        if (fnOptionExist('gpPExcellentExist')) {
            if (getCheckboxCheckYN('cbpOption')) {
                checkCnt++;
            }
        }
        if (fnOptionExist('gpPSocketExist')) {
            if (getCheckboxCheckYN('cbpOptionSocket')) {
                checkCnt++;
            }
        }
        if (fnOptionExist('gpP380Exist')) {
            if (getCheckboxCheckYN('cbpOption380')) {
                checkCnt++;
            }
        }
        if (fnOptionExist('gpPHarmonyExist')) {
            if ($("#pOptionHarmony option:selected").val() != "") {
                checkCnt++;
            }
        }

        if (checkCnt >= 2) {
            tmp = Number(tmp) * 10;
        }
    }
    return tmp;
}*/