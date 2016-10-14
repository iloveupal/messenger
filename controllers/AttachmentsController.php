<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 15.10.16
 * Time: 0:56
 */

namespace app\controllers;


use app\models\Attachments;
use app\models\BaseUploadFile;
use yii\web\UploadedFile;
class AttachmentsController extends JsonController
{

    public $files = null;

    public function __construct($id, $module, BaseUploadFile $file, $config = [])
    {
        $this->files = $file;
        parent::__construct($id, $module, $config);
    }

    public function actionUpload()
    {
        if (!$this->user) {
            return 'unauth';
        }

        $this->files->upload();

        return Attachments::upload($this->user, $this->files);
    }
}