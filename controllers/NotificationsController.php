<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 20.10.16
 * Time: 0:48
 */

namespace app\controllers;

use app\models\Notifications;

class NotificationsController extends JsonController
{
    public function actionIndex() {
        $new = Notifications::poll($this->user);
        return $new;
    }
}