<?php

namespace app\controllers;

class DemoController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'shiyang\umeditor\UMeditorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        /*if($_FILES['file']['tmp_name']){
            $filename = $_FILES['file']['tmp_name'].$_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'],$filename);
            $file = [
                'image' => new \CURLFile($filename),
            ];
        }*/
        return $this->render('index',[
            'model' => null,
        ]);
    }
}
