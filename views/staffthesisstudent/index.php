<title>Islab | Staff - Requested thesis</title>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchRequest */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requested Thesis';
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create A Request', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        //'tableOptions'=> ['class' => 'uk-table uk-table-striped uk-table-divider uk-table-middle uk-text-center my-table uk-table-responsive'],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'student',
                'value' => 'student0.register_id',
            ],
            ['attribute'=>'thesis',
                'value' => 'thesis0.title',
            ],
            'title',
            'confirmed_at:boolean',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
