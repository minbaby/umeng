<?php

namespace Minbaby\Umeng\IOS;

use Minbaby\Umeng\IOSNotification;

class IOSCustomizedcast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'customizedcast';
        $this->data['alias_type'] = null;
    }
    
    /**
     * @inheritdoc
     */
    public function isComplete()
    {
        parent::isComplete();
        if (! array_key_exists('alias', $this->data) && ! array_key_exists('file_id', $this->data)) {
            throwUmengException('You need to set alias or upload file for customizedcast!');
        }
    }

    // Upload file with device_tokens or alias to Umeng
    public function uploadContents($content)
    {
        if (null == $this->data['appkey']) {
            throwUmengException('appkey should not be NULL!');
        }
        if (null == $this->data['timestamp']) {
            throwUmengException('timestamp should not be NULL!');
        }
        if (! is_string($content)) {
            throwUmengException('content should be a string!');
        }
        $post = ['appkey'                => $this->data['appkey'],
                      'timestamp'        => $this->data['timestamp'],
                      'content'          => $content
                      ];
        $url = $this->host . $this->uploadPath;
        $postBody = json_encode($post);
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
        if ('0' == $httpCode) { //time out
            throwUmengException('Curl error number:' . $curlErrNo . ' , Curl error details:' . $curlErr . "\r\n");
        }
        if ('200' != $httpCode) { //we did send the notifition out and got a non-200 response
            throwUmengException('http code:' . $httpCode . ' details:' . $result . "\r\n");
        }
        $returnData = json_decode($result, true);
        if ('FAIL' == $returnData['ret']) {
            throwUmengException('Failed to upload file, details:' . $result . "\r\n");
        }
        $this->data['file_id'] = $returnData['data']['file_id'];
    }

    public function getFileId()
    {
        if (array_key_exists('file_id', $this->data)) {
            return $this->data['file_id'];
        }

        return null;
    }
}
