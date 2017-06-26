<?php
/**
 * Created by PhpStorm.
 * User: zhengjq
 * Date: 2017/6/23
 * Time: 10:09
 */

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;

class Supplier extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%bigdata_gold_supplier_model}}';
    }

    public function rules()
    {
        return [
            [['supplier_id','company_name','main_services','certification_time','reg_capital','area_name'],'safe']
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function attributeLables()
    {
        return [
            'supplier_id' => '供应商企业ID',
            'company_name' => '公司名称',
            'main_services' => '主营业务',
            'certification_time' => '认证时间',
            'reg_capital' => '注册资本',
            'area_name' => '地区（省）'
        ];
    }

    public function getSupplier($id)
    {
        return static::findOne([
            'supplier_id' => $id
        ]);
    }

    public function updateSupplier($id, $data)
    {
        $supplier = static::getSupplier($id);
        foreach ($data as $key => $value){
            $supplier->$key = $value;
        }
        return $supplier->save();
    }

    public function deleteSupplier($id)
    {
        $supplier = static::findOne([
            'supplier_id' => $id
        ]);
        if($supplier->delete()){
            return true;
        }
        return false;
    }
}