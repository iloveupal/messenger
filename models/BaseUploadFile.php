<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 15.10.16
 * Time: 0:58
 */

namespace app\models;

use yii\base\DynamicModel;
use yii\web\UploadedFile;
use app\utils\Files as FileUtil;

class BaseUploadFile extends DynamicModel
{
    /**
     * @var UploadedFile
     */
    public $attachment;

    public function __construct()
    {
        $file_fields = array_keys($_FILES);

        parent::__construct($file_fields);

        array_map(function($key) {
            $this->$key = UploadedFile::getInstanceByName($key);
        }, $file_fields);
    }

    public function upload()
    {

        $ts = time();

        array_map(function($name) use ($ts) {

            $filename = FileUtil::getUniqueFilename($ts, $this->$name->extension);

            $this->$name->saveAs(\yii::$aliases['@app'] . '/uploads/' . $filename);
            $this->$name->name = $filename;
        }, array_keys($this->attributes));

        return true;
    }
}