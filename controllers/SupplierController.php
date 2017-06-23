<?php

namespace app\controllers;

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

    public function actionDelete()
    {

    }
}
