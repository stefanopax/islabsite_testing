<title>Islab | Exam</title>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchExam */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exams';
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="exam-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Exam', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'date',
            'opening_date',
            'closing_date',
            'type',

            ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                            return Html::a('See Subscribers', ['/subscribers', 'exam' => $model->id]);
                            },
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{edit}',
                'buttons' => [
                    'edit' => function ($url,$model,$key) {
                                 return Html::a('Import Student', ['/teacher/import', 'exam' => $model->id]);
                                 },
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        return Html::a('Export Subscribers', ['/teacher/export', 'exam' => $model->id]);
                        },
                    ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{edit}',
                'buttons' => [
                    'edit' => function ($url,$model,$key) {
                        return Html::a('Import Result', ['/teacher/importresult', 'exam' => $model->id] );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
