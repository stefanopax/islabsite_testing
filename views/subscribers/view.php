<title>Islab | View subscriber</title>
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Subscribes */

$this->title = $model->exam;
$this->params['breadcrumbs'][] = ['label' => 'Subscribes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="subscribes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'exam' => $model->exam, 'student' => $model->student, 'date' => $model->date], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'exam' => $model->exam, 'student' => $model->student, 'date' => $model->date], [
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
            'exam0.title',
            'user.username',
            'date',
            'result',
        ],
    ]) ?>

</div>
