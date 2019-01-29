<title>Islab | Staff - Menuentry</title>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchMenuEntry */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menuentries';
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="menuentry-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Menuentry', ['create'], ['class' => 'btn btn-success']) ?>
		<?php if( (isset($role['staff'])) or (isset($role['teacher'])) ) { ?>
			<?= Html::a('Order Menuentry', ['/menuentry', 'id' => Yii::$app->user->identity->getId()], ['class' => 'btn btn-success']) ?>
			<?php	} ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'link',
            'content',
            'position',
            'is_deleted:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
