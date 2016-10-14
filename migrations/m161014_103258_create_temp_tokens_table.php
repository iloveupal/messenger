<?php

use yii\db\Migration;

/**
 * Handles the creation for table `temp_tokens`.
 */
class m161014_103258_create_temp_tokens_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('temp_tokens', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'magic_token' => $this->string(),
            'token' => $this->string()
        ]);

        $this->addForeignKey('temp_tokens_user_id_users_id', 'temp_tokens', 'user_id', 'users', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('temp_tokens');
    }
}
