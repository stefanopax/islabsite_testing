<title>Islab | Import result</title>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = ('Import Result');
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <h4> Import the exam's results </h4>

<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);?>

    <?= $form->field($modelImport,'fileImport')->fileInput() ?>
 
    <?= Html::submitButton('Import',['class'=>'btn btn-primary']);?>
 
<?php ActiveForm::end();?>