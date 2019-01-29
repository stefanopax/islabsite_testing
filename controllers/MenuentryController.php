<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Menuentry;

class MenuentryController extends Controller
{
	 public function behaviors()
    {
        return [
		'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','changesort'],
                        'allow' => true,
                        'roles' => ['admin','staff','teacher']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Displays a Menuentry model.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex($id)
    {
		return $this->render('index',[
		      'model' => Menuentry::findMenuentry($id),
        ]);
    }

    /**
     * Change the position of the elements in a Menuentry model.
     * @return mixed
     */
    public function actionChangesort()
    {
        try {
            $request = Yii::$app->request;
            $ar = $request->post("item");
            if($ar) {
                $position = 0;
                foreach ($ar as $menu) {
                        $model = Menuentry::findIdentity($menu);
                        $model->setPosition($position);
                        if($model->save()) {
                            echo $menu;
                        }
                        else {
                            return "no";
                        }
                    $position++;
                }
            }
            else {
                return "Error";
            }
        }
        catch (\Error $exception) {
            return var_dump($exception);
        }
        return null;
    }
}