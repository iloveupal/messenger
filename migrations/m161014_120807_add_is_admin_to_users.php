<?php

use yii\db\Migration;

class m161014_120807_add_is_admin_to_users extends Migration
{
    public function up()
    {
        $this->addColumn('users', 'is_admin', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('users', 'is_admin');
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
