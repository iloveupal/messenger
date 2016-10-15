<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 15.10.16
 * Time: 18:06
 */

namespace app\models;


use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\base\Exception;
use app\utils\Files;

class ProfilePicture extends BaseUploadFile
{

    public $profile_image;

    public function __construct()
    {
        $file_fields = ['profile_image'];
        parent::__construct($file_fields);

        $this->profile_image = UploadedFile::getInstanceByName('profile_image');
    }

    /**
     * @param IdentityInterface $user
     * @param ProfilePicture $file
     * @return bool
     * @throws Exception
     */
    public static function ApplyProfilePicture(IdentityInterface $user, ProfilePicture $file)
    {
        if (!$user)
        {
            throw new Exception('unauthorized');
        }

        $profile = Profile::getForUser($user);
        if (!$file->upload())
        {
            throw new Exception ('file upload failed');
        }

        $profile->profile_image = $file->profile_image->name;
        if (!$profile->save())
        {
            throw new Exception ('failed to save profile');
        }

        return true;
    }

    public static function GetProfilePicture($image_id, $user_id)
    {



        $profile = Profile::find()->where([
            'profile_image' => $image_id
        ])->orWhere(['user_id'=>$user_id])->one();

        if (!$profile) throw new Exception('profile not found');

        return Files::downloadLink($profile->profile_image);
    }

}