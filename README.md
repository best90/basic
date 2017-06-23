Yii 2 Note
============================
#### Yii初始化
```
init
```
选择相关环境

#### 数据库查询相关操作
```
User::find()->all();    此方法返回所有数据；

User::findOne($id);   此方法返回 主键 id=1  的一条数据(举个例子)； 

User::find()->where(['name' => '小伙儿'])->one();   此方法返回 ['name' => '小伙儿'] 的一条数据；

User::find()->where(['name' => '小伙儿'])->all();   此方法返回 ['name' => '小伙儿'] 的所有数据；

User::find()->orderBy('id DESC')->all();   此方法是排序查询；

User::findBySql('SELECT * FROM user')->all();  此方法是用 sql  语句查询 user 表里面的所有数据；

User::findBySql('SELECT * FROM user')->one();  此方法是用 sql  语句查询 user 表里面的一条数据；

User::find()->andWhere(['sex' => '男', 'age' => '24'])->count('id');   统计符合条件的总条数；

User::find()->andFilterWhere(['like', 'name', '小伙儿']); 此方法是用 like 查询 name 等于 小伙儿的 数据

User::find()->one();    此方法返回一条数据；

User::find()->all();    此方法返回所有数据；

User::find()->count();    此方法返回记录的数量；

User::find()->average();    此方法返回指定列的平均值；

User::find()->min();    此方法返回指定列的最小值 ；

User::find()->max();    此方法返回指定列的最大值 ；

User::find()->scalar();    此方法返回值的第一行第一列的查询结果；

User::find()->column();    此方法返回查询结果中的第一列的值；

User::find()->exists();    此方法返回一个值指示是否包含查询结果的数据行；

User::find()->batch(10);  每次取 10 条数据 

User::find()->each(10);  每次取 10 条数据， 迭代查询

Customer::find()->asArray()->one();    以数组形式返回一条数据；

Customer::find()->asArray()->all();    以数组形式返回所有数据；

Customer::find()->where($condition)->asArray()->one();    根据条件以数组形式返回一条数据；

Customer::find()->where($condition)->asArray()->all();    根据条件以数组形式返回所有数据；



```

#### 数据库更新相关操作
```
//update();
//runValidation boolen 是否通过validate()校验字段 默认为true 
//attributeNames array 需要更新的字段 

$model->update($runValidation , $attributeNames);  

//updateAll();
//update customer set status = 1 where status = 2

Customer::updateAll(['status' => 1], 'status = 2'); 

//update customer set status = 1 where status = 2 and uid = 1;

Customer::updateAll(['status' => 1], ['status'=> '2','uid'=>'1']);
```

#### 数据库删除相关操作
```
$model = Customer::findOne($id);
$model->delete();

$model->deleteAll(['id'=>1]);

```

#### 数据库批量插入
```
Yii::$app->db->createCommand()->batchInsert(UserModel::tableName(), ['user_id','username'], [
    ['1','test1'],
    ['2','test2'],
    ['3','test3'],   
])->execute();
```

#### 查看执行SQL
```
//UserModel 
$query = UserModel::find()->where(['status'=>1]); 
echo $query->createCommand()->getRawSql();
```

#### 视图变量
 * HTML转义
```
<?php use yii\helpers\Html; ?>

<div class="index-div">
   <h1><?= Html::encode($this->title) ?></h1>
</div>
```
 * 视图渲染
```
render() − 渲染一个视图，并应用布局
renderFile() − 在一个给定的文件路径或别名来渲染视图
renderAjax() − 渲染视图但不使用布局，但所有的注入JS和CSS文件
renderPartial() − 渲染视图，但不使用布局
renderContent() − 渲染一个静态字符串并应用布局

----------------------------------

// 控制器中赋值变量
public function actionIndex()  
{  
    $params = array('title'=>'here is index');
    return $this->render('index', $params);  
}  
```

#### Url生成
* URL管理器
```
// URL：/index.php?r=article/view
\Yii::$app->urlManager->createUrl('article/view');

// URL：/index.php?r=article/view&id=2
\Yii::$app->urlManager->createUrl(['article/view','id'=>2]);

// URL： http://www.example.com?r=kernel/article/view
echo \Yii::$app->urlManager->createAbsoluteUrl('kernel/article/view');

```

* URL 助手类
```
// 创建当前 URL
// 显示：/?r=kernel/article/view&id=10
echo Url::to();

// 创建当前 URL
// 显示：http://www.example.com/?r=kernel/article/view&id=10
echo Url::to('', true);

// 字符参数，没啥用
// 显示：kernel/article/view
echo Url::to('kernel/article/view');

// 创建路由，数组参数的自动调用 Url::toRoute(...)
// 显示：/index.php?r=kernel/article/view
echo Url::to(['article/view']);

--------------------------------------------

// 创建当前路由（仅继承参数r的值）
// 显示：/index.php?r=kernel/article/view
echo Url::toRoute([]);

// 相同的模块和控制器，不同的动作（仅继承参数r的值）
// 显示：/index.php?r=kernel/article/list
echo Url::toRoute('list');

// 相同的模块和控制器，不同的动作（仅继承参数r的值）
// 显示：/index.php?r=kernel/article/list&cat=contact
echo Url::toRoute(['list','cat'=>10]);

// 相同模块，不同控制器和动作（仅继承参数r的值）
// 显示：/index.php?r=kernel/product/index
echo Url::toRoute('product/index');

// 绝对路由，不管是被哪个模块和控制器调用
// 显示：/index.php?r=product/index
echo Url::toRoute('/product/index');

// 控制器动作 `actionListHot` 的 URL 格式（仅继承参数r的值，区分大小写）
// 显示：/index.php?r=kernel/article/list-hot
echo Url::toRoute('list-hot');

// 从别名中获取 URL 
// 显示：http://www.baidu.com/
Yii::setAlias('@baidu', 'http://www.baidu.com/');
echo Url::to('@baidu');

```
