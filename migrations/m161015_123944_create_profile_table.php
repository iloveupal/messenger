<?php

use yii\db\Migration;

/**
 * Handles the creation for table `profile`.
 */
class m161015_123944_create_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('profile', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'profile_image' => $this->string()
        ]);

        $this->addForeignKey('profile_user_id_users_id', 'profile', 'user_id', 'users', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('profile');
    }
}
