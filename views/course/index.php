<title>Islab | Course</title>
<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $model app\models\Course */
/* @var $edition app\models\CourseSite */
/* @var $pages app\models\Page[] */
/* @var $subscribed boolean */

$this->params['breadcrumbs'][] = $this->title;
?>
<?php
NavBar::begin();
$items = [];
foreach ($pages as $rows) {
    if(!$rows['is_news'])
        array_push($items, ['label' => $rows['title'], 'url' => 'course?id='.$model->id.'&page='.$rows['title'], 'linkOptions' => ['style' => 'color: orange;']]);
}
echo Nav::widget([
    'options' => ['class' => 'uk-navbar-item', 'style' => 'background-color: blue; color: orange'],
    'items' => $items,
]);
NavBar::end();
?>
<p>
    <h2>
        <center><?= Html::encode($model->title, $edition->edition) ?><center>
    </h2>
</p>
<h4>
    <center>
        <h4><center>A.A. <?= Html::encode($edition->edition) ?> - <a href="<?= Url::to(['course/sites', 'id' => $model->id]); ?>">Edizioni precedenti</a><center></h4>
    <center>
</h4>

<?php
    // Importing feed from external source

    $rss_tags = array(
        'title',
        'description'
    );

    $rss_item_tag = 'item';
    if($edition->feed) {
        $rss_url = $edition->feed;
        $rssfeed = rss_to_array($rss_item_tag, $rss_tags, $rss_url);
    }

    function rss_to_array($tag, $array, $url) {
        $doc = new DOMdocument();
        $doc->load($url);
        $rss_array = array();
        $items = array();
        foreach($doc->getElementsByTagName($tag) AS $node) {
            foreach($array AS $key => $value) {
                $items[$value] = $node->getElementsByTagName($value)->item(0)->nodeValue;
            }
            array_push($rss_array, $items);
        }
        return $rss_array;
    }

    // grab news content
    foreach ($pages as $page)
        if($page['is_news'])
            $news = $page['content'];
    // if page isn't home I have some get params
    if($get = Yii::$app->getRequest()->getQueryParam('page')){
        foreach ($pages as $rows) {
            if ($rows['title'] == $get) {
                if ($rows['is_public'] && !$rows['is_news']) {
                    echo '<div class="uk-grid">
                            <div class="uk-width-2-3">
                                <div class="itp_middle uk-width-1-1 uk-width-medium-3-5">
                                    <div class="itp_section-1 ">
                                        <div class="text">'
                        . $rows['content'] . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-3">
                                <div class="text">';
                    for ($i = 0; $i < count($rssfeed); $i++) {
                        $k = 0;
                        foreach ($rssfeed[$i] as $item) {
                            if ($k == 0) {
                                $k++;
                                echo '<b>' . $item . '</b>';
                            } else
                                echo $item;
                        }
                    }
                    echo $news . '
                                </div>
                            </div>
                        </div>';
                }
                else {
                    if(!$rows['is_news']) {
                        // show protected page only if user is admin/staff/teacher or student is subscribed
                        if (Yii::$app->user->can('admin') ||
                            Yii::$app->user->can('staff') ||
                            Yii::$app->user->can('teacher') ||
                            $subscribed)
                            echo '<div class="uk-grid">
                                    <div class="uk-width-2-3">
                                        <div class="itp_middle uk-width-1-1 uk-width-medium-3-5">
                                            <div class="itp_section-1 ">
                                                <div class="text">'
                                                    . $rows['content'] . '
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-3">
                                        <div class="text">';
                        for($i=0;$i<count($rssfeed);$i++) {
                            $k=0;
                            foreach ($rssfeed[$i] as $item) {
                                if($k==0) {
                                    $k++;
                                    echo '<b>' . $item . '</b>';
                                }
                                else
                                    echo $item;
                            }
                        }
                        echo $news . '
                                        </div>
                                    </div>
                                </div>';
                            Yii::$app->response->redirect(Url::to(['site/login'], true));
                    }
                }
            }
        }
    }
    else {
        foreach($pages as $rows) {
            if($rows['is_home'] == true) {
                echo '<div class="uk-grid">
                            <div class="uk-width-2-3">
                                <div class="itp_middle uk-width-1-1 uk-width-medium-3-5">
                                    <div class="itp_section-1 ">
                                        <div class="text">'
                    . $rows['content'] . '
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-3">
                                <div class="text">';
                for ($i = 0; $i < count($rssfeed); $i++) {
                    $k = 0;
                    foreach ($rssfeed[$i] as $item) {
                        if ($k == 0) {
                            $k++;
                            echo '<b>' . $item . '</b>';
                        } else
                            echo $item;
                    }
                }
                echo $news . '
                                </div>
                            </div>
                        </div>';
            }
        }
    }

?>