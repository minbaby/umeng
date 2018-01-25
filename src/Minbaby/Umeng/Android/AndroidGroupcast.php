<?php

namespace Minbaby\Umeng\Android;

use Minbaby\Umeng\AndroidNotification;

class AndroidGroupcast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data['type'] = 'groupcast';
        $this->data['filter'] = null;
    }
}
