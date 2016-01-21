<?php
namespace koenigseggposche\sms;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;
use koenigseggposche\sms\Target;

class ChuanglanTarget extends Component implements Target
{
    private $curl;

    private $url;
    private $account;
    private $pswd;
    private $needstatus;
    private $product;
    private $extno;

    public function init()
    {
        parent::init();

        if (isset(Yii::$app->params['chuanglan']['url'])) {
            $this->url = Yii::$app->params['chuanglan']['url'];
        } else {
            throw new InvalidParamException("Please configure param: chuanglan url");
        }

        if (isset(Yii::$app->params['chuanglan']['account'])) {
            $this->account = Yii::$app->params['chuanglan']['account'];
        } else {
            throw new InvalidParamException("Please configure param: chuanglan account");
        }

        if (isset(Yii::$app->params['chuanglan']['pswd'])) {
            $this->pswd = Yii::$app->params['chuanglan']['pswd'];
        } else {
            throw new InvalidParamException("Please configure param: chuanglan pswd");
        }

        if (isset(Yii::$app->params['chuanglan']['needstatus'])) {
            $this->needstatus = Yii::$app->params['chuanglan']['needstatus'];
        } else {
            throw new InvalidParamException("Please configure param: chuanglan needstatus");
        }

        if (isset(Yii::$app->params['chuanglan']['product'])) {
            $this->product = Yii::$app->params['chuanglan']['product'];
        } else {
            throw new InvalidParamException("Please configure param: chuanglan product");
        }

        if (isset(Yii::$app->params['chuanglan']['extno'])) {
            $this->extno = Yii::$app->params['chuanglan']['extno'];
        } else {
            throw new InvalidParamException("Please configure param: chuanglan extno");
        }
    }

    public function send($mobile, $message)
    {
        $postArr = array(
            'account' => $this->account,
            'pswd' => $this->pswd,
            'needstatus' => $this->needstatus,
            'product' => $this->product,
            'extno' => $this->extno,
            'msg' => $message,
            'mobile' => $mobile,
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

