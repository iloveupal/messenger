<?php

use yii\db\Migration;

/**
 * Handles the creation for table `notifications`.
 */
class m161019_214916_create_notifications_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('notifications', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'new' => $this->smallInteger(1)->defaultValue(0)
        ]);

        $this->addForeignKey('notifications_user_id_users_id', 'notifications', 'user_id', 'users', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('notifications');
    }
}
