<?php

namespace app\services\category;

use app\common\utils\DateTime;
use app\common\utils\Tree;
use app\models\cms\Article;
use Yii;
use app\services\BaseServices;
use app\models\cms\Category;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;


/**
 * CategoryService represents the model behind the search form of `app\models\Category`.
 */
class CategoryService extends BaseServices
{

    /**
     * 获取资讯分类列表
     * @return bool|\yii\data\ArrayDataProvider
     */
    public function getCategoryList()
    {
        try{
            $sql = <<<SQL
                    SELECT 
                    category_code,
                    category_name,
                    parent_category_code,
                    is_show,
                    rank,
                    create_by,
                    create_time,
                    u.name as user_name
                    FROM b2b_news.category c
                    LEFT JOIN dotnet_operation.op_user u ON u.id = c.create_by
                    ORDER BY rank ASC
SQL;
            $result = Yii::$app->db->createCommand($sql, [])->queryAll();
        }catch (\Exception $e){
            return false;
        }

        $treeObj = new Tree(ArrayHelper::toArray($result));
        $treeObj->icon = ['　　│ ', '　　├─ ', '　　└─ '];
        $treeObj->nbsp = ' ';
        $dataProvider = new ArrayDataProvider([
            'allModels' => $treeObj->getGridTree(0,'category_code','parent_category_code','category_name'),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $dataProvider;
    }


    /**
     * 获取分类树
     * @return array
     */
    public function getCategoryTree()
    {
        try{
            $sql = <<<SQL
                    SELECT 
                    category_code,
                    category_name,
                    parent_category_code,
                    rank
                    FROM b2b_news.category ORDER BY rank ASC
SQL;
            $result = Yii::$app->db->createCommand($sql, [])->queryAll();
        }catch (\Exception $e){
            return [];
        }

        $treeObj = new Tree(ArrayHelper::toArray($result));
        $treeObj->icon = ['　　│ ', '　　├─ ', '　　└─ '];
        $treeObj->nbsp = ' ';
        $treeList = $treeObj->getGridTree(0,'category_code','parent_category_code','category_name');
        $treeList = ArrayHelper::map($treeList,'category_code','category_name');

        return $treeList;
    }

    /**
     * 添加分类
     * @param $data
     * @return bool
     */
    public function addCategory($data){
        $model = Category::find()->where(['category_name' => $data['category_name']])->one();
        if ($model == null){
            $model = new Category();
            foreach ($data as $key => $value){
                if($value != '') $model->$key = $value;
            }
            $model->create_time = DateTime::now();
            if ($model->save()) return true;
        }

        return false;
    }

    /**
     * 获取分类
     * @param $id
     * @return Category
     * @throws NotFoundHttpException
     */
    public function getCategory($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /***
     *  删除分类
     * @param $id
     * @return bool
     */
    public function deleteCategory($id){
        $model = Category::findOne($id);
        if ($model == null){
            return false;
        }
        if ($model->delete()){
            return true;
        }
        return false;
    }

    /**
     * 保存分类
     * @param $id
     * @param $data
     * @return bool
     */
    public function saveCategory($id, $data){
        $model = Category::findOne($id);
        if($model !== null){
            foreach ($data as $key => $value){
                $model->$key = $value;
            }
            $model->last_modify_time = DateTime::now();
            if($model->save()) return true;
        }
        return false;
    }

    /**
     * 是否存在子分类
     * @param $id
     * @return bool
     */
    public function childCategoryExists($id)
    {
        $model = Category::findOne(['parent_category_code' => $id]);
        return $model !== null ? true : false;
    }

    /**
     * 获取子分类id(二级)
     * @param $pid
     * @return array
     */
    public function getChildCategory($pid)
    {
        $model = Category::findAll(['parent_category_code' => $pid]);
        return array_column(ArrayHelper::toArray($model),'category_code');
    }

    /**
     * 分类下是否有文章
     * @param $id
     * @return bool
     */
    public function hasNews($id)
    {
        $model = Article::findOne(['category_id' => $id,'is_delete' => 0]);
        return $model !== null ? true : false;
    }


    /**
     * 检查上级分类级别
     * @param $pid
     * @return bool
     */
    public function checkParentCategory($pid)
    {
        if($pid != 0){
            $category = Category::find()->where(['category_code' => $pid])->one();
            if ($category->parent_category_code != 0){
                return false;
            }
        }
        return true;
    }
}
