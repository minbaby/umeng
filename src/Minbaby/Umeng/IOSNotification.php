<?php

namespace Minbaby\Umeng;

use Minbaby\Umeng\Exception\UmengException;

abstract class IOSNotification extends UmengNotification
{
    // The array for payload, please see API doc for more information
    protected $iosPayload = [
            'aps' => [
                'alert'					=> null
                //"badge"				=>  xx,
                //"sound"				=>	"xx",
                //"content-available"	=>	xx
                ]
        ];

    // Keys can be set in the aps level
    protected $APS_KEYS = ['alert', 'badge', 'sound', 'content-available'];

    public function __construct()
    {
        parent::__construct();
        $this->data['payload'] = $this->iosPayload;
    }

    /**
     * {@inheritdoc}
     */
    public function setPredefinedKeyValue($key, $value)
    {
        if (! is_string($key)) {
            throw new UmengException('key should be a string!');
        }
        if (in_array($key, $this->DATA_KEYS)) {
            $this->data[$key] = $value;
        } elseif (in_array($key, $this->APS_KEYS)) {
            $this->data['payload']['aps'][$key] = $value;
        } elseif (in_array($key, $this->POLICY_KEYS)) {
            $this->data['policy'][$key] = $value;
        } else {
            if ('payload' == $key || 'policy' == $key || 'aps' == $key) {
                throw new UmengException("You don't need to set value for ${key} , just set values for the sub keys in it.");
            }

            throw new UmengException("Unknown key: ${key}");
        }
    }

    /**
     * Set extra key/value for Android Umeng
     *
     * @param $key
     * @param $value
     *
     * @throws UmengException
     */
    public function setCustomizedField($key, $value)
    {
        if (! is_string($key)) {
            throw new UmengException('key should be a string!');
        }
        $this->data['payload'][$key] = $value;
    }
}
