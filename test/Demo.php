<?php

use Minbaby\Umeng\IOS\IOSUnicast;
use Minbaby\Umeng\IOS\IOSFilecast;
use Minbaby\Umeng\IOS\IOSBroadcast;
use Minbaby\Umeng\IOS\IOSGroupcast;
use Minbaby\Umeng\IOS\IOSCustomizedcast;
use Minbaby\Umeng\Android\AndroidUnicast;
use Minbaby\Umeng\Android\AndroidFilecast;
use Minbaby\Umeng\Android\AndroidBroadcast;
use Minbaby\Umeng\Android\AndroidGroupcast;
use Minbaby\Umeng\Android\AndroidCustomizedcast;

require __DIR__ . '/../vendor/autoload.php';

class Demo
{
    protected $appkey;
    protected $appMasterSecret;
    protected $timestamp;
    protected $validation_token;

    public function __construct($key, $secret)
    {
        $this->appkey = $key;
        $this->appMasterSecret = $secret;
        $this->timestamp = strval(time());
    }

    public function sendAndroidBroadcast()
    {
        try {
            $brocast = new AndroidBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue('appkey', $this->appkey);
            $brocast->setPredefinedKeyValue('timestamp', $this->timestamp);
            $brocast->setPredefinedKeyValue('ticker', 'Android broadcast ticker');
            $brocast->setPredefinedKeyValue('title', '中文的title');
            $brocast->setPredefinedKeyValue('text', 'Android broadcast text');
            $brocast->setPredefinedKeyValue('after_open', 'go_app');
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $brocast->setPredefinedKeyValue('production_mode', 'true');
            // [optional]Set extra fields
            $brocast->setExtraField('test', 'helloworld');
            echo "Sending broadcast Umeng, please wait...\r\n";
            $brocast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }

    public function sendAndroidUnicast()
    {
        try {
            $unicast = new AndroidUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue('appkey', $this->appkey);
            $unicast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set your device tokens here
            $unicast->setPredefinedKeyValue('device_tokens', 'xx');
            $unicast->setPredefinedKeyValue('ticker', 'Android unicast ticker');
            $unicast->setPredefinedKeyValue('title', 'Android unicast title');
            $unicast->setPredefinedKeyValue('text', 'Android unicast text');
            $unicast->setPredefinedKeyValue('after_open', 'go_app');
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $unicast->setPredefinedKeyValue('production_mode', 'true');
            // Set extra fields
            $unicast->setExtraField('test', 'helloworld');
            echo "Sending unicast Umeng, please wait...\r\n";
            $unicast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }

    public function sendAndroidFilecast()
    {
        try {
            $filecast = new AndroidFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue('appkey', $this->appkey);
            $filecast->setPredefinedKeyValue('timestamp', $this->timestamp);
            $filecast->setPredefinedKeyValue('ticker', 'Android filecast ticker');
            $filecast->setPredefinedKeyValue('title', 'Android filecast title');
            $filecast->setPredefinedKeyValue('text', 'Android filecast text');
            $filecast->setPredefinedKeyValue('after_open', 'go_app');  //go to app
            echo "Uploading file contents, please wait...\r\n";
            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
            $filecast->uploadContents('aa'."\n".'bb');
            echo "Sending filecast Umeng, please wait...\r\n";
            $filecast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }

    public function sendAndroidGroupcast()
    {
        try {
            /*
             *  Construct the filter condition:
             *  "where":
             *	{
             *		"and":
             *		[
             *			{"tag":"test"},
             *			{"tag":"Test"}
             *		]
             *	}
             */
            $filter = [
                            'where' => [
                                            'and' 	=> [
                                                            [
                                                                 'tag' => 'test'
                                                            ],
                                                             [
                                                                 'tag' => 'Test'
                                                             ]
                                                         ]
                                        ]
                        ];

            $groupcast = new AndroidGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue('appkey', $this->appkey);
            $groupcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue('filter', $filter);
            $groupcast->setPredefinedKeyValue('ticker', 'Android groupcast ticker');
            $groupcast->setPredefinedKeyValue('title', 'Android groupcast title');
            $groupcast->setPredefinedKeyValue('text', 'Android groupcast text');
            $groupcast->setPredefinedKeyValue('after_open', 'go_app');
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $groupcast->setPredefinedKeyValue('production_mode', 'true');
            echo "Sending groupcast Umeng, please wait...\r\n";
            $groupcast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }

    public function sendAndroidCustomizedcast()
    {
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue('appkey', $this->appkey);
            $customizedcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized Umeng.
            $customizedcast->setPredefinedKeyValue('alias', 'xx');
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue('alias_type', 'xx');
            $customizedcast->setPredefinedKeyValue('ticker', 'Android customizedcast ticker');
            $customizedcast->setPredefinedKeyValue('title', 'Android customizedcast title');
            $customizedcast->setPredefinedKeyValue('text', 'Android customizedcast text');
            $customizedcast->setPredefinedKeyValue('after_open', 'go_app');
            echo "Sending customizedcast Umeng, please wait...\r\n";
            $customizedcast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }

    public function sendAndroidCustomizedcastFileId()
    {
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue('appkey', $this->appkey);
            $customizedcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized Umeng.
            $customizedcast->uploadContents('aa'."\n".'bb');
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue('alias_type', 'xx');
            $customizedcast->setPredefinedKeyValue('ticker', 'Android customizedcast ticker');
            $customizedcast->setPredefinedKeyValue('title', 'Android customizedcast title');
            $customizedcast->setPredefinedKeyValue('text', 'Android customizedcast text');
            $customizedcast->setPredefinedKeyValue('after_open', 'go_app');
            echo "Sending customizedcast Umeng, please wait...\r\n";
            $customizedcast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }

    public function sendIOSBroadcast()
    {
        try {
            $brocast = new IOSBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue('appkey', $this->appkey);
            $brocast->setPredefinedKeyValue('timestamp', $this->timestamp);

            $brocast->setPredefinedKeyValue('alert', 'IOS 广播测试');
            $brocast->setPredefinedKeyValue('badge', 0);
            $brocast->setPredefinedKeyValue('sound', 'chime');
            // Set 'production_mode' to 'true' if your app is under production mode
            $brocast->setPredefinedKeyValue('production_mode', 'false');
            // Set customized fields
            $brocast->setCustomizedField('test', 'helloworld');
            echo "Sending broadcast Umeng, please wait...\r\n";
            $brocast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }

    public function sendIOSUnicast()
    {
        try {
            $unicast = new IOSUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue('appkey', $this->appkey);
            $unicast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set your device tokens here
            $unicast->setPredefinedKeyValue('device_tokens', 'xx');
            $unicast->setPredefinedKeyValue('alert', 'IOS 单播测试');
            $unicast->setPredefinedKeyValue('badge', 0);
            $unicast->setPredefinedKeyValue('sound', 'chime');
            // Set 'production_mode' to 'true' if your app is under production mode
            $unicast->setPredefinedKeyValue('production_mode', 'false');
            // Set customized fields
            $unicast->setCustomizedField('test', 'helloworld');
            echo "Sending unicast Umeng, please wait...\r\n";
            $unicast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }

    public function sendIOSFilecast()
    {
        try {
            $filecast = new IOSFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue('appkey', $this->appkey);
            $filecast->setPredefinedKeyValue('timestamp', $this->timestamp);

            $filecast->setPredefinedKeyValue('alert', 'IOS 文件播测试');
            $filecast->setPredefinedKeyValue('badge', 0);
            $filecast->setPredefinedKeyValue('sound', 'chime');
            // Set 'production_mode' to 'true' if your app is under production mode
            $filecast->setPredefinedKeyValue('production_mode', 'false');
            echo "Uploading file contents, please wait...\r\n";
            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
            $filecast->uploadContents('aa'."\n".'bb');
            echo "Sending filecast Umeng, please wait...\r\n";
            $filecast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }

    public function sendIOSGroupcast()
    {
        try {
            /*
             *  Construct the filter condition:
             *  "where":
             *	{
             *		"and":
             *		[
             *			{"tag":"iostest"}
             *		]
             *	}
             */
            $filter = [
                            'where' => [
                                            'and' 	=> [
                                                            [
                                                                 'tag' => 'iostest'
                                                            ]
                                                         ]
                                        ]
                        ];

            $groupcast = new IOSGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue('appkey', $this->appkey);
            $groupcast->setPredefinedKeyValue('timestamp', $this->timestamp);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue('filter', $filter);
            $groupcast->setPredefinedKeyValue('alert', 'IOS 组播测试');
            $groupcast->setPredefinedKeyValue('badge', 0);
            $groupcast->setPredefinedKeyValue('sound', 'chime');
            // Set 'production_mode' to 'true' if your app is under production mode
            $groupcast->setPredefinedKeyValue('production_mode', 'false');
            echo "Sending groupcast Umeng, please wait...\r\n";
            $groupcast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }

    public function sendIOSCustomizedcast()
    {
        try {
            $customizedcast = new IOSCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue('appkey', $this->appkey);
            $customizedcast->setPredefinedKeyValue('timestamp', $this->timestamp);

            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized Umeng.
            $customizedcast->setPredefinedKeyValue('alias', 'xx');
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue('alias_type', 'xx');
            $customizedcast->setPredefinedKeyValue('alert', 'IOS 个性化测试');
            $customizedcast->setPredefinedKeyValue('badge', 0);
            $customizedcast->setPredefinedKeyValue('sound', 'chime');
            // Set 'production_mode' to 'true' if your app is under production mode
            $customizedcast->setPredefinedKeyValue('production_mode', 'false');
            echo "Sending customizedcast Umeng, please wait...\r\n";
            $customizedcast->send();
            echo "Sent SUCCESS\r\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage();
        }
    }
}

// Set your appkey and master secret here
$demo = new Demo('5a671c38f43e4832ff00024f', '5a671c38f43e4832ff00024f');
$demo->sendAndroidUnicast();
/* these methods are all available, just fill in some fields and do the test
 * $demo->sendAndroidBroadcast();
 * $demo->sendAndroidFilecast();
 * $demo->sendAndroidGroupcast();
 * $demo->sendAndroidCustomizedcast();
 * $demo->sendAndroidCustomizedcastFileId();
 *
 * $demo->sendIOSBroadcast();
 * $demo->sendIOSUnicast();
 * $demo->sendIOSFilecast();
 * $demo->sendIOSGroupcast();
 * $demo->sendIOSCustomizedcast();
 */
