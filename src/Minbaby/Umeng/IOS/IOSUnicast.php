<?php

namespace Minbaby\Umeng\IOS;

use Minbaby\Umeng\IOSNotification;

class IOSUnicast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'unicast';
        $this->data['device_tokens'] = null;
    }
}
