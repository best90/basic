<?php

namespace app\controllers;

use app\models\Supplier;
use app\models\SupplierForm;
use Yii;
use app\models\SupplierSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SupplierController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new SupplierSearch();
        $provider = $model->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'title' => '供应商列表',
            'list' => $model,
            'provider' => $provider
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'title' => '供应商详情',
            'supplier' => (new Supplier)->getSupplier($id)
        ]);
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->request->isPost){
            $info = new SupplierForm();
            $info->load(Yii::$app->request->post());
            print_r(Yii::$app->request->post());
            if ($info->validate()){
                if ($id == Yii::$app->request->post()['Supplier']['supplier_id']){
                    $model = new Supplier();
                    if(!$model->updateSupplier($id, Yii::$app->request->post()['Supplier'])){
                        echo '编辑失败，请重试！';
                    }
                    return $this->redirect(Yii::$app->request->getReferrer());
                }else{
                    print_r('请求参数错误！');
                }
            }else{
                $errors = $info->errors;
                print_r($errors);
            }
        }else{
            return $this->render('update', [
                'title' => '供应商详情',
                'supplier' => (new Supplier)->getSupplier($id)
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = new Supplier();
        if($model->deleteSupplier($id)){
            Yii::$app->getSession()->setFlash('success','删除成功！');
        }else{
            Yii::$app->getSession()->setFlash('success','删除失败,请重试！');
        }
        return $this->redirect(Yii::$app->request->getReferrer());
    }
}
