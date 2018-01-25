<?php

namespace Minbaby\Umeng;

use Minbaby\Umeng\Exception\UmengException;

abstract class UmengNotification
{
    // The host
    protected $host = 'http://msg.umeng.com';

    // The upload path
    protected $uploadPath = '/upload';

    // The post path
    protected $postPath = '/api/send';

    // The app master secret
    protected $appMasterSecret;

    /*
     * $data is designed to construct the json string for POST request. Note:
     * 1)The key/value pairs in comments are optional.
     * 2)The value for key 'payload' is set in the subclass(AndroidNotification or IOSNotification),
     *      as their payload structures are different.
     */
    protected $data = [
            'appkey'           => null,
            'timestamp'        => null,
            'type'             => null,
            //"device_tokens"  => "xx",
            //"alias"          => "xx",
            //"file_id"        => "xx",
            //"filter"         => "xx",
            //"policy"         => array("start_time" => "xx", "expire_time" => "xx", "max_send_num" => "xx"),
            'production_mode'  => 'true',
            //"feedback"       => "xx",
            //"description"    => "xx",
            //"thirdparty_id"  => "xx"
    ];

    protected $DATA_KEYS = [
        'appkey',
        'timestamp',
        'type',
        'device_tokens',
        'alias',
        'alias_type',
        'file_id',
        'filter',
        'production_mode',
        'feedback',
        'description',
        'thirdparty_id'
    ];

    protected $POLICY_KEYS = ['start_time', 'expire_time', 'max_send_num'];

    public function __construct()
    {
    }

    public function setAppMasterSecret($secret)
    {
        $this->appMasterSecret = $secret;
    }

    /**
     * return TRUE if it's complete, otherwise throw UmengException with details
     *
     * @throws UmengException
     *
     * @return bool
     */
    public function isComplete()
    {
        if (is_null($this->appMasterSecret)) {
            throwUmengException('Please set your app master secret for generating the signature!');
        }
        $this->checkArrayValues($this->data);

        return true;
    }

    /**
     * @param $arr
     *
     * @throws UmengException
     */
    private function checkArrayValues($arr)
    {
        foreach ($arr as $key => $value) {
            if (is_null($value)) {
                throwUmengException($key . ' is NULL!');
            }
            if (is_array($value)) {
                $this->checkArrayValues($value);
            }
        }
    }

    /**
     * Set key/value for $data array
     * for the keys which can be set please see $DATA_KEYS, $PAYLOAD_KEYS, $BODY_KEYS, $POLICY_KEYS
     *
     * @param string $key
     * @param string $value
     */
    abstract public function setPredefinedKeyValue($key, $value);

    /**
     * send the Umeng to umeng, return response data if SUCCESS , otherwise throw UmengException with details.
     *
     * @throws UmengException
     *
     * @return mixed
     */
    public function send()
    {
        //check the fields to make sure that they are not NULL
        $this->isComplete();

        $url = $this->host . $this->postPath;
        $postBody = json_encode($this->data);
        $sign = md5('POST' . $url . $postBody . $this->appMasterSecret);
        $url = $url . '?sign=' . $sign;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($ch);
        $curlErr = curl_error($ch);
        curl_close($ch);

        if ('0' == $httpCode) {
            // Time out
            $msg = 'Curl error number:' . $curlErrNo . ' , Curl error details:' . $curlErr . "\r\n";
            throwUmengException($msg, $curlErrNo, $curlErr);
        }

        if (UMENG_HTTP_OK != $httpCode) {
            // We did send the notifition out and got a non-200 response
            $msg = 'Http code:' . $httpCode .  ' details:' . $result . "\r\n";
            throwUmengException($msg, $httpCode, $result);
        }

        return $result;
    }
}
