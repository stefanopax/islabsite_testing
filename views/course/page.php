<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = ('CREATE COURSE SITE');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'edition',
            'opening_date',
            'closing_date',
            'css',
            'is_current:boolean',
            'course',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>