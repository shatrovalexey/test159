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
    /**
    * @var string $name - имя вопрошающего
    */
    public string $name;

    /**
    * @var string $email - e-mail для отправки
    */
    public string $email;

    /**
    * @var string $comment - комментарий
    */
    public string $message;
    
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