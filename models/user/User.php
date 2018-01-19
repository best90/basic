<?php

namespace app\models\user;

use Yii;

/**
 * This is the model class for table "b2b_user.uuc_user".
 *
 * @property string $user_id 用户UID
 * @property string $nick 昵称
 * @property string $name 姓名
 * @property string $user_biz_type 用户业务类型,1:供应2,采购
 * @property int $sex 性别，男1，女2
 * @property string $head_photo 头像
 * @property string $id_card 身份证号码
 * @property string $birthday 生日
 * @property int $status 状态，禁用1，激活2
 * @property string $register_time 创建时间
 * @property string $last_modified_time 最后修改时间
 * @property string $last_modified_by 最后修改人
 * @property int $login_times 登录次数
 * @property string $last_login_time 最后登录时间
 * @property int $error_times 连续的密码输入错误次数，输入成功后清零
 * @property string $last_error_time 上次输入密码错误的时间
 * @property int $user_level 用户级别：0-无，1-认证会员，2-金牌供应商，3-金牌采购商
 * @property string $register_source 注册来源，取值如：PC端、微信
 * @property int $shop_status 个人旗舰店是否开通 1：未开通  2：开通
 * @property string $operate_shop_time 个人旗舰店状态改变的时间
 * @property string $serviceCodeBelong 服务号所属
 * @property string $register_channel 注册渠道，取值如：每日招募
 * @property string $created_by 创建人
 * @property string $register_ip 注册IP地址
 * @property string $connect_wx_code 连接人微信
 * @property string $invite_developer_id 邀请开发商 ID
 * @property int $is_invited 是否邀请认证
 * @property string $last_cert_invite_time 最后邀请认证时间
 * @property string $remark 备注
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['sex', 'status', 'login_times', 'error_times', 'user_level', 'shop_status', 'is_invited'], 'integer'],
            [['birthday', 'register_time', 'last_modified_time', 'last_login_time', 'last_error_time', 'operate_shop_time', 'last_cert_invite_time'], 'safe'],
            [['user_id', 'nick', 'name', 'user_biz_type', 'last_modified_by', 'created_by', 'invite_developer_id', 'remark'], 'string', 'max' => 40],
            [['head_photo'], 'string', 'max' => 60],
            [['id_card'], 'string', 'max' => 20],
            [['register_source'], 'string', 'max' => 10],
            [['serviceCodeBelong'], 'string', 'max' => 45],
            [['register_channel'], 'string', 'max' => 300],
            [['register_ip'], 'string', 'max' => 150],
            [['connect_wx_code'], 'string', 'max' => 50],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '用户ID',
            'nick' => 'Nick',
            'name' => 'Name',
            'user_biz_type' => 'User Biz Type',
            'sex' => 'Sex',
            'head_photo' => 'Head Photo',
            'id_card' => 'Id Card',
            'birthday' => 'Birthday',
            'status' => '会员状态',
            'register_time' => '注册日期',
            'last_modified_time' => 'Last Modified Time',
            'last_modified_by' => 'Last Modified By',
            'login_times' => 'Login Times',
            'last_login_time' => 'Last Login Time',
            'error_times' => 'Error Times',
            'last_error_time' => 'Last Error Time',
            'user_level' => '会员级别',
            'register_source' => '注册来源',
            'shop_status' => 'Shop Status',
            'operate_shop_time' => 'Operate Shop Time',
            'serviceCodeBelong' => 'Service Code Belong',
            'register_channel' => 'Register Channel',
            'created_by' => 'Created By',
            'register_ip' => 'Register Ip',
            'connect_wx_code' => 'Connect Wx Code',
            'invite_developer_id' => 'Invite Developer ID',
            'is_invited' => 'Is Invited',
            'last_cert_invite_time' => 'Last Cert Invite Time',
            'remark' => 'Remark',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccount()
    {
        return $this->hasOne(UserAccount::className(),['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessCardRecord()
    {
        return $this->hasOne(BusinessCardRecord::className(),['user_id' => 'user_id']);
    }
}
