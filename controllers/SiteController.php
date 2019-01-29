<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Usertemp;
use app\models\RegisterForm;
use app\models\Request;
use app\models\Registers;
use app\models\Student;
use app\models\CourseSite;

/**
 * SiteController is the main controller of the project.
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','request'],
                'rules' => [
                    [
                        'actions' => ['logout','request'],
                        'allow' => true,
                        'roles' => ['@'],								// @ all roles
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
     * Displays the homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     * Here there are all the validation controls.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        // a logged user trying to access to the login page will be rendered to the home
        if(!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // someone is submitting login data
        $model = new LoginForm();
        if($model->load(Yii::$app->request->post())) {
			switch($model->login()) {
				case 0:
					$model->password = ''; 
					return $this->render('login', [
						'model' => $model,
						]);
					break;
				case 1:
				    // this will render a landing page depending on the role
					return $this->roleBasedHomePage();
					break;
				case 100:
				    // store username and password of the login form in the temporary table
					$temp = new Usertemp();
					$temp->setUsername($model->username);
					$temp->save();
					return $this->redirect(array('site/register', 'username' => $model->username));
					break;
			}
        }

        // this render is necessary to display the login page the first time
        $model->password = '';
		return $this->render('login', [
				'model' => $model,
		]);
    }

    /**
     * Register action.
     * Used when a valid username isn't in the database.
     *
     * @param integer $username
     * @return Response|string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRegister($username) 
    {
		if(!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
		$register = new RegisterForm();
		if($register->load(Yii::$app->request->post())) {
			$temp = new Usertemp();
			if($temp->findByUsername($username)) {
				if($register->register($username)) {
					return $this->redirect(array('site/login'));
			    }
			}
			else
			    return $this->redirect('index');
		}
		
		$error = $register->getErrors();
		Yii::error($error);
		
		$temp = new Usertemp();
		if($temp->findByUsername($username)) {
			return $this->render('register', [
				'model' => $register,
				'username' => $username
			]);
		}
		else
		    return $this->redirect('index');
	}

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

	 /**
     * Displays Student landing page.
     *
     * @return mixed
     */
	public function actionStudenthome()
    {
        $model = new Registers();
        // someone is trying to register at a course
        if($course = Yii::$app->request->post('submit')) {
            $model->student = \Yii::$app->user->identity->id;
            $model->course_site = $course;
            // set the current data
            $model->date = date('Y-m-d H:i:s');
            // insert data in the db only if allowed
            if($model->courseSite->opening_date <= $model->date & $model->date <= $model->courseSite->closing_date) {
                $model->save();
                \Yii::$app->getSession()->setFlash('success', 'Ti sei iscritto al corso!');
            }
            else
                \Yii::$app->getSession()->setFlash('warning', 'Iscrizione fuori periodo');

            return $this->redirect(['studenthome']);
        }

        $student = Student::findOne(\Yii::$app->user->identity->id);
        $allcourses = CourseSite::find()->all();

		return $this->render('studenthome', [
		    'student' => $student,
            'courses' => $student->getCourseSites()->all(),
            'allcourses' => $allcourses,
            'model' => $model,
            'exams' => $student->getExams()->all(),
            'my_thesis' => $student->getRequestedThesis()->all()
        ]);
	}

    /**
     * Displays the page to request a thesis.
     *
     * @param $thesis
     * @return mixed
     */
	public function actionRequest($thesis)
    {
        $model = new Request();

        if($model->load(Yii::$app->request->post())) {
             $model->setStudent(\Yii::$app->user->identity->id);
             $model->setData();
             if($model->save()) {
                 return $this->redirect('studenthome');
             }
             return $this->redirect('index');
        }

        return $this->render('request', [
            'model' => $model,
            'thesis' => $thesis,
        ]);
    }

    /**
     * Displays for each role the respective landing page .
     *
     * @return mixed
     */
    protected function roleBasedHomePage()
    {
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id); //however you define your role, have the value output to this variable
        if(isset($role['admin'])) {
            return $this->redirect(array('/admin'));
        }
        else {
            if(isset($role['staff'])) {
                return $this->redirect(array('/staffhome'));
            }
            else {
                if(isset($role['teacher'])){
                    return $this->redirect(array('/teacher'));
                }
                else {
                    if(isset($role['student'])){
                        return $this->redirect(array('site/studenthome'));
                    }
                }
                // default landing page
                return $this->redirect(array('site/index'));
            }
        }
    }
}
