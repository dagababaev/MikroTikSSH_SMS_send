<?php
/**
 * Created by Agababaev Dmitry
 */

require_once 'lib/MikroTikSSH_SMS_send.php';
require_once 'lib/RouterosAPI.class.php';

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