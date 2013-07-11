<?php

class IPDetector
{
    public static function clientIP(){
        $ips='';
        if(isset($_SERVER['HTTP_X_REAL_IP']) && $_SERVER['HTTP_X_REAL_IP'] && $_SERVER['HTTP_X_REAL_IP']!='-')
            return trim($_SERVER['HTTP_X_REAL_IP']);
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ips=$_SERVER['HTTP_X_FORWARDED_FOR'];
        if(!$ips && isset($_SERVER['REMOTE_ADDR'])) $ips=$_SERVER['REMOTE_ADDR'];
		$a=explode(',', $ips);
		$ip=trim(end($a));
		if(!$ip) $ip='127.0.0.1';
		return $ip;
	}

}
