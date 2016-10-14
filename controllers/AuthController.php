<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 13.10.16
 * Time: 2:06
 */

namespace app\controllers;

use app\models\TempTokens;
use app\models\UserIdentity;
use app\utils\Parameters;
use app\models\TokensUser;

class AuthController extends JsonController
{
    public function actionLogin()
    {
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

    public function actionRequestMagicLink()
    {
        $user_id = Parameters::validate_one(\yii::$app->request, 'id', ['is_number', 'not_null']);

        $user = UserIdentity::findIdentity($user_id);

        if (!$user) {
            return 'no user found';
        }

        $token = TempTokens::create($user);

        return [
            'token' => $token
        ];
    }

    public function actionMagic()
    {
        $token = Parameters::validate_one(\yii::$app->request, 'token', ['is_string', 'not_null']);

        return TempTokens::activate($token);
    }
}