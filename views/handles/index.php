<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchHandles */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Handles';
$this->params['breadcrumbs'][] = $this->title;
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="handles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user.username',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        $url = Url::to(['handles/delete', 'staff' => $model->staff, 'course' => $model->course]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title'        => 'delete',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method'  => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
