<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 13.10.16
 * Time: 1:29
 */

namespace app\controllers;
use app\models\UserIdentity;
use yii\web\Controller;
use app\models\TokensUser;

class JsonController extends Controller
{
    public function afterAction($action, $result)
    {
        \yii::$app->response->format = 'json';

        return parent::afterAction($action, $result); // TODO: Change the autogenerated stub
    }

    public function actionError($error) {
        var_dump($error);
        die();
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'app\actions\ErrorAction'
            ]
        ];
    }

    public function beforeAction($action)
    {


        $auth_header = \yii::$app->request->headers->get('Authorization', null);
        $user = UserIdentity::findIdentityByAccessToken($auth_header);

        \yii::$app->user->setIdentity($user);
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

}