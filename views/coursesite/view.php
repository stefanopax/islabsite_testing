<title>Islab | View course site</title>
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CourseSite */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Course Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="course-site-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'edition',
            'opening_date',
            'closing_date',
            'css:ntext',
            'is_current:boolean',
            'course',
        ],
    ]) ?>

</div>
