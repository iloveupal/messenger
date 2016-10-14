<?php

use yii\db\Migration;

class m161012_205307_add_users_table extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'pass' => $this->string()
         ]);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
