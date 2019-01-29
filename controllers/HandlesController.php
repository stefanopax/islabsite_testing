<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Handles;
use app\models\SearchHandles;

/**
 * HandlesController implements the CRUD actions for Handles model.
 */
class HandlesController extends Controller
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
                        'actions' => ['index','delete','create'],
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
     * Lists all Handles models.
     * @param integer $course
     * @return mixed
     */
    public function actionIndex($course)
    {
        $searchModel = new SearchHandles();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$course);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Handles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Handles();

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'course' => $model->course]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Handles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $staff
     * @param integer $course
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($staff, $course)
    {
        $this->findModel($staff, $course)->delete();

        return $this->redirect(['handles/index', 'course' => $course]);
    }

    /**
     * Finds the Handles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $staff
     * @param integer $course
     * @return Handles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($staff, $course)
    {
        if(($model = Handles::findOne(['staff' => $staff, 'course' => $course])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
