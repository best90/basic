<?php

namespace app\models;

use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SupplierForm extends Model
{
    public $company_name;
    public $main_services;
    public $reg_capital;
    public $area_name;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['company_name', 'main_services'], 'required'],
            ['reg_capital', 'integer'],
            ['area_name','string']
        ];
    }
}
