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

class MikroTikSSH_SMS_send
{
    private $ip;
    private $login;
    private $password;
    private $usb_port;
    private $channel;

    /*
     * $param = [
     * 'MT_ip' => 'x.x.x.x',
     * 'login' => 'router_login',
     * 'password' => 'router_password',
     * 'usb_port' => 'usb1',
     * 'channel' => int
     * ]
     */

    public function __construct ($param)
    {
        $this->ip = $param['ip'];
        $this->login = $param['login'];
        $this->password = $param['password'];
        $this->usb_port = $param['usb_port'];
        $this->channel = $param['channel'];
    }

    public function send($phone, $message)
    {
        $cmd = "/tool sms send port={$this->usb_port} channel={$this->channel} phone-number={$phone} message=\"{$message}\"";

        $connection = ssh2_connect($this->ip, 22);
        if ($connection) {
            ssh2_auth_password($connection, $this->login, $this->password);
            $stream = ssh2_exec($connection, $cmd);
            stream_set_blocking($stream, true);
            $result = stream_get_contents($stream);
            fclose($stream);

            $error1 = stripos($result, 'expected');
            $error2 = stripos($result, 'invalid');
            $error3 = stripos($result, 'failure');

            if ($error1 !== false ||  $error2 !== false ||  $error3 !== false) {
                $error = json_encode(["success" => false, "message" => $result]);
                return $error;
            }
        } else {
            $error = json_encode(["success" => false, "message" => "Can't connect to {$this->ip}"]);
            return $error;
        }
        return true;
    }
}
