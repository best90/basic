<?php

namespace app\services\cms;

use app\models\cms\ArticleDetail;
use app\services\BaseServices;

class ArticleDetailService extends BaseServices
{
    /**
     * 获取文章详情
     * @param $id
     * @return string
     */
    public function getArticleDetail($id)
    {
        if (($model = ArticleDetail::findOne($id)) !== null) {
            return $model->detail;
        }
        return '';
    }

    /**
     * 保存文章详情
     * @param $data
     * @return bool
     */
    public function saveArticleDetail($data)
    {
        $ArticleDetailModel = ArticleDetail::findOne($data['uid']);
        if ($ArticleDetailModel === null){
            $ArticleDetailModel = new ArticleDetail();
            $ArticleDetailModel->uid = $data['uid'];
        }
        $ArticleDetailModel->detail = $data['detail'];
        $ArticleDetailModel->detail_view = $data['detail_view'];

        if(isset($data['is_transform'])){
            $ArticleDetailModel->is_transform = $data['is_transform'];
        }

        return $ArticleDetailModel->save();
    }

    /**
     * 删除文章详情
     * @param $id
     * @return bool
     */
    public function deleteArticleDetail($id)
    {
        $model = ArticleDetail::findOne($id);
        if ($model == null){
            return false;
        }
        if ($model->delete()){
            return true;
        }
        return false;
    }
}
