<title>Islab | Admin - Courses</title>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchCourses */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="course-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(isset($role['admin'])) { ?>
        <?= Html::a('Create Course', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create Handles', ['handles/create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'is_active:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{link}',
                'buttons' => [
                    'link' => function ($url, $model, $key) {
                        return Html::a('Teachers', ['handles/index', 'course' => $model->id]);
                    },
                ],
            ],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{link}',
                'buttons' => [
                    'link' => function ($url, $model, $key) {
                            return Html::a('CourseSites', ['coursesite/index', 'course' => $model->id]);
                    },
                ],
            ],

        ],
    ]); ?>

</div>
