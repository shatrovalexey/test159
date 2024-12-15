<?php
namespace common\jobs;

use \yii\queue\JobInterface;
use common\jobs\CommentRequestEmailJob;
use \yii\base\BaseObject;
use common\models\Request as RequestModel;

/**
* Задание комментирования заявки
*/
class CommentRequestJob extends BaseObject implements JobInterface
{
    /**
    * @var int $id - ID заявки
    */
    public $id;

    /**
    * @var string $comment - комментарий
    */
    public $comment;
    
    public function execute($queue)
    {
        try {
            $obj = RequestModel::setResolved($this->id, $this->comment);
        } catch(\Exception $exception) {
            return false;
        }

        \Yii::$app->queueCommentsEmail->push(new CommentRequestEmailJob([
            'email' => $obj->email
            , 'id' => $obj->id
            , 'comment' => $obj->comment,
        ]));

        return true;
    }
}