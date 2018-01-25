<?php

namespace Minbaby\Umeng\Android;

use Minbaby\Umeng\AndroidNotification;

class AndroidUnicast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'unicast';
        $this->data['device_tokens'] = null;
    }
}
