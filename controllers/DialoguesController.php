<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 14.10.16
 * Time: 12:53
 */

namespace app\controllers;


use app\models\Dialogues;
use app\utils\Parameters;

class DialoguesController extends JsonController
{
    public function actionAll()
    {
        $limit = Parameters::validate_one(\yii::$app->request, 'limit', ['is_number']);

        $user = \yii::$app->user->getIdentity();

        if (!$user) {
            return 'unauth';
        }

        return Dialogues::getAllForUser($user, $limit);
    }
}