<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Handles;
use app\models\Exam;
use app\models\Subscribes;
use app\models\SearchSubscribes;

/**
 * TeacherSubscribersController implements the CRUD actions for Subscribes model.
 */
class SubscribersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST']
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view','delete','update','create'],
                        'allow' => true,
                        'roles' => ['teacher','admin','staff']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Subscribes models.
     * @param integer $exam
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($exam)
    {
        if($this->checkUser($exam)) {
            $searchModel = new SearchSubscribes();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $exam);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'exam' => $exam,
            ]);
        }
        else {
            return $this->redirect(array('site/index'));
        }
    }

    /**
     * Displays a single Subscribes model.
     * @param integer $exam
     * @param integer $student
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($exam, $student)
    {
        return $this->render('view', [
            'model' => $this->findModel($exam, $student)
        ]);
    }

    /**
     * Creates a new Subscribes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $exam
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($exam)
    {
        $model = new Subscribes();
        if($this->checkUser($exam)) {
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'exam' => $model->exam, 'student' => $model->student, 'date' => $model->date]);
            }

            return $this->render('create', [
                'model' => $model,
                'exam' => $exam
            ]);
        }
        else {
            return $this->redirect(array('site/index'));
        }
    }

    /**
     * Updates an existing Subscribes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $exam
     * @param integer $student
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($exam, $student)
    {
        $model = $this->findModel($exam, $student);
        if($this->checkUser($exam)) {
            if($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'exam' => $model->exam, 'student' => $model->student]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }

        else {
            return $this->redirect(array('site/index'));
        }
    }

    /**
     * Deletes an existing Subscribes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $exam
     * @param integer $student
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($exam, $student)
    {
        $this->findModel($exam, $student)->delete();

        return $this->redirect(['index', 'exam' => $exam]);
    }

    /**
     * Finds the Subscribes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $exam
     * @param integer $student
     * @return Subscribes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($exam, $student)
    {
        if(($model = Subscribes::findOne(['exam' => $exam, 'student' => $student])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Exam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Exam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findExam($id)
    {
        if(($model = Exam::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Check if the user is the manager of the course associated to the exam.
     * @param integer $exam
     * @return bool
     * @throws NotFoundHttpException
     */
    protected function checkUser($exam)
    {
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
        $handle = new Handles();

        return (isset($role['admin']) || $handle->checkHandles(\Yii::$app->user->identity->getId(), ($this->findExam($exam))->getCourse()));
    }
}
