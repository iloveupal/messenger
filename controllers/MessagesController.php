<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 14.10.16
 * Time: 1:21
 */

namespace app\controllers;

use app\utils\Parameters;
use app\models\UserIdentity;
use app\models\MessagesUser;

class MessagesController extends JsonController
{
    public function actionSend()
    {
        $params = Parameters::validate(\yii::$app->request, [
            'to' => ['is_number', 'not_null'],
            'text' => ['is_string', 'not_null']
        ]);

        $receiver = UserIdentity::findIdentity($params['to']);
        $user = \yii::$app->user->getIdentity();

        if (!$receiver || !$user) {
            return 'not identities';
        }

        return MessagesUser::createMessage($user, $receiver, $params['text']);
    }

    public function actionLatest() {

        $params = Parameters::validate(\yii::$app->request, [
            'to' => ['is_number', 'not_null'],
            'count' => ['is_number']
        ]);

        $user = \yii::$app->user->getIdentity();
        $to = UserIdentity::findIdentity($params['to']);
        if (!$user || !$to) {
            return 'not identities';
        }

        return MessagesUser::getLastConversation($user, $to, $params['count']);
    }
}