<?php

namespace app\services\cms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cms\Keyword;

/**
 * KeywordSearch represents the model behind the search form about `app\models\Keyword`.
 */
class KeywordService extends Keyword
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'keyword_length', 'is_valid'], 'integer'],
            [['keyword', 'url', 'create_time'], 'safe'],
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
        $query = Keyword::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'keyword_length' => $this->keyword_length,
            'is_valid' => $this->is_valid,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'keyword', $this->keyword])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
