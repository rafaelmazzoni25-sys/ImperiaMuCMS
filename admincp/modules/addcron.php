<?php
/* ImperiaMuCMS 2.0.7 | Desencriptado por TheKing027 - MTA | Más info: https://muteamargentina.com.ar */

echo "    <h1 class=\"page-header\">New Cron Job</h1>\r\n";
$cron_times = ["1" => 300, "2" => 600, "3" => 900, "4" => 1800, "5" => 3600, "6" => 7200, "7" => 14400, "8" => 28800, "9" => 36000, "10" => 43200, "11" => 86400, "12" => 259200, "13" => 604800, "14" => 1209600, "15" => 1814400, "16" => 2419200];
if (check_value($_POST["add_cron"])) {
    addCron($cron_times);
}
echo "<div class=\"row\"><div class=\"col-md-4\"><form method=\"post\"><div class=\"form-group\"><label for=\"input_1\">Name:</label><input type=\"text\" class=\"form-control\" id=\"input_1\" name=\"cron_name\" /></div><div class=\"form-group\"><label for=\"input_2\">Description:</label><input type=\"text\" class=\"form-control\" id=\"input_2\" name=\"cron_description\" /></div><div class=\"form-group\"><label for=\"input_3\">File:</label><select class=\"form-control\" id=\"input_3\" name=\"cron_file\">";
echo listCronFiles();
echo "</select></div><div class=\"form-group\"><label for=\"input_4\">Run time:</label><select class=\"form-control\" id=\"input_4\" name=\"cron_time\"><option value=\"1\">Every 5 minutes</option><option value=\"2\">Every 10 minutes</option><option value=\"3\">Every 15 minutes</option><option value=\"4\">Every 30 minutes</option><option value=\"5\">Every 60 minutes</option><option value=\"6\">Every 2 hours</option><option value=\"7\">Every 4 hours</option><option value=\"8\">Every 8 hours</option><option value=\"9\">Every 10 hours</option><option value=\"10\">Every 12 hours</option><option value=\"11\">Every 24 hours</option><option value=\"12\">Every 3 days</option><option value=\"13\">Every 7 days</option><option value=\"14\">Every 2 weeks</option><option value=\"15\">Every 3 weeks</option><option value=\"16\">Every 4 weeks</option></select></div><button type=\"submit\" name=\"add_cron\" value=\"Add\" class=\"btn btn-primary\">Save Cron Job</button></form></div></div>";

?>