<?php

use yii\db\Migration;

class m161012_215734_add_unique_index_to_username extends Migration
{
    public function up()
    {
        $this->createIndex('users_unique_username', 'users', 'username', true);
    }

    public function down()
    {
        $this->dropIndex('users_unique_username', 'users');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
