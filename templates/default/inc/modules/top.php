<?php

$date = date("Y/m/d H:i", time());

if ($config["show_countdown"] && $date < $config['countdown_date']) {
    echo '
    <div class="welcome_to_imperiamucms">
        <h1>'.lang('template_txt_16', true).'</h1>
        <span></span>
        <div class="open">';
?>
            <script type="text/javascript">
                $(document).ready( function(){

                    var days, hours, minutes, seconds;
                    var targetTime = <?php echo strtotime($config['countdown_date']); ?>;
                    var addSec = 0;

                    setInterval(function(){
                        var serverTime = <?php echo time(); ?>;
                        serverTime = serverTime + addSec;
                        var countdown = targetTime - serverTime;

                        days = parseInt(countdown / 86400);
                        countdown = countdown % 86400;
                        hours = parseInt(countdown / 3600);
                        countdown = countdown % 3600;
                        minutes = parseInt(countdown / 60);
                        seconds = parseInt(countdown % 60);

                        $("#days").html(days);
                        $("#hours").html(hours);
                        $("#minutes").html(minutes);
                        $("#seconds").html(seconds);

                        addSec++;
                    }, 1000);
                });
            </script>
<?php
    echo '
            <div style="margin-left: 150px;">
                <table width="366" height="88" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="91" style="padding-left:5px">
                            <div align="center" class="time"><div id="days" class="count"></div></div>
                        </td>
                        <td width="99" style=""><div align="center" class="time" ><div id="hours" class="count"></div></div>
                        </td>
                        <td width="91" style="padding-left: 4px;"><div align="center" class="time"><div id="minutes" class="count"></div></div>
                        </td>
                        <td width="85"><div align="center" class="time"><div id="seconds" class="count"></div></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>';
} else {
    echo '
    <div class="welcome_to_imperiamucms">
        <h1>'.lang('template_txt_20', true).'</h1>
        <span></span>
        <p>
            '.lang('template_txt_21', true).'
        </p>
    </div>';
}

?>
