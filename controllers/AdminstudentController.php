<?php

namespace app\controllers;

use Yii;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Student;
use app\models\SearchStudent;

/**
 * AdminstudentController implements the CRUD actions for Student model.
 */
class AdminstudentController extends Controller
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
                        'actions' => ['view','index','create','update','delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
			 ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchStudent();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
			'student' => Student::findStudent($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new User();
		$stud = new Student();
		
        if ($model->load(Yii::$app->request->post())) {
			$model->generateAuthKey();
			$model->setPassword($model->password);
			if($model->save()){
				$stud->setId($model->getId());
				if($stud->load(Yii::$app->request->post()) && $stud->save()){
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
			else {
                try {
                    $model->delete();
                } catch (StaleObjectException $e) {
                } catch (\Throwable $e) {
                }
            }
			
        }
        return $this->render('create', [
            'model' => $model,
			'stud' => $stud,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$student = Student::findStudent($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->setPassword($model->password);
			if($model->save()){
				$student->setId($model->getId());
				if($student->load(Yii::$app->request->post()) && $student->save()){
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
		}

        return $this->render('update', [
            'model' => $model,
			'student' => $student,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$this->findModel($id)->softDelete($id);
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
