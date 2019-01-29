<title>Islab | Staff - Thesis</title>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchThesisStaff */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Theses';
$this->params['breadcrumbs'][] = $this->title;
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="thesis-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Thesis', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'description:ntext',
            'duration',
            'n_person',
            'ref_person',
            'is_visible:boolean',
            'trien:boolean',

            ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        if($model->is_visible)
                            return Html::a('Create Request', ['staffthesisstudent/create0', 'thesis' => $model->id]);
                        return null;
                    },
                ],
            ],
        ]
    ]); ?>
</div>
