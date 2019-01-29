<title>Islab | Student - Home</title>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $student app\models\Student */
/* @var $courses app\models\CourseSite[] */
/* @var $allcourses app\models\CourseSite[] */
/* @var $exams app\models\Exam[] */
/* @var $my_thesis app\models\Thesis[] */
/* @var $model app\models\Registers */

$this->title = ('Home');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p> Benvenuto/a
        <?= Yii::$app->user->identity->getName() ?> <?= Yii::$app->user->identity->getSurname() ?>,
        <?= Html::a('qui', ['/thesis/index'], ['data' => ['method' => 'post']]) ?>
        puoi richiedere una tesi.
    </p>

    <?php
    if($success = Yii::$app->session->getFlash('success')){
        echo '<div class="alert alert-success">' . $success . '</div>';
    }
    if ($warning = Yii::$app->session->getFlash('warning')) {
        echo '<div class="alert alert-warning">' . $warning . '</div>';
    }
    Yii::$app->session->removeAllFlashes();
    ?>
    <?php
    $form = ActiveForm::begin();
    if($allcourses) {
        echo '<h2 style="font-family: Optima">Corsi attivi</h2>';
        echo '
        <table class="uk-table">
            <tbody>
            <tr>
                <td><b>Titolo</b></td>
                <td><b>Edizione</b></td>
                <td><b>Data apertura</b></td>
                <td><b>Data chiusura</b></td>
                <td></td>
            </tr>
        ';
        foreach ($allcourses as $mycourse) {
            $subscribed=false;
            foreach ($courses as $course) {
                if ($mycourse->id==$course->id) {
                    $subscribed=true;
                }
            }
            if ($mycourse->is_current){
                echo '<tr>
                            <td>' . $mycourse->title . '</td>
                            <td>' . $mycourse->edition . '</td>
                            <td>' . $mycourse->opening_date . '</td>
                            <td>' . $mycourse->closing_date . '</td>
                            ';
                if ($subscribed)
                    echo '
                            <td>' . Html::a('Vai al corso', ['/course', 'id' => $mycourse->course], ['class' => 'uk-button uk-button-primary', 'style' => 'background-color: #00ff00;']) . '</td>
                      </tr>
                    ';
                else
                    echo '
                            <td>' . Html::submitButton('Iscriviti al corso', ['class' => 'uk-button uk-button-primary', 'value'=> $mycourse->id, 'name'=>'submit']) . '</td>
                      </tr>
                    ';
            }
        }
        echo'
        
            </tbody>
        </table>
        ';
    }
    if($exams) {
        echo '<h2 style="font-family: Optima">Esami a cui sei iscritto</h2>';
        echo '
        <table class="uk-table">
            <tbody>
                <tr>
                    <td><b>Titolo</b></td>
                    <td><b>Data</b></td>
                    <td><b>Data apertura</b></td>
                    <td><b>Data chiusura</b></td>
                    <td><b>Tipo</b></td>
                    <td><b>Info</b></td>
                </tr>
                ';
                foreach ($exams as $exam){
                    echo '<tr>
                                <td>' . $exam->title . '</td>
                                <td>' . $exam->date . '</td>
                                <td>' . $exam->opening_date . '</td>
                                <td>' . $exam->closing_date . '</td>
                                <td>' . $exam->type . '</td>
                                <td>' . $exam->info . '</td>
                                ';
                }
                echo '
            </tbody>
        </table>';
    }
    if($my_thesis) {
        echo '<h2 style="font-family: Optima">Tesi richieste</h2>';
        echo '
        <table class="uk-table">
            <tbody>
                <tr>
                    <td><b>Titolo</b></td>
                    <td><b>Compagnia</b></td>
                    <td><b>Descrizione</b></td>
                    <td><b>Durata</b></td>
                    <td><b>Requisiti</b></td>
                    <td><b>Corso</b></td>
                    <td><b>N persone</b></td>
                    <td><b>Rif persona</b></td>
                </tr>
                ';
        foreach ($my_thesis as $thesis){
            echo '<tr>
                                <td>' . $thesis->title . '</td>
                                <td>' . $thesis->company . '</td>
                                <td>' . $thesis->description . '</td>
                                <td>' . $thesis->duration . '</td>
                                <td>' . $thesis->requirements . '</td>
                                <td>' . $thesis->course . '</td>
                                <td>' . $thesis->n_person . '</td>
                                <td>' . $thesis->ref_person . '</td>
                                ';
        }
        echo '
            </tbody>
        </table>';

        echo '<br></br>';
    }
    $form = ActiveForm::end();
    ?>
</div>