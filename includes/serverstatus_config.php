<?php
/*

 List of server's shown in sidebar

 For adding new server append new array

 array(
    'ip'          => '',     // ip address of server
    'port'        => '',     // server port
    'servername'  => '',     // server name in database
    'displayname' => '',     // server name display in main page
    'cssclass'    => ''      // custom CSS class for background image (can be empty)
 )

 */

$config['serverstatus'] = array(
    array(
        'ip' => '127.0.0.1',
        'port' => 56900,
        'servername' => 'PvP',
        'displayname' => 'Server PvP',
        'cssclass' => 's1'
    ),
    array(
        'ip' => '127.0.0.1',
        'port' => 56901,
        'servername' => 'Non-PvP',
        'displayname' => 'Server Non-PvP',
        'cssclass' => 's2'
    )
);

/*
 * Main server IP and port
 */
$config['serveronline'] = array(
    'ip' => '127.0.0.1',
    'port' => 80
);
