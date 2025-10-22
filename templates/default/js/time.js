var MuEvents = {};
MuEvents.text = [
    [lang[0], lang[1]],
    [lang[2], lang[3]]
];

MuEvents.sked = [
    ['Blood Castle',        0,      '00:30', '04:30', '08:30', '12:30', '16:30', '20:30'],
    ['Chaos Castle',        0,      '02:00', '08:00', '14:00', '20:00'],
    ['Devil Square',        0,      '01:00', '04:00', '07:00', '10:00', '13:00', '16:00', '19:00', '22:00'],
    ['Illusion Temple',     0,      '03:15', '09:15', '15:15', '21:15'],
    ['White Wizard',        1,      '03:05', '07:05', '11:05', '15:05', '19:05', '23:05'],
    ['Golden Invasion',     1,      '03:30', '07:30', '11:30', '15:30', '19:30', '23:30'],
    ['Red Dragon Invasion', 1,      '02:50', '08:50', '14:50', '20:50']
];

MuEvents.timeToSec = function(timeStr) {
    var t = timeStr.split(":");
    return (t[0] * 60 + t[1] * 1) * 60;
}

MuEvents.getServerDateInSec = function(timeInSec) {
    var st = new Date(timeInSec * 1000);
    //var sec = (st.getUTCHours() * 60 + st.getUTCMinutes()) * 60 + st.getUTCSeconds();
    var sec = (st.getHours() * 60 + st.getMinutes()) * 60 + st.getSeconds();
    return timeInSec - sec;
}

MuEvents.getEventInSec = function(timeInSec, timeStr) {
    var dayInSec = MuEvents.getServerDateInSec(timeInSec);
    var t = MuEvents.timeToSec(timeStr);
    return dayInSec + t;
}

MuEvents.getLocalTimeStr = function(timeInSec) {
    var d = new Date(timeInSec * 1000);
    var h = d.getHours();
    var m = d.getMinutes();
    return  (h < 10 ? "0" + h : h) + ":" + (m < 10 ? "0" + m : m);
}

MuEvents.secToTime = function(t) {
    var h = Math.floor((t / 60) / 60);
    var m = Math.floor((t / 60) % 60);
    var s = t % 60;

    h = h < 10 ? "0" + h : h
    m = m < 10 ? "0" + m : m;
    s = s < 10 ? "0" + s : s;

    return (h + ":" + m + ":" + s);
}

MuEvents.start = function(e, offset) {
    var j = [];
    var q = MuEvents.sked;

    for (var a = 0; a < q.length; a++) {
        var event = q[a];

        for (var k = 2; k < event.length; k++) {
            var et = MuEvents.getEventInSec(e, event[k]);
            if(e > et) {
                if(k+1 == event.length) {
                    var st = MuEvents.getServerDateInSec(e) + 86400;
                    et = MuEvents.getEventInSec(st, event[2]);
                }
                else {
                    continue;
                }
            }
            //var lt = serverToLocal(et, offset);
            var lt = et;// + localTimeOffset();
            var eventTime = MuEvents.getLocalTimeStr(lt);
            var diff = et - e;
            var countdown = MuEvents.secToTime(diff);
            var countdownText = MuEvents.text[event[1]][0];
            var m = (event[1] ? 1 : 5) * 60;
            if(diff < m) {
                countdownText = MuEvents.text[event[1]][1];
            }
            
            j.push('<dt class="event">' + '<b class="rightfloat">' + eventTime + "</b><b>" + event[0] + '</b><span><div class="rightfloat">' + countdown + "</div>" + countdownText + "</span></dt>");
            break;
        }
    }

    document.getElementById("events").innerHTML = j.join("");
    setTimeout(function () {
        MuEvents.start(++e, offset);
    }, 1000);
}

function calcTime(offset) {
    var d = new Date();
    var utc = d.getTime() + (d.getTimezoneOffset() * 60000);
    var nd = new Date(utc + (3600000*offset));
    return nd;
}

MuEvents.init = function (e) {

    var serverTimeZone = 2;
    var localDate = new Date();
    var serverDate = calcTime(serverTimeZone);
    var offset = localDate.getTimezoneOffset() + serverTimeZone * 60;
    var j = [];

    if (typeof e == "string")
        var g = new Date(serverDate.toString().replace(/\date('H')+:\date('i')+:\date('s')+/g, e));


    var f = (typeof e == "number" ? e : (g.getHours() * 60 + g.getMinutes()) * 60 + g.getSeconds()), q = MuEvents.sked;

    for (var a = 0; a < q.length; a++) {
        var n = q[a];
        for (var k = 2; k < q[a].length; k++) {
            var b = 0, p = q[a][k].split(":"), o = (p[0] * 60 + p[1] * 1) * 60, c = q[a][2].split(":");
            if (q[a].length - 1 == k && (o - f) < 0) b = 1;
            var r = b ? (1440 * 60 - f) + ((c[0] * 60 + c[1] * 1) * 60) : o - f;
            if (f <= o || b) {
                var l = Math.floor((r / 60) / 60), l = l < 10 ? "0" + l : l, d = Math.floor((r / 60) % 60), d = d < 10 ? "0" + d : d, u = r % 60, u = u < 10 ? "0" + u : u;

                var temp = q[a][b ? 2 : k];
                var x = temp.split(":");
                var sec = (x[0] * 60 + x[1] * 1) * 60 - (offset *60);
                var hod = Math.floor((sec / 60) / 60);
                if(hod > 23) hod = hod - 24;
                hod = hod < 10 ? "0" + hod : hod;
                var min = Math.floor((sec / 60) % 60);
                min = min < 10 ? "0" + min : min;
                var time =  hod + ':' + min;

                j.push('<dt class="event">' + '<b class="rightfloat">' + time + "</b><b>" + n[0] + '</b><span><div class="rightfloat">' + (l + ":" + d + ":" + u) + "</div>" + (MuEvents.text[q[a][1]][+(l == 0 && d < (q[a][1] ? 1 : 5))]) + "</span></dt>");
                break;
            }
        }
    }

    document.getElementById("events").innerHTML = j.join("");
    setTimeout(function () {
        MuEvents.init(f == 86400 ? 1 : ++f);
    }, 1000);
};
