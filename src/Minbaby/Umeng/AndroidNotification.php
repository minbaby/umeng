<?php

namespace Minbaby\Umeng;

use Minbaby\Umeng\Exception\UmengException;

abstract class AndroidNotification extends UmengNotification
{
    // The array for payload, please see API doc for more information
    protected $androidPayload = [
                                    'display_type'  => 'Umeng',
                                    'body'         	=> [
                                                            'ticker'       => null,
                                                            'title'        => null,
                                                            'text'         => null,
                                                            //"icon"       => "xx",
                                                            //largeIcon    => "xx",
                                                            'play_vibrate' => 'true',
                                                            'play_lights'  => 'true',
                                                            'play_sound'   => 'true',
                                                            'after_open'   => null,
                                                            //"url"        => "xx",
                                                            //"activity"   => "xx",
                                                            //custom       => "xx"
                                                        ],
                                    //"extra"       => array("key1" => "value1", "key2" => "value2")
                                ];
    // Keys can be set in the payload level
    protected $PAYLOAD_KEYS = ['display_type'];

    // Keys can be set in the body level
    protected $BODY_KEYS = ['ticker', 'title', 'text', 'builder_id', 'icon', 'largeIcon', 'img', 'play_vibrate', 'play_lights', 'play_sound', 'after_open', 'url',
                                    'activity', 'custom'];

    public function __construct()
    {
        parent::__construct();
        $this->data['payload'] = $this->androidPayload;
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
        } elseif (in_array($key, $this->PAYLOAD_KEYS)) {
            $this->data['payload'][$key] = $value;
            if ('display_type' == $key && 'message' == $value) {
                $this->data['payload']['body']['ticker'] = '';
                $this->data['payload']['body']['title'] = '';
                $this->data['payload']['body']['text'] = '';
                $this->data['payload']['body']['after_open'] = '';
                if (! array_key_exists('custom', $this->data['payload']['body'])) {
                    $this->data['payload']['body']['custom'] = null;
                }
            }
        } elseif (in_array($key, $this->BODY_KEYS)) {
            $this->data['payload']['body'][$key] = $value;
            if ('after_open' == $key && 'go_custom' == $value && ! array_key_exists('custom', $this->data['payload']['body'])) {
                $this->data['payload']['body']['custom'] = null;
            }
        } elseif (in_array($key, $this->POLICY_KEYS)) {
            $this->data['policy'][$key] = $value;
        } else {
            if ('payload' == $key || 'body' == $key || 'policy' == $key || 'extra' == $key) {
                throw new UmengException("You don't need to set value for ${key} , just set values for the sub keys in it.");
            }

            throw new UmengException("Unknown key: ${key}");
        }
    }

    // Set extra key/value for Android Umeng
    public function setExtraField($key, $value)
    {
        if (! is_string($key)) {
            throw new UmengException('key should be a string!');
        }
        $this->data['payload']['extra'][$key] = $value;
    }
}
