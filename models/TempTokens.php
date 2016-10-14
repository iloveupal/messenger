<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\utils\TokensUtil;

/**
 * This is the model class for table "temp_tokens".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $magic_token
 * @property string $token
 *
 * @property Users $user
 */
class TempTokens extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'temp_tokens';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['magic_token', 'token'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'magic_token' => 'Magic Token',
            'token' => 'Token',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserIdentity::className(), ['id' => 'user_id']);
    }

    public static function create(IdentityInterface $user)
    {
        $token = new self();
        $token->user_id = $user->getId();

        $magic_link = new MagicLink();

        $token->magic_token = $magic_link->raw;
        $raw_token = TokensUtil::generateRawToken($user->getId());
        $token->token = TokensUtil::encryptToken($raw_token);

        return $token->save()? $raw_token: null;
    }

    public static function activate($token) {
        $token = self::findOne([
            'magic_token' => $token
        ]);

        if (!$token) {
            return false;
        }

        $token->toTemporaryToken()->save();
        $token->delete();

        return true;
    }

    public function toTemporaryToken() {
        $token = new Tokens();
        $token->scope = '';
        $token->token = $this->token;
        $token->user_id = $this->user_id;
        return $token;
    }

    public function afterSave($insert, $changedAttributes) {
        $magic_link = MagicLink::getOne($this->magic_token);
        $magic_link->send(AdminIdentity::getAdminIdentities('lechat'), $this->user);
    }
}
