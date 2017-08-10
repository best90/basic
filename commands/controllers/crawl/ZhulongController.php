<?php
/**
 * Created by PhpStorm.
 * User: zhengjq
 * Date: 2017/8/8
 * Time: 11:16
 */

namespace app\commands\controllers\crawl;

use app\commands\controllers\CrawlerController;
use app\commands\crawlers\CrawlerConfig;
use app\commands\crawlers\models\ZhulongDetailPage;
use app\commands\crawlers\models\ZhulongGroupList;
use app\models\news\Crawl;
use app\models\news\CrawlDetail;
use app\utils\DateTimeUtil;


class ZhulongController extends CrawlerController
{
    public function init()
    {
        parent::init();
        $this->crawlConfig = CrawlerConfig::getConfig('zhulong');
    }

    /**
     * 详情抓取
     */
    public function actionDetail()
    {
        $this->snoopy->referer = $this->crawlConfig['domain'];

        $pageList = ZhulongDetailPage::find()->where(['is_crawled' => 0])->limit(100)->asArray()->all();

        while($pageList){
            $item = array_shift($pageList);
            $url = 'http://bbs.zhulong.com'.$item['page_url'];
            echo $url.PHP_EOL;
            if ($this->snoopy->fetch($url)){
                $article = $this->getArticleInfo($this->snoopy->results);
                $content = $this->filterMoreContent($article['content']);
                if (mb_strlen(strip_tags($content)) > 300){
                    $crawlNewsModel = new Crawl();
                    $crawlNewsModel->title = explode('-',$article['title'])[0];
                    $crawlNewsModel->category_id = '0';
                    $crawlNewsModel->is_top = 0;
                    $crawlNewsModel->is_show = 0;
                    $crawlNewsModel->source = '筑龙网';
                    $crawlNewsModel->crawl_site_id = 1;
                    $crawlNewsModel->tag = trim($article['tag']);
                    $crawlNewsModel->digest = preg_replace('/\[.*?\]/','', $article['digest']);
                    $crawlNewsModel->create_time = DateTimeUtil::now();
                    $crawlNewsModel->content = $content;

                    if ($crawlNewsModel->save()){
                        $crawlDetailModel = new CrawlDetail();
                        $crawlDetailModel->uid = $crawlNewsModel->uid;
                        $crawlDetailModel->detail = $content;
                        $crawlDetailModel->save();

                        $pageModel = ZhulongDetailPage::findOne($item['pid']);
                        $pageModel->is_crawled = 1;
                        $pageModel->crawled_time = DateTimeUtil::now();
                        $pageModel->save();
                    }
                }else{
                    $pageModel = ZhulongDetailPage::findOne($item['pid']);
                    $pageModel->is_crawled = 1;
                    $pageModel->crawled_time = DateTimeUtil::now();
                    $pageModel->save();
                }
            }
            sleep(mt_rand(5,12));
            if (empty($pageList)){
                $pageList = ZhulongDetailPage::find()->where(['is_crawled' => 0])->limit(100)->asArray()->all();
            }
        }

        if(!empty($this->snoopy->error)){
            echo "error fetching document: ".$this->snoopy->error."\n";
        }
    }

    /**
     * 更新抓取列表
     */
    public function actionList()
    {
        $groupPageList = ZhulongGroupList::find()->asArray()->all();
        foreach ($groupPageList as $item){
            $this->snoopy->referer = $item['group_url'];

            //定时更新抓取
            if ($item['is_all_crawled'] == 1){
                echo 'Crawl: '.$item['group_url'].PHP_EOL;
                if($this->snoopy->fetch($item['group_url'])) {
                    $groupPageInfo = $this->getNextCrawlInfo($this->snoopy->results,'listPage');

                    if (isset($groupPageInfo['url']) && $groupPageInfo['url']){
                        foreach ($groupPageInfo['url'] as $page){
                            $this->saveDetailList([
                                'page_url' => $page
                            ]);
                        }
                    }
                }
            }else{
                //整站抓取
                while ($item['crawl_page_num'] <= $item['group_page_num']){
                    $url = $item['group_url'].'/p'.$item['crawl_page_num'].'.html';
                    echo 'Crawl: '.$url.PHP_EOL;
                    if($this->snoopy->fetch($url)) {
                        $groupPageInfo = $this->getNextCrawlInfo($this->snoopy->results,'listPage');

                        if (isset($groupPageInfo['url']) && $groupPageInfo['url']){
                            foreach ($groupPageInfo['url'] as $page){
                                $this->saveDetailList([
                                    'page_url' => $page
                                ]);
                            }
                        }

                        //更新抓取页码
                        $model = ZhulongGroupList::findOne($item['gid']);
                        $model->is_all_crawled = ($item['crawl_page_num'] + 1) > $item['group_page_num'] ? 1 : 0;
                        $model->crawl_page_num = ($item['crawl_page_num'] + 1) > $item['group_page_num'] ? $item['crawl_page_num'] : $item['crawl_page_num'] + 1;
                        $model->save();

                        $item['crawl_page_num']++;
                    }
                    sleep(1);
                    //sleep(mt_rand(5,12));
                }
            }
        }

        if(!empty($this->snoopy->error)){
            echo "error fetching document: ".$this->snoopy->error."\n";
        }
    }

    /**
     * 抓取首页
     */
    public function actionIndex()
    {
        $url = $this->crawlConfig['domain'];
        $this->snoopy->referer = "https://www.zhulong.com";

        if($this->snoopy->fetch($url)) {
            $rootPageInfo = $this->getNextCrawlInfo($this->snoopy->results,'homePage');
            $groupPageList = $rootPageInfo['url'] ? array_unique($rootPageInfo['url']) : [];

            $listModel = new ZhulongGroupList();
            foreach ($groupPageList as $page){
                $page = 'http://bbs.zhulong.com'.$page;
                echo $page.PHP_EOL;
                if ($this->snoopy->fetch($page)){
                    $groupPageInfo = $this->getNextCrawlInfo($this->snoopy->results,'listPage');
                }
                if (!ZhulongGroupList::findOne(['group_url' => $page])){
                    $listModel->group_url = $page;
                    $listModel->group_page_num = isset($groupPageInfo) ? $groupPageInfo['page'] : 1;
                    $listModel->save();
                }
                sleep(mt_rand(5,10));
            }
        }else{
            echo "error fetching document: ".$this->snoopy->error."\n";
        }
    }

    /**
     * 保存文章列表信息
     * @param $attributes
     */
    protected function saveDetailList($attributes)
    {
        if (!ZhulongDetailPage::findOne(['page_url' => $attributes['page_url']])){
            $model = new ZhulongDetailPage();
            foreach ($attributes as $key => $val){
                $model->$key = $val;
            }
            $model->is_crawled = isset($attributes['is_crawled']) ? $attributes['is_crawled'] : 0;
            $model->save();
        }
    }

    protected function filterMoreContent($string)
    {
        $string = preg_replace("/div>标签.*?<\//si","div></",$string);
        $string = preg_replace("/novip=\".*?\"[ ]/si","",$string);
        return $string;
    }
}