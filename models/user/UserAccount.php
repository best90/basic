<?php

namespace app\models\user;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_account".
 *
 * @property string $account_id 帐号ID
 * @property string $user_id 用户UID
 * @property string $account 网站帐号默认情况按规则生成
 * @property string $mobile 手机号
 * @property string $email 邮箱
 * @property string $password
 * @property string $created_time
 * @property string $last_modified_time
 * @property string $password_bak
 * @property string $salt_password_bak
 * @property int $is_add_password_salt
 */
class UserAccount extends ActiveRecord
{
    public $repeat_password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'string', 'length' => [6, 20]],
            [['password','repeat_password'], 'required'],
            ['repeat_password', 'compare', 'compareAttribute' => 'password', 'operator' => '===','message'=>'两次密码不一致，请重新输入。'],
            [['created_time', 'last_modified_time'], 'safe'],
            [['is_add_password_salt'], 'integer'],
            [['account_id', 'user_id', 'account', 'email', 'password_bak'], 'string', 'max' => 40],
            [['mobile'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => 'Account ID',
            'user_id' => '用户ID',
            'account' => 'Account',
            'mobile' => '手机号码',
            'email' => '邮箱',
            'password' => '密码',
            'repeat_password' => '重复密码',
            'created_time' => '注册日期',
            'last_modified_time' => 'Last Modified Time',
            'password_bak' => 'Password Bak',
            'salt_password_bak' => 'Salt Password Bak',
            'is_add_password_salt' => 'Is Add Password Salt',
        ];
    }

}
