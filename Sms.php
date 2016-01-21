<?php

namespace koenigseggposche\sms;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;

class Sms extends Component
{
    public $targets = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->targets)) {
            throw new InvalidParamException("Please configure targets.");
        }
        foreach ($this->targets as $name => $target) {
            if (!$target instanceof Target) {
                $this->targets[$name] = Yii::createObject($target);
            }
        }
    }

    /**
     * @param string $mobiles
     * @param string $message
     * @return bool
     */
    public function send($mobiles, $message)
    {
        if (count($this->targets) == 0) {
            \Yii::error('No sms targets configured');
            return false;
        }
        $target = $this->targets[rand(0, count($this->targets) - 1)];
        return $target->send($mobiles, $message);
    }
}
