<?php

namespace Minbaby\Umeng\IOS;

use Minbaby\Umeng\IOSNotification;

class IOSListcast extends IOSNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'listcast';
        $this->data['device_tokens'] = null;
    }
}
