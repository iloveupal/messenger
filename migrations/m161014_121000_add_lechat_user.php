<?php

use yii\db\Migration;

class m161014_121000_add_lechat_user extends Migration
{
    public function up()
    {
        \app\models\AdminIdentity::createAdminIdentity('lechat');
    }

    public function down()
    {
        return false;
    }
}
