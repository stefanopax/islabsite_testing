<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\SearchMenuEntry;
use app\models\Menuentry;

/**
 * StaffmenuentryController implements the CRUD actions for Menuentry model.
 */
class StaffmenuentryController extends Controller
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
                        'roles' => ['staff','teacher']
                    ],
					[
						'actions' => ['index','view','update'],
						'allow' => true,
						'roles' => ['admin']
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
     * Lists all Menuentry models.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex($id)
    {
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());

        if(isset($role['admin']) || ($id == \Yii::$app->user->identity->getId())) {
            $searchModel = new SearchMenuEntry();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        else return $this->redirect('site');
    }

    /**
     * Displays a single Menuentry model.
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
     * Creates a new Menuentry model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menuentry();

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menuentry model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());


        if(isset($role['admin']) || ($model->getStaffId() == \Yii::$app->user->identity->getId())) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        else return $this->redirect('site');
    }

    /**
     * Deletes an existing Menuentry model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
        $model = $this->findModel($id);

        if(isset($role['admin']) || ($model->getStaffId() == \Yii::$app->user->identity->getId())) {
            $model->softDelete();

            return $this->redirect(['view', 'id' => $id]);
        }
        else return $this->redirect('site');
    }

    /**
     * Finds the Menuentry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menuentry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = Menuentry::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
