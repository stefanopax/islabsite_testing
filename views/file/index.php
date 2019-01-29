<title>Islab | File</title>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchFile */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
$this->beginContent('@app/views/layouts/rolenavbar.php');
$this->endContent();
?>
<div class="file-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create File', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'is_public:boolean',

            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
             'template' => '{copy}',
             'buttons' => [
                'copy' => function($url,$model) {
                    return '
                        <Input type = hidden value = "file/download?file='.$model->id.'" id="down'.$model->id.'">
                    <button onclick="myFunction(\'down'.$model->id.'\')" >  Copy </button>';
                    }],
            ],
        ],
    ]); ?>
</div>
<script>
function myFunction($id) {
    alert($id);
    var copyText = document.getElementById($id);
    copyText.select();
    document.execCommand("copy");
    alert("Copied the text: " + copyText.value);
}
</script>
