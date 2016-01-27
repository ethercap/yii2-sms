<?php
namespace koenigseggposche\sms\target;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;

class HljsmsTarget extends Component implements Target
{
    private $url;
    private $type;
    private $policy;

    public function init()
    {
        parent::init();

        if (isset(Yii::$app->params['hljsms']['url'])) {
            $this->url = Yii::$app->params['hljsms']['url'];
        } else {
            throw new InvalidParamException("Please configure param: hljsms url");
        }

        if (isset(Yii::$app->params['hljsms']['type'])) {
            $this->type = Yii::$app->params['hljsms']['type'];
        } else {
            throw new InvalidParamException("Please configure param: hljsms type");
        }

        if (isset(Yii::$app->params['hljsms']['policy'])) {
            $this->policy = Yii::$app->params['hljsms']['policy'];
        } else {
            throw new InvalidParamException("Please configure param: hljsms policy");
        }
    }

    public function send($mobile, $message)
    {
        $postArr = array(
            'type' => $this->type,
            'policy' => $this->policy,
            'mobile' => $mobile,
            'content' => $message,
            'timeStamp' => time(),
            'sign' => '',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postArr));
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode >= 200 && $httpcode < 300) ? $data : false;
    }
}

