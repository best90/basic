<?php

namespace app\services\user;

use app\models\user\UserAccount;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\user\User;

/**
 * UserService represents the model behind the search form of `app\models\user\UserAccount`.
 */
class UserService extends User
{
    public $name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','account.created_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();
        $query->joinWith(['userAccount account']);
        $query->joinWith(['businessCardRecord card']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $dataProvider->setSort([
            'defaultOrder' => [
                'register_time' => SORT_DESC,
            ],
            'attributes' => [
                'user_id',
                'status',
                'user_level',
                'register_time',
                'register_source',
                'mobile' => [
                    'asc' => ['account.mobile' => SORT_ASC],
                    'desc' => ['account.mobile' => SORT_DESC],
                    'label' => 'mobile'
                ],
                'name' => [
                    'asc' => ['card.name' => SORT_ASC],
                    'desc' => ['card.name' => SORT_DESC],
                    'label' => 'name'
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (isset($params['keyword'])) {
            $query->filterWhere(['like', 'card.user_id', $params['keyword']])
                ->orFilterWhere(['like', 'account.mobile', $params['keyword']])
                ->orFilterWhere(['like', 'card.name', $params['keyword']])
                ->orFilterWhere(['like', 'card.company_name', $params['keyword']]);
        }

        return $dataProvider;
    }

    /**
     * 修改账号信息
     * @param $condition
     * @param $attribute
     * @return int
     */
    public static function updateUserAccount($condition, $attribute)
    {
        return UserAccount::updateAll($attribute, $condition);
    }
}
