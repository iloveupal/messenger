<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 14.10.16
 * Time: 15:04
 */

namespace app\models;

class AdminIdentity extends UserIdentity
{
    public static function getAdminIdentities($name) {
        return UserIdentity::findOne([
            'is_admin' => true,
            'username' => $name
        ]);
    }

    public static function createAdminIdentity($name) {
        $user = new Users();
        $user->username = $name;
        $user->pass = '0';
        $user->is_admin = true;

        return $user->save();
    }

    public static function checkIsAdmin ($id)
    {
        $user = Users::findOne($id);
        return $user->is_admin;
    }
}