<title>Islab | Edizioni precedenti</title>
<?php

use yii\helpers\Html;

/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $model app\models\Course */
/* @var $courses app\models\CourseSite[] */

$this->params['breadcrumbs'][] = $this->title;
?>
<h2>Edizioni precedenti di <?= strtolower(Html::encode($model->title)) ?>:</h2>
<div>
    <table class="uk-table">
        <tbody>
        <tr>
            <td><b>Edizione</b></td>
            <td><b>Data apertura</b></td>
            <td><b>Data chiusura</b></td>
            <td></td>
        </tr>
        <?php
        foreach ($courses as $course) {
            if(!$course['is_current']) {
                echo '<tr>
                        <td>' . $course['edition'] . '</td>
                        <td>' . $course['opening_date'] . '</td>
                        <td>' . $course['closing_date'] . '</td>
                        <td>' . Html::a('Vai al corso', ['/course/pastcourse', 'id' => $course->id], ['class' => 'uk-button uk-button-primary']) . '</td>
                      </tr>
            ';
            }
        }
        ?>
        </tbody>
    </table>
</div>

<br></br>