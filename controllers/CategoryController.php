<?php

namespace app\controllers\news;

use app\controllers\BaseController;
use Yii;
use app\models\cms\Category;
use app\services\cms\CategoryService;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BaseController
{
    public $layout = 'layout';

    /**
     * 资讯分类列表
     * @return string
     */
    public function actionIndex()
    {
        $service = new CategoryService();
        $dataProvider = $service->getCategoryList();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 创建分类
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();
        $service = new CategoryService;
        if ($model->load(Yii::$app->request->post())) {
            $create_user = $this->getUserInfo();
            $category = array_merge(\Yii::$app->request->post('Category'), [
                'create_by' => $create_user['id']
            ]);

            if (!$service->checkParentCategory($model->parent_category_code)) {
                return $this->render('/common/tips', [
                    'message' =>  '抱歉，当前暂不支持三级及三级以上分类！'
                ]);
            }

            if ($service->addCategory($category)) {
                return $this->redirect(['index']);
            }
            return $this->redirect(\Yii::$app->request->referrer);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categoryList' => $service->getCategoryTree(),
            ]);
        }
    }

    /**
     * 编辑分类
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $service = new CategoryService();
        if ((new Category)->load(\Yii::$app->request->post())) {
            $user = $this->getUserInfo();
            $category = array_merge(\Yii::$app->request->post('Category'), [
                'last_modify_by' => $user['id']
            ]);

            if (!$service->checkParentCategory($category['parent_category_code'])) {
                return $this->render('/common/tips', [
                    'message' =>  '抱歉，当前暂不支持三级及三级以上分类！'
                ]);
            }

            if ($service->saveCategory($id, $category)) {
                return $this->redirect(['index']);
            }
            return $this->redirect(\Yii::$app->request->referrer);
        } else {
            return $this->render('update', [
                'model' => $service->getCategory($id),
                'categoryList' => $service->getCategoryTree(),
            ]);
        }
    }

    /**
     * 删除分类
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionDelete($id)
    {
        $service = new CategoryService;
        if (!$service->childCategoryExists($id)) {
            if ($service->hasNews($id)) {
                $message = '抱歉该分类不能删除，原因：分类下有文章。';
            } else {
                if ($service->deleteCategory($id)) {
                    return $this->redirect(['index']);
                }
            }
        } else {
            $message = '删除失败，原因：该分类下有子分类。';
        }
        return $this->render('/common/tips', [
            'message' => isset($message) ? $message : '删除资讯分类失败。'
        ]);
    }
}
