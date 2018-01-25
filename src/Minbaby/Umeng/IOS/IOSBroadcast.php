<?php

namespace Minbaby\Umeng\IOS;

use Minbaby\Umeng\IOSNotification;

class IOSBroadcast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'broadcast';
    }
}
