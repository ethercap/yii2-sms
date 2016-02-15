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
    private $appid;
    private $appsecret;

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

        if (isset(Yii::$app->params['hljsms']['appid'])) {
            $this->appid = Yii::$app->params['hljsms']['appid'];
        } else {
            throw new InvalidParamException("Please configure param: hljsms appid");
        }

        if (isset(Yii::$app->params['hljsms']['appsecret'])) {
            $this->appsecret = Yii::$app->params['hljsms']['appsecret'];
        } else {
            throw new InvalidParamException("Please configure param: hljsms appsecret");
        }
    }

    public function send($mobile, $message)
    {
        $postArr = array(
            'type' => $this->type,
            'policy' => $this->policy,
            'mobile' => $mobile,
            'content' => $message,
        );

        $date = gmdate('D, j M Y H:i:s T');
        $method = 'POST';
        $urlinfo = parse_url($this->url);
        if (!isset($urlinfo['path'])) {
            return;
        }
        $uri = $urlinfo['path'];
        $string_to_sign = "$method$uri$date";
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $this->appsecret, true));
        $authorization = "HLJ " . $this->appid . ":" . $signature;
        $headers[] = "Date: $date";
        $headers[] = "Authorization: $authorization";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postArr));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode >= 200 && $httpcode < 300) ? $data : false;
    }
}
