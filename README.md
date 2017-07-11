Yii2 sms
============

This is a sms extension of Yii2 framewoks.

It can be used to send sms with different service providers in an easy way.

SMS Service Providers list:

```
创蓝(Chuanglan)：ethercap\sms\target\ChuanglanTarget
国都(Guodu)：ethercap\sms\target\GuoduTarget
```

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require ethercap/yii2-sms "dev-master"
```

or add

```
"ethercap/yii2-sms": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Configure Yii2 component:

```php
[
    'components' => [
        'sms' => [
            'class' => 'ethercap\sms\Sms',
            'targets' => [
                [
                    'class' => 'ethercap\sms\target\ChuanglanTarget',
                ],
                [
                    'class' => 'ethercap\sms\target\GuoduTarget',
                ],
            ],
        ],
    ],
];
```

Configure Yii2 param:

```php
[
    'chuanglan' => [
        'url' => 'http://222.73.117.158/msg/HttpBatchSendSM',
        'account' => 'YOUR_ACCOUNT',
        'pswd' => 'YOUR_PASSWORD',
    ],
    'guodu' => [
        'url' => 'http://221.179.180.158:9008/HttpQuickProcess/submitMessageAll',
        'OperID' => 'YOUR_ACCOUNT',
        'OperPass' => 'YOUR_PASSWORD',
    ],
];
```

Send sms:

```php
<?php
    $mobile = '13500000000';
    $message = 'test message';
    Yii::$app->sms->send($mobile, $message);
?>
```
