<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 13.10.16
 * Time: 2:06
 */

namespace app\controllers;

use app\utils\Parameters;
use app\models\TokensUser;

class AuthController extends JsonController
{
    public function actionLogin() {
        $params = Parameters::validate(\yii::$app->request, [
            'username' => ['is_string', 'not_null'],
            'pass' => ['is_string', 'not_null']
        ]);

        $token = TokensUser::login($params['username'], $params['pass']);

        return [
            'success' => !!$token,
            'token' => $token
        ];
    }
}