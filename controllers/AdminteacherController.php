<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Staff;
use app\models\SearchTeacher;

/**
 * AdminstaffController implements the CRUD actions for User model.
 */
class AdminteacherController extends Controller
{
    private $rolebase = 'teacher';

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
					[
						'actions' => ['view','update'],
						'allow' => true,
						'roles' => ['teacher'],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTeacher();
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
			'staff' => Staff::findStaff($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreate()
    {
        $model = new User();
		$staff = new Staff();

         if ($model->load(Yii::$app->request->post())) {
			$model->generateAuthKey();
			$model->setPassword($model->password);
			if($model->save()){
				$staff->setId($model->getId());
				if($staff->load(Yii::$app->request->post()) && $staff->save()) {
					$staff->assignRole($this->rolebase);
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
			else {
				$model->delete();
			}
			
        }

        return $this->render('create', [
            'model' => $model,
			'staff' => $staff,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$staff = Staff::findStaff($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$staff->setId($model->getId());
			if($staff->load(Yii::$app->request->post()) && $staff->save()) {
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }

        return $this->render('update', [
            'model' => $model,
			'staff' => $staff,
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
