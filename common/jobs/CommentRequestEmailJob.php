<?php
namespace common\jobs;

use \yii\queue\JobInterface;
use \yii\base\BaseObject;
use common\models\Request as RequestModel;

/**
* Задание на отправку e-mail прокомментированной заявки
*/
class CommentRequestEmailJob extends BaseObject implements JobInterface
{
    /**
    * @var int $id - ID заявки
    */
    public int $id;

    /**
    * @var string $email - e-mail для отправки
    */
    public string $email;

    /**
    * @var string $comment - комментарий
    */
    public string $comment;

    public function execute($queue)
    {
        Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setSubject("Ответ на запрос {$this->id}")
            ->setTextBody($this->comment)
            ->send();

        return true;
    }
}