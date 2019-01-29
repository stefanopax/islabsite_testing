<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii2tech\spreadsheet\Spreadsheet;
use yii\data\ActiveDataProvider;
use app\models\Subscribes;
use app\models\User;
use app\models\Student;
use app\models\Exam;

class TeacherController extends Controller
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
                        'actions' => ['index','import','exam','export','importresult'],
                        'allow' => true,
                        'roles' => ['teacher','staff','admin']
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
     *
     * @return mixed
     */
    public function actionIndex()
    {
		if(Yii::$app->user->isGuest) {
            return $this->goHome();
        }

		return $this->render('index');
    }
	
	 /**
     * Displays exams.
     *
     * @return mixed
     */
    public function actionExam()
    {
        $model = new Exam();

        return $this->render('exam', ['model' => $model]);
    }

    /**
     * Manage the import of a file.
     *
     * @param integer $exam
     * @return mixed
     * @throws \PHPExcel_Reader_Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
	public function  actionImport($exam)
    {
        $modelImport = new \yii\base\DynamicModel([
                    'fileImport'=>'File Import',
                    ]);
        $modelImport->addRule(['fileImport'],'required');
        $modelImport->addRule(['fileImport'],'file',['extensions'=>'ods,xls,xlsx']);

        if(Yii::$app->request->post()){
            $modelImport->fileImport = UploadedFile::getInstance($modelImport,'fileImport');
            if($modelImport->fileImport && $modelImport->validate()){
                $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                //$model->load(Yii::$app->request->post());
                $baseRow = 2;
                while(!empty($sheetData[$baseRow]['F'])) {
                    if(!(User::findByUsername((string)$sheetData[$baseRow]['F']))) {
                        // create new student and user
                        $user = new User;
                        $student = new Student;
                        $user->setUsername((string)$sheetData[$baseRow]['F']);
                        $user->setName((string)$sheetData[$baseRow]['D']);
                        $user->setSurname((string)$sheetData[$baseRow]['C']);
                        $user->generateAuthKey();
                        if($user->save()) {
                            // create the student
                            $student->setRegister((integer)$sheetData[$baseRow]['B']);
                            $student->setId($user->getId());
                            if(!$student->save()) {
                                $user->delete();
                                Yii::$app->getSession()->setFlash('error','Error');
                            }
                        }
                        else {
                            Yii::$app->getSession()->setFlash('error','Error');
                        }
                    }
                    if((User::findByUsername((string)$sheetData[$baseRow]['F']))) {
                        $user = User::findByUsername((string)$sheetData[$baseRow]['F'])->getId();
                        if (!Subscribes::findByStudentExam($user, $exam)) {
                            $new = new Subscribes();
                            $new->setExam($exam);
                            $new->setStudent($user);
                            $new->setData();
                            if ($new->save()) {
                                $baseRow++;
                            }
                            else {
                                Yii::$app->getSession()->setFlash('error', 'Error on insert');
                            }
                        }
                        else {
                            $baseRow++;
                        }
                    }
                    else {
                        $baseRow++;
                    }
                }
                Yii::$app->getSession()->setFlash('success','Success');
            }
            else {
                Yii::$app->getSession()->setFlash('error','Error');
            }
        }

        return $this->render('import',[
                'modelImport' => $modelImport,
            ]);
    }

    /**
     * Manage the export of a file.
     *
     * @param integer $exam
     * @return mixed
     */
    public function actionExport($exam)
    {
        $query = Subscribes::find()->leftJoin('user','student = id')->where(['exam' => $exam])->orderBy('surname');
        $exporter = new Spreadsheet([
            'dataProvider' => new ActiveDataProvider([
                'query' => $query,
            ]),
            'columns' => [
                [
                    'attribute' => 'user.username',
                ],
                [
                    'attribute' => 'user.name',
                ],
                [
                    'attribute' => 'user.surname',
                ],
                [
                    'attribute' => 'student0.register_id',
                ],
                [
                    'attribute' => 'result',
                ],
                [
                    'attribute' => 'historic',
                    'filter' => false,
                    'format' => 'raw',
                    'value' => function ($model) {
                            $course = $this->findExam($model->exam)->getCourse();
                            return Subscribes::getHistory($model->student,$course);
                    },
                ],
            ],
        ]);

        return $exporter->send('export_site.xls');
    }

    /**
     * Finds the Exam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $exam
     * @return Exam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findExam($exam)
    {
        if(($model = Exam::findOne($exam)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Manage the import of a file.
     *
     * @param integer $exam
     * @return mixed
     * @throws \PHPExcel_Reader_Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionImportresult($exam)
    {

        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $modelImport->addRule(['fileImport'], 'required');

        if(Yii::$app->request->post()) {
            $modelImport->fileImport = UploadedFile::getInstance($modelImport, 'fileImport');
            if($modelImport->fileImport && $modelImport->validate()) {
                $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 2;
                while(!empty($sheetData[$baseRow]['A'])) {
                    if(!(User::findByUsername((string)$sheetData[$baseRow]['A']))) {
                        // create new student and user
                        $user = new User;
                        $student = new Student;
                        $user->setUsername((string)$sheetData[$baseRow]['A']);
                        $user->setName((string)$sheetData[$baseRow]['B']);
                        $user->setSurname((string)$sheetData[$baseRow]['C']);
                        $user->generateAuthKey();
                        if($user->save()) {
                            // create the student
                            $student->setRegister((integer)$sheetData[$baseRow]['D']);
                            $student->setId($user->getId());
                            if(!$student->save()) {
                                $user->delete();
                                Yii::$app->getSession()->setFlash('error', 'Error');
                            }
                        }
                        else {
                            Yii::$app->getSession()->setFlash('error', 'Error');
                        }
                    }
                    if((User::findByUsername((string)$sheetData[$baseRow]['A']))) {
                        $model = Subscribes::findByStudentExam((User::findByUsername((string)$sheetData[$baseRow]['A']))->getId(), $exam);
                        if (!$model) {
                            $new = new Subscribes();
                            $new->setExam($exam);
                            $new->setStudent((User::findByUsername((string)$sheetData[$baseRow]['A']))->getId());
                            $new->setData();
                            $res = (string)$sheetData[$baseRow]['E'];
                            if ($res !== null) {
                                $new->setResult($res);
                            }
                            else {
                                Yii::$app->getSession()->setFlash('error', 'Error');
                            }
                            if($new->save()) {
                                $baseRow++;
                            }
                            else {
                                Yii::$app->getSession()->setFlash('error', 'Error');
                            }
                        }
                        else {
                            $res = (string)$sheetData[$baseRow]['E'];
                            if($res !== null) {
                                $model->setResult($res);
                            }
                            else {
                                Yii::$app->getSession()->setFlash('error', 'Error');
                            }
                            if($model->save()) {
                                $baseRow++;
                            }
                            else {
                                Yii::$app->getSession()->setFlash('error', 'Error');
                            }
                        }
                    }
                    else {
                        $baseRow++;
                    }
                }
                Yii::$app->getSession()->setFlash('success', 'Success');
            }
            else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('importresult',[
            'modelImport' => $modelImport,
        ]);
    }
}

    
   