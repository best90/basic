<?php
/**
 * Created by PhpStorm.
 * User: zhengjq
 * Date: 2017/6/23
 * Time: 11:32
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class SupplierSearch extends Supplier
{
    public function search($params)
    {
        $query = Supplier::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}