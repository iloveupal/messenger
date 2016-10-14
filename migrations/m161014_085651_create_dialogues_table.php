<?php

use yii\db\Migration;

/**
 * Handles the creation for table `dialogues`.
 */
class m161014_085651_create_dialogues_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('dialogues', [
            'id' => $this->primaryKey(),
            'user1' => $this->integer(),
            'user2' => $this->integer(),
            'last_message_id' => $this->integer()
        ]);

        $this->addForeignKey('dialogues_user1_users_id', 'dialogues', 'user1', 'users', 'id');
        $this->addForeignKey('dialogues_user2_users_id', 'dialogues', 'user2', 'users', 'id');
        $this->addForeignKey('dialogues_last_message_id_messages_id', 'dialogues', 'last_message_id', 'messages', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('dialogues');
    }
}
