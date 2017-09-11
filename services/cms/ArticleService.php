<?php

namespace app\services\cms;

use app\models\cms\Article;
use app\models\cms\ArticleDetail;
use app\models\cms\Category;
use app\models\cms\CrawlSite;
use app\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * NewsService represents the model behind the search form of `app\models\News`.
 */
class ArticleService extends Article
{
    public $from;
    public $to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'view_num', 'is_top', 'is_show'], 'integer'],
            [['title', 'category_id', 'top_time', 'author', 'source', 'crawl_site_id', 'tag', 'digest', 'meta_title', 'meta_description', 'accessory_url', 'img_src','is_delete', 'create_by', 'create_time', 'last_modify_time', 'last_modify_by'], 'safe'],
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
        $query = Article::find();
        $query->joinWith(['category'],['category_code','category_name','is_show as category_show']);
        $query->joinWith(['user']);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'create_time' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);
        $this->from = isset($params['ArticleService']['from']) ? $params['ArticleService']['from'] : '';
        $this->to = isset($params['ArticleService']['to']) ? $params['ArticleService']['to'] : '';

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'uid' => $this->uid,
            'is_top' => $this->is_top,
            'news.is_show' => $this->is_show,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'news.create_by', $this->create_by])
            ->andFilterWhere(['=','news.is_delete', '0']);

        $category = Category::findOne($this->category_id);
        if (isset($category->parent_category_code) && $category->parent_category_code == 0){
            $category_ids = (new CategoryService)->getChildCategory($this->category_id);
            array_push($category_ids, $this->category_id);
            $query->andFilterWhere(['IN', 'category_id', $category_ids]);
        }else{
            $query->andFilterWhere(['like', 'category_id', $this->category_id]);
        }

        if ($this->source == 1){
            $query->andFilterWhere(['=','crawl_site_id', '0']);
        }else if ($this->source == 2){
            $query->andFilterWhere(['>','crawl_site_id', '0']);
        }

        if ($this->crawl_site_id){
            $query->andFilterWhere(['like', 'crawl_site_id', $this->crawl_site_id]);
        }

        if ($this->from){
            $query->andFilterWhere(['>=', 'news.create_time', $this->from.' 00:00:00']);
        }

        if ($this->to){
            $query->andFilterWhere(['<=', 'news.create_time', $this->to.' 23:59:59']);
        }

        return $dataProvider;
    }

    /**
     * 批量删除文章
     * @param array $ids
     * @return bool
     */
    public function batchDeleteNews(array $ids)
    {
        if (Article::deleteAll(['uid' => $ids])){
            ArticleDetail::deleteAll(['uid' => $ids]);
            return true;
        }
        return false;
    }

    /**
     * 批量修改文章
     * @param array $ids
     * @param array $params
     * @return bool
     */
    public function batchUpdateNews(array $ids,array $params)
    {
        $condition = [
            'uid' => $ids
        ];
        if (Article::updateAll($params, $condition)){
            return true;
        }
        return false;
    }

    /**
     * 获取创建人map
     * @return array
     */
    public function getCreateUserMap()
    {
        $result = Article::findBySql('SELECT DISTINCT create_by FROM b2b_news.news')->asArray()->all();
        $createUserIds = array_column($result,'create_by');
        $users = User::findAll(['id' => $createUserIds]);

        return $result ? ArrayHelper::map(ArrayHelper::toArray($users),'id','name') : [];
    }

    /**
     * 获取抓取站点
     * @return array
     */
    public function getCrawlSites()
    {
        $result = CrawlSite::findBySql('SELECT DISTINCT crawl_site_id FROM b2b_news.news')->asArray()->all();
        $siteIds = array_column($result,'crawl_site_id');
        $crawlSites = CrawlSite::findAll(['site_id' => $siteIds]);

        return $result ? ArrayHelper::map(ArrayHelper::toArray($crawlSites),'site_id','site_url') : [];
    }


    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public  function  getNews($id){
        return Article::find(['uid'=>$id])->one();
    }
}
