<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 14.10.16
 * Time: 14:57
 */

namespace app\models;




use app\utils\TokensUtil;
use yii\web\IdentityInterface;

class MagicLink
{
    public $raw;

    public function __construct()
    {
        $this->raw = TokensUtil::generateTokenString();
    }

    public static function getOne($raw) {
        $model = new self();
        $model->raw = $raw;
        return $model;
    }

    public function send(IdentityInterface $admin, IdentityInterface $user)
    {
        MessagesUser::createMessage($admin, $user, $this->link());
    }

    public function link() {
        return 'localhost:8080/auth/magic?token=' . $this->raw;
    }
}