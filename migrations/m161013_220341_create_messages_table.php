<?php

use yii\db\Migration;

/**
 * Handles the creation for table `messages`.
 */
class m161013_220341_create_messages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('messages', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'sender_id' => $this->integer(),
            'receiver_id' => $this->integer(),
            'read' => $this->boolean()
        ]);

        $this->addForeignKey('messages_sender_id_users_id', 'messages', 'sender_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('messages_receiver_id_users_id', 'messages', 'receiver_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('messages');
    }
}
