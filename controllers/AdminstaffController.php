<?php

namespace app\controllers;

use Yii;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use app\models\User;
use app\models\Staff;
use app\models\SearchStaffAdmin;
use yii\web\UploadedFile;

/**
 * AdminstaffController implements the CRUD actions for Staff model.
 */
class AdminstaffController extends Controller
{
    private $rolebase = 'staff';

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
						'roles' => ['staff'],
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
        $searchModel = new SearchStaffAdmin();
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
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
		$role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
		if(isset($role['admin'])) {
			return $this->render('view', [
				'model' => $this->findModel($id),
				'staff' => Staff::findStaff($id)
			]);
		}
		else {
			if($id != Yii::$app->user->identity->getId() ) {
				throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
				}
			else {
				return $this->render('view', [
					'model' => $this->findModel($id),
					'staff' => Staff::findStaff($id)
				]);
			}
		}
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\Exception
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionCreate()
    {
        $model = new User();
		$staff = new Staff();

         if ($model->load(Yii::$app->request->post())) {
			$model->generateAuthKey();
			$model->setPassword($model->password);
			if($model->save()) {
                $staff->imageFile = UploadedFile::getInstance($staff, 'image');
				$staff->setId($model->getId());
                $staff->image = "/img/staff".$staff->getId();
                $staff->image .= UploadedFile::getInstance($staff, 'image')->getBaseName().".".UploadedFile::getInstance($staff, 'image')->getExtension();
				if($staff->save() && $staff->upload($staff->id)) {
                    $staff->assignRole($this->rolebase);
                    return $this->redirect(['view', 'id' => $staff->id]);
                }
                else
                    $staff->delete();
            }
			$model->delete();
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
     * @throws \yii\base\Exception
     * @throws \Throwable
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$staff = Staff::findStaff($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->generateAuthKey();
            $model->setPassword($model->password);
            if($model->save()) {
                $staff->imageFile = UploadedFile::getInstance($staff, 'image');
                $staff->setId($model->getId());
                $staff->image = "/img/staff".$staff->getId();
                $staff->image .= UploadedFile::getInstance($staff, 'image')->getBaseName().".".UploadedFile::getInstance($staff, 'image')->getExtension();
                if($staff->save() && $staff->upload($staff->id)) {
                    $staff->assignRole($this->rolebase);
                    return $this->redirect(['view', 'id' => $staff->id]);
                }
                else
                    $staff->delete();
            }
            $model->delete();
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
