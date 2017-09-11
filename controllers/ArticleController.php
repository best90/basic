<?php

namespace app\controllers\news;

use app\common\utils\DateTime;
use app\controllers\BaseController;
use app\models\cms\Article;
use app\models\cms\CrawlSite;
use app\services\cms\ArticleDetailService;
use app\services\cms\CategoryService;
use Yii;
use app\services\cms\ArticleService;
use yii\web\NotFoundHttpException;

class ArticleController extends BaseController
{
    public $layout = 'layout';

    /**
     * @return array
     */
    public function actions()
    {
        return [
            //编辑器图片上传接口
            'upload'=>[
                'class' => 'app\common\widgets\ueditor\UEditorAction',
                'config' => [
                    'serverUrl' => '', //图片上传Api
                    "imageUrlPrefix"  => '',//图片访问路径前缀
                ]
            ]
        ];
    }
    
    /**
     * 文章列表
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleService();
        
        $searchParams = ['ArticleService' => Yii::$app->request->queryParams];
        $dataProvider = $searchModel->search($searchParams);
        $createUserMap = $searchModel->getCreateUserMap();
        $crawlSites = $searchModel->getCrawlSites();

        $categoryService = new CategoryService;
        return $this->render('index', [
            'sites' => $crawlSites,
            'users' => $createUserMap,
            'searchParams' => $searchParams['ArticleService'],
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryList' => $categoryService->getCategoryTree()
        ]);
    }


    /**
     * 添加文章
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $categoryService = new CategoryService;

        $createUser = $this->getUserInfo();
        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->digest)) $model->digest = mb_substr(strip_tags($model->content),0,200).'...';
            if (empty($model->meta_title)) $model->meta_title = $model->title;
            if (empty($model->meta_description)) $model->meta_description = $model->digest;
            if ($model->tag) $model->tag = str_replace('，', ',', $model->tag);
            //缩略图
            /*if(empty($model->img_src)){
                $model->img_src = $this->thumb($model->content);
            }*/

            if ($model->is_top == 1) {
                $model->top_time = DateTime::now();
            }
            $model->crawl_site_id = 0;
            $model->create_by = $createUser['id'];
            $model->create_time = DateTime::now();
            if ($model->save()) {
                $newsDetailService = new ArticleDetailService;
                $newsDetailService->saveArticleDetail([
                    'uid' => $model->uid,
                    'detail' => $model->content,
                    'detail_view' => $model->content
                ]);

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'user' => $createUser,
            'categoryList' => $categoryService->getCategoryTree()
        ]);
    }

    /**
     * 编辑文章
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categoryService = new CategoryService;
        $newsDetailService = new ArticleDetailService;
        $oldContent = $newsDetailService->getArticleDetail($id);

        $isTop = $model->is_top;
        if ($model->load(Yii::$app->request->post())) {
            $model->tag = $model->tag ? str_replace('，', ',', $model->tag) : '';
            if ($isTop == 0 && $model->is_top == 1) {
                $model->top_time = DateTime::now();
            }

            $modifyUser = $this->getUserInfo();
            $model->last_modify_by = $modifyUser['id'];
            $model->last_modify_time = DateTime::now();

            if ($model->save()) {
                $newsDetail = [
                    'uid' => $id,
                    'detail' => $model->content,
                    'detail_view' => $model->content
                ];
                if (strip_tags($oldContent) != strip_tags($model->content)) {
                    $newsDetail['is_transform'] = 0;
                }
                $newsDetailService->saveArticleDetail($newsDetail);
                return $this->redirect(['index']);
            }
        }

        $site = CrawlSite::findOne($model->crawl_site_id);
        $model->content = $oldContent;
        return $this->render('update', [
            'model' => $model,
            'site' => $site ? $site['site_url'] : '',
            'categoryList' => $categoryService->getCategoryTree()
        ]);
    }


    /**
     * 文章批量操作
     * @return string|\yii\web\Response
     */
    public function actionOperate()
    {
        $ArticleService =  new ArticleService();
        $operateData = Yii::$app->request->post();

        $uidList = explode(',', $operateData['uid']);
        switch ($operateData['operate']) {
            case 'delete':
                $params = [
                    'is_show' => 0,
                    'is_delete' => 1
                ];
                $errorMessage = '文章批量删除操作失败，请重试！';
                break;
            case 'move':
                $params = [
                    'category_id' => $operateData['category_id']
                ];
                $errorMessage = '文章分类移动失败，请重试！';
                break;
            case 'hidden':
                $params = [
                    'is_show' => 0
                ];
                $errorMessage = '文章批量隐藏失败，请重试！';
                break;
            default:
                $params = [];
                $errorMessage = '';
        }
        $modifyUser = $this->getUserInfo();
        if (!$ArticleService->batchUpdateNews($uidList, array_merge($params, [
            'last_modify_by' => $modifyUser['id'],
            'last_modify_time' => DateTime::now()
        ]))) {
            return $errorMessage;
        }
        $refer = Yii::$app->request->getReferrer();
        return $this->redirect($refer ? $refer : ['index']);
    }

    /**
     * 删除文章、详情、标签
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $ArticleService = new ArticleService;
        $modifyUser = $this->getUserInfo();
        if ($ArticleService->batchUpdateNews([$id], [
            'is_show' => 0,
            'is_delete' => 1,
            'last_modify_by' => $modifyUser['id'],
            'last_modify_time' => DateTime::now()
        ])) {
            return $this->redirect(['index']);
        }
        return $this->render('/common/tips', [
            'message' => '操作失败,请重试'
        ]);
    }

    /**
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 提取文章正文缩略图
     * @param $content
     * @return string
     */
    private function thumb($content){
        $imageUrl = '';
        $content = stripslashes($content);
        if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches, 1)) {
            if (isset($matches[3])) {
                $imageUrl = $matches[3] ? $matches[3][0] : '';
            }
        }
        return $imageUrl;
    }
}
