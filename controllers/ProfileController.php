<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 15.10.16
 * Time: 15:54
 */

namespace app\controllers;


use app\models\Profile;
use app\models\UserIdentity;
use app\utils\Parameters;
use app\models\BaseUploadFile;

class ProfileController extends JsonController
{
    public $files = null;

    public function __construct($id, $module, BaseUploadFile $file, $config = [])
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

    }

    public function actionGetProfileImage()
    {

    }
}