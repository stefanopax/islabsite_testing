<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Course;
use app\models\CourseSite;
use app\models\Registers;

class CourseController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Display the course pages.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        $edition = CourseSite::findCurrentCourseSite($id);
        // check if user is subscribed to that course site
        $subscribed = false;
        $register = Registers::find()->where(['student' => Yii::$app->user->id])->one();
        if($register)
            $subscribed = true;
        return $this->render('index', [
            'model' => $this->findModel($id),
            'edition' => $edition,
            'pages' => $edition->getPages()->all(),
            'subscribed' => $subscribed
        ]);
    }


    /**
     * Lists all past Course Sites.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionSites($id)
    {
        $model = $this->findModel($id);
        return $this->render('sites', [
            'model' => $model,
            'courses' => $model->getCourseSites()->all()
        ]);
    }

    /**
     * Displays the past course page.
     * @param $id
     * @return mixed
     */
    public function actionPastcourse($id)
    {
        $edition = CourseSite::findIdentity($id);
        return $this->render('pastcourse', [
            'edition' => $edition,
            'pages' => $edition->getPages()->all()
        ]);
    }

    /**
     * Return the model associated to the Course with specific id.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Temporary action
     * @return mixed
     */
    public function actionNews()
    {
        return $this->render('news');
    }

}