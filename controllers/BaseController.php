<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UnauthorizedHttpException;

class BaseController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                //'denyCallback' => function ($rule, $action) {
                //    throw new \Exception('You are not allowed to access this page');
                //}
            ],
        ];
    }

    /**
     * 获取当前用户信息
     * @return array
     */
    protected function getUserInfo(){
        $user = Yii::$app->user->identity;
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }


    protected function checkActionRights($rightsCode,$msg='对不起，您没有此项目权限！') {
        if (!Yii::$app->user->can($rightsCode)){
            throw new UnauthorizedHttpException($msg);
        }
    }
}
