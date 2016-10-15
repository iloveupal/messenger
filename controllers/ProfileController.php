<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 15.10.16
 * Time: 15:54
 */

namespace app\controllers;


use app\models\Profile;
use app\models\ProfilePicture;
use app\models\UserIdentity;
use app\utils\Parameters;
use yii\base\Exception;


class ProfileController extends JsonController
{
    public $files = null;

    public function __construct($id, $module, ProfilePicture $file, $config = [])
    {
        $this->files = $file;
        parent::__construct($id, $module, $config);
    }

    public function actionView()
    {

        $id = Parameters::validate_one(\yii::$app->request, 'id', ['is_number']);
        if (!$id)
        {
            $id = $this->user? $this->user->getId(): null;
        }

        if (!$id)
        {
            throw new Exception ('id param is required');
        }

        $user = UserIdentity::findIdentity($id);

        return Profile::getForUser($user);
    }

    public function actionEdit()
    {
        $profile = Profile::fromRequest(\yii::$app->request->post());

        return Profile::setForUser($this->user, $profile);
    }

    public function actionSetProfileImage()
    {
        return ProfilePicture::ApplyProfilePicture($this->user, $this->files);
    }

    public function actionGetProfileImage()
    {
        $image_id = Parameters::validate_one(\yii::$app->request, 'image', ['is_string']);
        $user_id = Parameters::validate_one(\yii::$app->request, 'id', ['is_number']);

        if (!$user_id && !$image_id)
        {
            throw new Exception('at least id or image has to be specified');
        }

        $image_link = ProfilePicture::GetProfilePicture($image_id, $user_id);

        \yii::$app->response->sendFile($image_link);
    }
}