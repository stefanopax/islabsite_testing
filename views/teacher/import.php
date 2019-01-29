<title>Islab | Import</title>
<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = ('Import Student');
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <h4> Import of the subscribed student for the exam </h4>

<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);?>

    <?= $form->field($modelImport,'fileImport')->fileInput() ?>
 
    <?= Html::submitButton('Import',['class'=>'btn btn-primary']);?>
 
<?php ActiveForm::end();?>