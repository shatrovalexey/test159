<?php
namespace common\jobs;

use \yii\queue\JobInterface;
use \yii\base\BaseObject;
use common\models\Request as RequestModel;

/**
* Задание комментирования заявки
*/
class CommentRequestJob extends BaseObject implements JobInterface
{
    public $id;
    public $comment;
    
    public function execute($queue)
    {
        try {
            $obj = RequestModel::setResolved($this->id, $this->comment);
        } catch(\Exception $exception) {
            return false;
        }

        // Можно было бы создать такую же очередь
        Yii::$app->mailer->compose()
            ->setTo($obj->email)
            ->setSubject("Ответ на запрос {$obj->id}")
            ->setTextBody($obj->comment)
            ->send();

        return true;
    }
}