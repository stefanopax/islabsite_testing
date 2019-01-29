<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * AdminController render to the admin landing page after login.
 */
class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
		 'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return mixed
     */
    public function actionIndex()
    {
		return $this->render('index');
    }
}

    
   