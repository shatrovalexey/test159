<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
* Заявка
*/
class Request extends ActiveRecord
{
    /**
    * @const STATUS_ACTIVE - непрокомментированная заявка
    */
    const STATUS_ACTIVE = 'Active';

    /**
    * @const STATUS_RESOLVED - прокомментированная заявка
    */
    const STATUS_RESOLVED = 'Resolved';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%request}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [TimestampBehavior::class,];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return ['id', 'name', 'email', 'message', 'status', 'comment', 'created_at', 'updated_at',];
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        return ['id', 'name', 'email', 'message', 'comment', 'status',];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' =>  self::STATUS_ACTIVE,]
            , ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_RESOLVED,]]
            , [['name', 'email', 'message', 'status',], 'required',]
            , [['name', 'message', 'comment',], 'string',],
            , [['email',], 'email',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя'
            , 'email' => 'Email'
            , 'message' => 'Запрос'
            , 'comment' => 'Ответ'
            , 'status' => 'Статус',
        ];
    }

    /**
    * Прокомментировать заявку
    *
    * @param int $id - ID заявки
    * @param string $comment - комментарий
    *
    * @return static - заявка
    */
    public static function setResolved(int $id, string $comment): ?static
    {
        if (!mb_strlen($comment)) {
            return null;
        }

        $obj = static::find($id)->where(['status' => static::STATUS_ACTIVE,])->one();

        if (!$obj) {
            return null;
        }

        $obj->comment = $comment;
        $obj->status = self::STATUS_RESOLVED;

        if (!$obj->update()) {
            return null;
        }

        return $obj;
    }

    /**
    * Список непрокомментированных заявок
    */
    public static function getActive()
    {
        return static::find()->where(['status' => static::STATUS_ACTIVE,])->all();
    }
}