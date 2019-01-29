<?php

use backend\models\Standard;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

?>
<?php
	$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
	if(isset($role['admin'])){
		NavBar::begin([
		'options' => [
			'class' => 'uk-navbar',
			'role' => 'navigation',
			'style' => 'background-color: #CBCACA; color: blue; height: 80px',
			'innerContainerOptions' => ['class' => 'container-fluid'],
		]
	]);
	echo Nav::widget([
			'options' => ['class' => 'uk-navbar-item'],
			'items' => [
				['label' => 'Student', 'url' => ['/adminstudent']],
				['label' => 'Teacher', 'url' => ['/adminteacher']],
				['label' => 'Staff', 'url' => ['/adminstaff']],
				['label' => 'Project', 'url' => ['/adminproject']],
				['label' => 'Thesis', 'url' => ['/adminthesis']],
                ['label' => 'Requested Thesis', 'url' => ['/staffthesisstudent']],
                ['label' => 'Courses', 'url' => ['/admincourses']],
                ['label' => 'Exam', 'url' => ['/exam']]


            ],
	]);
	NavBar::end();
		}
	else {
        if (isset($role['staff'])) {
	NavBar::begin([
		'options' => [
			'class' => 'uk-navbar',
			'role' => 'navigation',
			'style' => 'background-color: #CBCACA; color: blue; height: 80px',
			'innerContainerOptions' => ['class' => 'container-fluid'],
		]
	]);
	echo Nav::widget([
			'options' => ['class' => 'uk-navbar-item'],
			'items' => [
				['label' => 'Personal', 'url' => ['/adminstaff/view', 'id' => Yii::$app->user->identity->getId()]],
				['label' => 'Personal Menu', 'url' => ['/staffmenuentry', 'id' => Yii::$app->user->identity->getId()]],
				['label' => 'Thesis', 'url' => ['/staffthesis']],
				['label' => 'Requested Thesis', 'url' => ['/staffthesisstudent']],
                ['label' => 'Courses', 'url' => ['/admincourses']],
                ['label' => 'Exam', 'url' => ['/exam']]
			],
	]);
	NavBar::end();

        } else {NavBar::begin([
            'options' => [
                'class' => 'uk-navbar',
                'role' => 'navigation',
                'style' => 'background-color: #CBCACA; color: blue; height: 80px',
                'innerContainerOptions' => ['class' => 'container-fluid'],
            ]
        ]);
            echo Nav::widget([
                'options' => ['class' => 'uk-navbar-item'],
                'items' => [
                    ['label' => 'Personal', 'url' => ['/adminteacher/view', 'id' => Yii::$app->user->identity->getId()]],
                    ['label' => 'Personal Menu', 'url' => ['/staffmenuentry', 'id' => Yii::$app->user->identity->getId()]],
                    ['label' => 'Course', 'url' => ['/coursesite', 'course' => '-1']],
                    ['label' => 'Exam', 'url' => ['/exam']]
                ],
            ]);
            NavBar::end();}
    }
?>
		