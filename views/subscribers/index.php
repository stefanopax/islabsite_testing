<title>Islab | Subscribers</title>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchSubscribes */
/* @var $exam app\models\Exam */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subscribers';
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="subscribes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Subscribes', ['create','exam'=>$exam] , ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'student',
                'value' => 'student0.register_id',
            ],
            'date',
            'result',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
