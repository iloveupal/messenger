<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tokens`.
 */
class m161012_224715_create_tokens_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('tokens', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string()->notNull(),
            'scope' => $this->string()
        ]);
        $this->addForeignKey('tokens_user_id_users_id', 'tokens', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tokens');
    }
}
