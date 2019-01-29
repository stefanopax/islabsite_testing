<title>Islab | Staff</title>
<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $menu app\models\Menuentry[] */
/* @var $model app\models\Staff */
/* @var $model app\models\User */


?>
<div class="uk-text-justify" uk-grid>
    <div class="uk-width-3-4@m">
        <div class="uk-card uk-card-default uk-card-body">
            <h5 class="uk-card-title" style="color:orange;"><?= Html::encode ( $user->name ) ?> <?= Html::encode ( $user->surname ) ?></h5>
            <h6 class="uk-card-title" style="color:black;"><?= Html::encode ( $model->role ) ?></h6>
            <p><b>Office: </b><?= Html::encode ( $model->address ) ?></p>
            <p><b>Phone: </b><?= Html::encode ( $model->phone ) ?></p>
            <p><b>Cellphone: </b><?= Html::encode ( $model->cellphone ) ?></p>
            <p><b>Mail: </b><?= Html::mailto(Html::encode($model->mail), Html::encode($model->mail)) ?></p>
            <p><b>Personal page: </b> <?= Html::a($model->link,Yii::getAlias('@web').$model->link) ?></p>
            <p><b>Short description: </b><?= Html::encode ( $model->description ) ?></p>
        </div>
    </div>
    <div class="uk-width-1-4@m">
        <div class="uk-card uk-card-default uk-card-body">
            <ul class="uk-list uk-list-divider">
                <?= Html::img('@web'.$model->image, ['alt'=>'some',
                    'class'=>'thing',
                    'height'=>'300',
                    'width'=>'300'
                ]);?>
                <?php
                foreach ($menu as $entry) {
						if ($entry->content) { ?>
							<li><?= Html::a($entry->title, ['staff/content', 'page'=>$entry->id], ['data' => ['method' => 'post']]) ?></li>
						<?php } // Yii::$app->runAction('MenuEntryController/index', ['string' => $entry->content]);
                    else { ?>
                        <li><?= Html::a($entry->title, Url::to($entry->link, true)); ?></li>
                    <?php }
				}
                ?>
            </ul>
        </div>
    </div>
</div>