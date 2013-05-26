<?php 

class Http {
    /**
     * Send a POST requst using cURL
     * @param string $url to request
     * @param array $params values to send
     * @param array $options for cURL
     * @return info array, result string
     */
    public static function post($url, $params = array(), $options = array())
    {
        $defaults = array(
            CURLOPT_USERAGENT=>'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER=>array('Expect: '),
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 600,
            CURLOPT_POSTFIELDS => (is_string($params))?$params:http_build_query($params),
        );

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if(!$result = curl_exec($ch))
        {
            return array(array('code' => '', 'Content-Type' => '', 'curl-Error' => curl_error($ch)), '');
        }
        $info = array(
            'code' => curl_getinfo ($ch, CURLINFO_HTTP_CODE),
            'Content-Type' => curl_getinfo ($ch, CURLINFO_CONTENT_TYPE)
        );
        curl_close($ch);
        return array($info, $result);
    }

    /**
     * Send a GET requst using cURL
     * @param string $url to request
     * @param array $params values to send
     * @param array $options for cURL
     * @return string
     */
    public static function get($url, array $params = array(), array $options = array())
    {   
        $defaults = array(
            CURLOPT_USERAGENT=>'Mozilla/5.0 (X11; Linux x86_64; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
            CURLOPT_URL => $url. (($params)?((strpos($url, '?') === FALSE ? '?' : ''). http_build_query($params)):''),
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 600
        );
       
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if(!$result = curl_exec($ch))
        {
            return array(array('code' => '', 'Content-Type' => '', 'curl-Error' => curl_error($ch)), '');
        }
        $info = array(
            'code' => curl_getinfo ($ch, CURLINFO_HTTP_CODE),
            'Content-Type' => curl_getinfo ($ch, CURLINFO_CONTENT_TYPE)
        );
        curl_close($ch);
        return array($info, $result);
    }
}


