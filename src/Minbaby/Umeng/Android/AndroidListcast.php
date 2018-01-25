<?php

namespace Minbaby\Umeng\Android;

use Minbaby\Umeng\AndroidNotification;

class AndroidListcast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'listcast';
        $this->data['device_tokens'] = null;
    }
}
