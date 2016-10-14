<?php

namespace app\controllers;

use app\utils\Parameters;
use app\models\Users;
use app\controllers\JsonController;

class UsersController extends JsonController
{
    public function actionDelete()
    {

    }

    public function actionRegister()
    {
        $params = Parameters::validate(\yii::$app->request, [
            'username' => ['is_string', 'not_null'],
            'pass' => ['is_string', 'not_null']
        ]);

        $success = Users::createUser($params['username'], $params['pass']);

        return [
            'success'=> $success
        ];
    }

}
