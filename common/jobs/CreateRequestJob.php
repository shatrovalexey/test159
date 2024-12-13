<?php
namespace common\jobs;

use \yii\queue\JobInterface;
use \yii\base\BaseObject;
use common\models\Request as RequestModel;

/**
* Задание создания заявки
*/
class CreateRequestJob extends BaseObject implements JobInterface
{
	public $name;
	public $email;
	public $message;
    
    public function execute($queue)
    {
		try {
			$obj = new RequestModel();
			$obj->name = $this->name;
			$obj->email = $this->email;
			$obj->message = $this->message;
			$obj->validate();
			$obj->save();
		} catch(\Exception $exception) {
		}

		return $obj;
    }
}