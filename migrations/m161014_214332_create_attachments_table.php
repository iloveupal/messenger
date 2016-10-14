<?php

use yii\db\Migration;

/**
 * Handles the creation for table `attachments`.
 */
class m161014_214332_create_attachments_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('attachments', [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer(),
            'message_id' => $this->integer(),
            'dialogue_id' => $this->integer(),
            'file_name' => $this->string()
        ]);

        $this->addForeignKey('attachments_owner_id_users_id', 'attachments', 'owner_id', 'users', 'id');
        $this->addForeignKey('attachments_message_id_messages_id', 'attachments', 'message_id', 'messages', 'id');
        $this->addForeignKey('attachments_dialogue_id_dialogues_id', 'attachments', 'dialogue_id', 'dialogues', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('attachments');
    }
}
