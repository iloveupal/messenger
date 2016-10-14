<?php

use yii\db\Migration;

class m161013_224043_add_parent_column_to_messages extends Migration
{
    public function safeUp()
    {
        $this->addColumn('messages', 'parent_id', $this->integer());
        $this->addForeignKey('messages_parent_id_messages_id', 'messages', 'parent_id', 'messages', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropIndex('messages_parent_id_messages_id', 'messages');
        $this->dropColumn('messages', 'parent_id');
    }


}
