<title>Islab | Admin - View teacher</title>
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $staff app\models\Staff */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if(isset($role['admin'])){ ?>
            <?=Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])?>
        <?php	} ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'password',
            'authkey',
            'name',
            'surname',
            'is_disabled:boolean',
        ],
    ]) ?>
	 <?= DetailView::widget([
        'model' => $staff,
        'attributes' => [
            'cellphone',
            'phone',
			'mail',
            'room', 
            'address',
            'image',
            'fax',
            'role',
            'description',
			'link',
        ],
    ]) ?>

</div>
