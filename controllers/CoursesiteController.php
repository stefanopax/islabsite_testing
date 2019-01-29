<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use app\models\Course;
use app\models\CourseSite;
use app\models\SearchCourseSite;
use app\models\Handles;

/**
 * CoursesiteController implements the CRUD actions for CourseSite model.
 */
class CoursesiteController extends Controller
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
                        'actions' =>  ['view','index','create','update','delete'],
                        'allow' => true,
                        'roles' => ['admin','staff','teacher'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CourseSite models.
     * @return mixed
     */
    public function actionIndex($course)
    {
        if($this->checkUser($course)) {
            $searchModel = new SearchCourseSite();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $course);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'course' => $course,
            ]);
        }
        else {
            return $this->redirect(array('site/index'));
        }
    }

    /**
     * Displays a single CourseSite model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CourseSite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\HttpException
     */
    public function actionCreate()
    {
        $model = new CourseSite();

        if ($model->load(Yii::$app->request->post())){
            if($model->createCourseSite($model->course)){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing CourseSite model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($this->checkUser($model->getCourse())) {

            if($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model
            ]);
        }
        else {
            return $this->redirect(array('site/index'));
        }

    }

    /**
     * Deletes an existing CourseSite model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->softDelete();
        } catch (NotFoundHttpException $e) {
        } catch (\Throwable $e) {
        }

        return $this->redirect(['index', 'course' => $this->findModel($id)->course]);
    }

    /**
     * Finds the CourseSite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CourseSite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = CourseSite::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Check if the user is the manager of the course site
     * @param integer $course
     * @return bool
     */
    protected function checkUser($course)
    {
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
        $handle = new Handles();

        return (isset($role['admin']) || $handle->checkHandles(\Yii::$app->user->identity->getId(), $course));
    }
}
