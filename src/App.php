<?php

namespace MultiCurl;

/**
 * Class App
 * @package MultiCurl
 */
class App
{
    /**
     * Main
     */
    public function main()
    {
        echo PHP_EOL;

        $stack = $this->getStack(15);

        $multi = curl_multi_init();

        /** @var resource $curl */
        foreach ($stack as $curl) {
            curl_multi_add_handle($multi, $curl);
        }

        $start = microtime(true);

        do {
            curl_multi_exec($multi, $running);
            curl_multi_select($multi);
        } while ($running > 0);

        $stop = microtime(true) - $start;

        /** @var resource $curl */
        foreach ($stack as $curl) {
            curl_multi_remove_handle($multi, $curl);
        }

        curl_multi_close($multi);

        echo PHP_EOL;
        echo 'Execution Time: ' . number_format($stop, 8, '.', ',') . ' sec' . PHP_EOL;
    }

    /**
     * @param int $size
     * @return array
     */
    protected function getStack($size)
    {
        $array = [];
        for ($x = 0; $x < $size; $x++) {
            $array[] = $this->getResource('https://example.com?testvar=' . $x);
        }
        return $array;
    }

    /**
     * @param string $url
     * @return resource
     */
    protected function getResource($url)
    {
        $curl = curl_init($url);
        curl_setopt_array($curl, $this->getOptions());
        return $curl;
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,text/xhtml,application/json',
                'Content-Type: application/json'
            ],
            CURLOPT_HEADERFUNCTION => [$this, 'onResponseHeader'],
            CURLOPT_WRITEFUNCTION => [$this, 'onBody'],
        ];
    }

    /**
     * @param resource $curl
     * @param string   $str
     * @return int
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onResponseHeader($curl, $str)
    {
        return strlen($str);
    }

    /**
     * @param resource $curl
     * @param string   $str
     * @return int
     */
    public function onBody($curl, $str)
    {
        $info = curl_getinfo($curl);
        echo $info['url'].' => ' . $info['http_code'] . PHP_EOL;
        return strlen($str);
    }
}
