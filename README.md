Yii2 sms
============
This is a sms extension of Yii2 framewoks.

It can be used to send sms through different channels in an easy way.

Channels it support:

创蓝(Chuanglan)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require koenigseggposche/yii2-sms "dev-master"
```

or add

```
"koenigseggposche/yii2-sms": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Configure Yii2 component:

```php
[
    'components' => [
        'sms' => [
            'class' => 'koenigseggposche\sms\Sms',
            'targets' => [
                [
                    'class' => 'koenigseggposche\sms\target\ChuanglanTarget',
                ],
                [
                    'class' => 'koenigseggposche\sms\target\GuoduTarget',
                ],
            ],
        ],
    ],
];
```

Configure Yii2 param:

```php
[
    'components' => [
        'sms' => [
            'class' => 'koenigseggposche\sms\Sms',
            'targets' => [
                [
                    'class' => 'koenigseggposche\sms\target\ChuanglanTarget',
                ],
            ],
        ],
    ],
];
```

Send sms:
```php
<?php
    $mobile = '13588888888';
    $message = 'test message';
    Yii::$app->sms->send($mobile, $message);
?>
```
