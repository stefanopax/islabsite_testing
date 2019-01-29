<title>Islab | Admin - Teacher</title>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchStaff */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teacher';
$this->params['breadcrumbs'][] = $this->title;
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Teacher', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'name',
            'surname',
            'is_disabled:boolean',

            ['class' => 'yii\grid\ActionColumn'],
			[
            'class' => 'yii\grid\ActionColumn',
            'template' => '{link}',
            'buttons' => [
                'link' => function ($url, $model, $key) {
                    return Html::a('Menuentries',  ['staffmenuentry/index', 'id' => $model->id]);
					},
				],
			],
        ],
    ]); ?>
</div>
