<title>Islab | Edizione precedente</title>
<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $edition app\models\CourseSite */
/* @var $pages app\models\Page[] */

$this->params['breadcrumbs'][] = $this->title;
?>
<?php
NavBar::begin();
$items = [];
foreach ($pages as $rows) {
    array_push($items, ['label' => $rows['title'], 'url' => 'course?id='.$edition->course.'&page='.$rows['title'], 'linkOptions' => ['style' => 'color: orange;']]);
}
echo Nav::widget([
    'options' => ['class' => 'uk-navbar-item', 'style' => 'background-color: blue; color: orange'],
    'items' => $items,
]);
NavBar::end();
?>

<p><h2><center><?= Html::encode($edition->title, $edition->edition) ?><center></h2></p>


<?php
// grab news content
foreach ($pages as $page) {
    if($page['is_news'])
        $news = $page['content'];
}

// if page isn't home I have some get params
if($get = Yii::$app->getRequest()->getQueryParam('page')) {
    foreach ($pages as $rows) {
        if ($rows['title'] == $get) {
            if ($rows['is_public'] && !$rows['is_news'])
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
                                <div class="text">'
                    .$news . '
                                </div>
                            </div>
                        </div>';
            else {
                if(!$rows['is_news']) {
                    // show protected page only if user is admin/staff/teacher
                    if (Yii::$app->user->can('admin') ||
                        Yii::$app->user->can('staff') ||
                        Yii::$app->user->can('teacher'))
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
                                        <div class="text">'
                            .$news . '
                                        </div>
                                    </div>
                                </div>';
                    else
                        Yii::$app->response->redirect(Url::to(['site/login'], true));
                }
            }
        }
    }
}
else {
    foreach ($pages as $rows) {
        if ($rows['is_home'] == true)
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
                                <div class="text">'
                .$news . '
                                </div>
                            </div>
                        </div>';
    }
}
?>