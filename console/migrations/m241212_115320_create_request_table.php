<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 */
class m241212_115320_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey()
            , 'name' => $this->string()->notNull()
            , 'email' => $this->string()->notNull()
            , 'message' => $this->string()->notNull()
            , 'comment' => $this->string()
            , 'created_at' => $this->bigint()
            , 'updated_at' => $this->bigint() ,
        ]);

        $this->addColumn('{{%request}}', 'status', "ENUM('Active','Resolved') DEFAULT 'Active'");
        $this->addCommentOnColumn('{{%request}}', 'id', 'ID');
        $this->addCommentOnColumn('{{%request}}', 'name', 'Имя пользователя');
        $this->addCommentOnColumn('{{%request}}', 'email', 'Email пользователя');
        $this->addCommentOnColumn('{{%request}}', 'message', 'Сообщение пользователя');
        $this->addCommentOnColumn('{{%request}}', 'comment', 'Ответ ответственного лица');
        $this->addCommentOnColumn('{{%request}}', 'created_at', 'Время создания заявки');
        $this->addCommentOnColumn('{{%request}}', 'updated_at', 'Время ответа на заявку');
        $this->addCommentOnTable('{{%request}}', 'Заявка');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%request}}');
    }
}
