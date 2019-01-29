<title>Islab | Admin - Student</title>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchStudent */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student';
$this->params['breadcrumbs'][] = $this->title;
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent(); 
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Student', ['create'], ['class' => 'btn btn-success']) ?>
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

            ['class' => 'yii\grid\ActionColumn']
        ],
    ]); ?>
</div>
