<?php

namespace app\controllers;

use Yii;
use app\models\user\UserAccount;
use app\services\user\UserService;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for UserAccount model.
 */
class UserController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserService();
        $searchParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($searchParams);

        return $this->render('index', [
            'searchParams' => $searchParams,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing UserAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdatePassword($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request->post('UserAccount');
            $md5password = md5($request['password']);
            $passwordHash = \Yii::$app->getSecurity()->generatePasswordHash($md5password, 4); //增加加密随机盐值

            if (!UserService::updateUserAccount(['mobile' => $request['mobile']], ['password' => $passwordHash])) {
                $refer = Yii::$app->request->getReferrer();
            }
            return $this->redirect(!empty($refer) ? $refer : ['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the UserAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserAccount::findOne(['user_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
