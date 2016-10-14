<?php
/**
 * Created by PhpStorm.
 * User: teodor
 * Date: 13.10.16
 * Time: 0:22
 */

namespace app\utils;
use Yii;
use yii\base\InvalidParamException;

class Parameters
{
    //returns params as array if they are valid
    public static function validate($req, $params, $only = null)
    {
        $result = [];

        foreach ($params as $name=>$type) {
            $result[$name] = self::validate_one($req, $name, $type, $only);
        }

        return $result;
    }

    public static function validate_one($req, $param_name, $type, $only = null)
    {
        if ($only == null) {
            $only = ['get', 'post'];
        }

        $val = null;
        foreach($only as $method) {
            $val = $val? $val: self::extract_param($req, $param_name, $method);
        }

        $is_valid = true;
        foreach($type as $check) {
            $is_valid = $is_valid && self::$check($val);
            if (!$is_valid) {
                throw new InvalidParamException($param_name . ' did not pass check: ' . $check);
            }
        }



        return $val;

    }

    public static function extract_param($req, $name, $method)
    {
        return $req->{$method}($name, null);
    }

    public static function not_null($param)
    {
        return $param != null;
    }

    public static function is_string($param)
    {
        return $param == null || is_string($param);
    }

    public static function is_number($param) {
        return $param == null || is_numeric($param);
    }
}