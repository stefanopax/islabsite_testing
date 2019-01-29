<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use app\widgets\MainMenu;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => '/img/islab_mini.png']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <style>
        /* this keeps the footer fixed to the bottom */
        {
            margin: 0;
            padding: 0;
        }
        html,body{
            height: 100%;
        }
        #container {
            min-height: 100%;
        }
        #main {
            overflow: auto;
            padding-bottom: 100px;
        }
        #footer {
            position: relative;
            height: 100px;
            margin-top: -100px;
            clear: both;
        }
    </style>
    <link rel="icon" href="<?= Url::base(); ?>/img/islab_mini.png" alt="islab_logo" type="image/png" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<?= MainMenu::widget() ?>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? null : null,
]) ?>
<?= Alert::widget() ?>
<div id="container" class="container">
    <div id="main">
    <?= $content ?>
    </div>
</div>
<?php $this->beginBody() ?>
<footer id="footer" class="uk-text-center" style="background-color: orange">
    <div uk-sticky="bottom: true">
        <div class="uk-container uk-container-center">
            <img src="<?= Url::base(); ?>/img/islab_mini.png" alt="islab_logo" width="40" height="40">
            <br><br/>
            Via Celoria 18, 20133 Milano, Italy<br /> Tel +390250316354 Fax +390250316229 Web
            <a href="http://islab.di.unimi.it">http://islab.di.unimi.it</a>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
