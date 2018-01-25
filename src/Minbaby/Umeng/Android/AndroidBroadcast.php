<?php

namespace Minbaby\Umeng\Android;

use Minbaby\Umeng\AndroidNotification;

class AndroidBroadcast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'broadcast';
    }
}
