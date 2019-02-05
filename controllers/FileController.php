<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\File;
use app\models\Registers;
use app\models\SearchFile;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
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
                    [
                        'actions' => ['download'],
                        'allow' => true,
                        'roles' => ['teacher','admin','staff','student']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all File models.
     * @param integer $courseSite
     * @return mixed
     */
    public function actionIndex($courseSite)
    {
        $searchModel = new SearchFile();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $courseSite);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single File model.
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
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreate()
    {
        $model = new File();

        if($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->setExtension($model->imageFile->extension);
                if($model->save()) {
                    if($model->upload($model->id)) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    else $model->delete();
                }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        $model->setExtension($model->imageFile->extension);
        if($model->load(Yii::$app->request->post()) && $model->save(false)) {
            if($model->upload($model->id)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else $model->delete();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->softDelete();

        return $this->redirect(['index']);
    }

    /**
     * Download an existing File model.
     * If download is not allowed, the browser will be redirected to the 'login' page.
     * @param integer $file
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDownload($file)
    {
        $fil = $this->findModel($file);
        $reg = new Registers();
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
        
        if(!(isset($role['admin']) || isset($role['staff']) || isset($role['teacher']))) {
            if($fil->getPublic() && $reg->checkRegister(\Yii::$app->user->identity->getId(),$fil->getCourseSiteId())) {
                return $fil->download($file);
            }
            else {
                $this->redirect(['/site/login']);
             }
        }
        else {
            return $fil->download($file);
        }
        return null;
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = File::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
