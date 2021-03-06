<?php

namespace app\models\cms;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "crawl_article".
 *
 * @property int $uid
 * @property string $title 标题
 * @property int $view_num 查看次数
 * @property string $category_id 所属分类
 * @property int $is_top 是否置顶
 * @property string $top_time 置顶时间
 * @property int $is_show 是否显示： 0 隐藏 1 显示
 * @property int $is_recommend 是否推荐到栏目： 0 不推荐 1 推荐
 * @property string $author 作者
 * @property string $source 来源
 * @property string $crawl_site_id 爬取站点ID
 * @property string $tag 标签：默认空格分离
 * @property string $digest 摘要
 * @property string $meta_title
 * @property string $meta_description
 * @property string $accessory_url 附件URL
 * @property string $img_src 封面SRC
 * @property int $is_delete 是否删除
 * @property string $create_by 创建人
 * @property string $create_time 创建时间
 * @property string $last_modify_time 最后修改时间
 * @property string $last_modify_by 最后修改人
 */
class CrawlArticle extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crawl_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','is_top','is_show','content'], 'required','message' => "{attribute}不能为空"],
            [['category_id'],'required','message' => "请选择资讯分类"],
            [['is_recommend','is_delete','crawl_site_id','accessory_url','top_time','create_by', 'create_time', 'last_modify_by','last_modify_time'], 'safe'],
            [['title', 'source', 'tag', 'img_src'], 'string', 'max' => 255,'message' => '{attribute}超过最大长度200'],
            [['category_id', 'author', 'meta_title'], 'string', 'max' => 100],
            [['digest'], 'string', 'max' => 1000],
            [['meta_description'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'id',
            'title' => '* 标题',
            'view_num' => '阅读量',
            'category_id' => '* 分类',
            'is_top' => '* 置顶',
            'top_time' => '置顶时间',
            'is_show' => '* 显示',
            'is_recommend' => '推荐到栏目广告位',
            'author' => '作者',
            'source' => '来源',
            'crawl_site_id' => '抓取站点id',
            'tag' => '标签',
            'digest' => '摘要',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'accessory_url' => '附件',
            'img_src' => '封面图',
            'is_delete' => '是否删除',
            'create_by' => '创建人',
            'create_time' => '创建时间',
            'last_modify_time' => '修改时间',
            'last_modify_by' => '修改人',
            'content' => '* 正文'
        ];
    }
}
