<?php

namespace app\widgets;

use Yii;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Course;

class MainMenu extends Widget {

    public function run() {
        NavBar::begin([
            'brandLabel' => Html::img('@web/img/islab_mini.png'),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'uk-navbar',
                'role' => 'navigation',
                'style' => 'background-color: orange; height: 100px',
                'innerContainerOptions' => ['class' => 'container-fluid'],
            ]
        ]);
        try {
            echo Nav::widget([
                'options' => ['class' => 'uk-navbar-item'],
                'encodeLabels' => false,
                'items' => $this->getItems()
            ]);
        } catch (\Exception $e) {
        }
        NavBar::end();
    }

    protected function getItems() {
        return $menuItems = [
            [
                'label' => '<span class="glyphicon glyphicon-home"></span> Home',
                'class' => 'uk-navbar-left',
                'url' => Yii::$app->homeUrl,
                'linkOptions' => ['style' => 'color: #000;']
            ],
            [
                'label' => '<span class="glyphicon glyphicon-pencil"></span> Progetti',
                'url' => ['/project'],
                'class' => 'uk-navbar-left',
                'img' => 'dist/img/user2-160x160.jpg',
                'linkOptions' => ['style' => 'color: #000;']
            ],
            [
                'label' => '<span class="glyphicon glyphicon-user"></span> Staff',
                'url' => ['/staff'],
                'class' => 'uk-navbar-left',
                'img' => 'dist/img/user2-160x160.jpg',
                'linkOptions' => ['style' => 'color: #000;']
            ],
            [
                'label' => '<span class="glyphicon glyphicon-education"></span> Tesi',
                'url' => ['/thesis'],
                'class' => 'uk-navbar-left'	,
                'img' => 'dist/img/user2-160x160.jpg',
                'linkOptions' => ['style' => 'color: #000;']
            ],
            [
                'label' => '<span class="glyphicon glyphicon-tasks"></span> Corsi',
                'linkOptions' => ['style' => 'color: #000;'],
                'items' => $this->getCoursesItems(),
            ],
            [
                'label' => '<span class="glyphicon glyphicon-signal"></span> News',
                'class' => 'uk-navbar-left'	,
                'img' => 'dist/img/user2-160x160.jpg',
                'linkOptions' => ['target'=>'_blank', 'style' => 'color: #000;'],
                'url' => 'http://islab.di.unimi.it/iNewsMail/feed.php?channel=islab'
            ],
            Yii::$app->user->isGuest ? (
            ['label' => '<span class="glyphicon glyphicon-ok"></span> Login', 'class' => 'uk-navbar-left',  'url' => ['/site/login'], 'linkOptions' =>[ 'style' => 'color: #000;']]
            ) : (
                '<li>'
                . Html::a('<span class="glyphicon glyphicon-home"></span> Home('.Yii::$app->user->identity->username.')', [Yii::$app->user->identity->roleBasedHomePage()])
                . '</li>'
                . '<li>'
                . Html::a('<span class="glyphicon glyphicon-remove"></span> Logout', ['site/logout'], ['data' => ['method' => 'post']])
                . '</li>'
                . '</li>'
            )
        ];
    }

    protected function getCoursesItems() {
        $items = [];
        foreach(Course::find()->all() as $course) {
            if($course->is_active) {
                $items[] = [
                    'label' => $course->title,
                    'url' => Url::to(['/course', 'id' => $course->id]),
                ];
            }
        }
        return $items;
    }
}