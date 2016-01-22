<?php
namespace koenigseggposche\sms\target;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;

class GuoduTarget extends Component implements Target
{
    private $curl;

    private $OperID;
    private $OperPass;
    private $ContentType;

    public function init()
    {
        parent::init();

        if (isset(Yii::$app->params['guodu']['url'])) {
            $this->url = Yii::$app->params['guodu']['url'];
        } else {
            throw new InvalidParamException("Please configure param: guodu url");
        }

        if (isset(Yii::$app->params['guodu']['OperID'])) {
            $this->OperID = Yii::$app->params['guodu']['OperID'];
        } else {
            throw new InvalidParamException("Please configure param: guodu OperID");
        }

        if (isset(Yii::$app->params['guodu']['OperPass'])) {
            $this->OperPass = Yii::$app->params['guodu']['OperPass'];
        } else {
            throw new InvalidParamException("Please configure param: guodu OperPass");
        }

        if (isset(Yii::$app->params['guodu']['ContentType'])) {
            $this->ContentType = Yii::$app->params['guodu']['ContentType'];
        } else {
            throw new InvalidParamException("Please configure param: guodu ContentType");
        }
    }

    public function send($mobile, $message)
    {
        $postArr = array(
            'OperID' => $this->OperID,
            'OperPass' => $this->OperPass,
            'ContentType' => $this->ContentType,
            'DesMobile' => $mobile,
            'Content' => urlencode($message),
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
