<?php
// ------------------------------------------------------------------------------
//  © Copyright (с) 2020
//  Author: Dmitri Agababaev, d.agababaev@duncat.net
//
//  Redistributions and use of source code, with or without modification, are
//  permitted that retain the above copyright notice
//
//  License: MIT
// ------------------------------------------------------------------------------

require_once 'lib/MikroTikSSH_SMS_send.php';

$param = [
    'ip' => 'x.x.x.x',
    'login' => 'router_login',
    'password' => 'router_password',
    'usb_port' => 'usb1',
    'channel' => 0
];

$SMS = new MikroTikSSH_SMS_send($param);

$phone = '79001230000';
$message = 'Hello world!';

$result = $SMS->send($phone, $message);
if ($result !== true) print_r($result);
