<?php

namespace app\controllers;

use Yii;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Handles;
use app\models\Page;
use app\models\CourseSite;
use app\models\SearchPages;

/**
 * PagesController implements the CRUD actions for Page model.
 */
class PagesController extends Controller
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
                        'roles' => ['admin','staff','teacher']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @param integer $coursesite
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($coursesite)
    {
        if($this->checkUser(($this->findCourse($coursesite))->getCourse())) {
            $searchModel = new SearchPages();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $coursesite);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'coursesite' => $coursesite,
            ]);
        }
        else {
            return $this->redirect(array('site/index'));
        }

    }

    /**
     * Displays a single Page model.
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
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($coursesite)
    {
        $model = new Page();

        if($model->load(Yii::$app->request->post())) {
            if($model->getHome() && $model->getNews()){
                return $this->refresh();

            }
            if($model->getHome()){
                if($this->checkHome($model->getCourseS())){
                    return $this->refresh();
                }
            }
            if($model->getNews()){
                if($this->checkNews($model->getCourseS())){
                    return $this->refresh();
                }
            }
            if($model->save())
                return $this->redirect(['index', 'coursesite' => $coursesite]);
        }
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
        if(isset($role['admin'])) {
            $data = (ArrayHelper::map(CourseSite::find()->where(['is_current' => true])->all(), 'id', 'title'));
        }
        else {
            $data = (ArrayHelper::map(CourseSite::find()->leftjoin('handles', '"course_site"."course"::integer="handles"."course"::integer')
            ->where(['handles.staff' => Yii::$app->user->identity->getId()])->andWhere(['is_current' => true])->all(), 'id', 'title'));
        }
        return $this->render('create', [
            'model' => $model,
            'data'  => $data
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         if($this->findCourse($model->getCourseS())->getCourse()) {
             if($model->load(Yii::$app->request->post())) {
                 $coursesite = $model->getCourseS();
                 if($model->getHome() && $model->getNews()){
                     return $this->refresh();

                 }
                 if($model->getHome()){
                     if($this->checkHomePages($coursesite,$id)){
                         return $this->refresh();
                     }
                 }
                 if($model->getNews()){
                     if($this->checkNewsPages($coursesite,$id)){
                         return $this->refresh();
                     }
                 }
                 if($model->save())
                     return $this->redirect(['index', 'coursesite' => $coursesite]);
             }

             $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
             if(isset($role['admin'])) {
                 $data = (ArrayHelper::map(CourseSite::find()->where(['is_current' => true])->all(), 'id', 'title'));
             }
             else {
                 $data = (ArrayHelper::map(CourseSite::find()->leftjoin('handles', '"course_site"."course"::integer="handles"."course"::integer')
                     ->where(['handles.staff' => Yii::$app->user->identity->getId()])->andWhere(['is_current' => true])->all(), 'id', 'title'));
             }

            return $this->render('update', [
                'model' => $model,
                'data' => $data
            ]);
        }
        else {
            return $this->redirect(array('site/index'));
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->softDelete();
        } catch (StaleObjectException $e) {
        } catch (NotFoundHttpException $e) {
        } catch (\Throwable $e) {
        }

        return $this->redirect(['index', 'coursesite' => $this->findModel($id)->course_site]);
    }

    /**
     * Check if an user is the manager of a course.
     * @param integer $course
     * @return bool
     */
    protected function checkUser($course)
    {
        $role = Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->getId());
        $handle = new Handles();

        return (isset($role['admin']) || $handle->checkHandles(\Yii::$app->user->identity->getId(),$course));
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Finds the Coursesite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CourseSite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findCourse($id)
    {
        if(($model = CourseSite::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function checkNews($courseSite)
{
    $pages = Page::findAll(['course_site' => $courseSite]);

    foreach($pages as $page)
    {
        if($page->getNews()) return true;
    }
    return false;
}

    public function checkHome($courseSite)
    {
        $pages = Page::findAll(['course_site' => $courseSite]);

        foreach($pages as $page)
        {
            if($page->getHome()) return true;
        }
        return false;
    }

    public function checkHomePages($courseSite,$Page)
    {
        $pages = Page::find()->where(['course_site' => $courseSite])->andWhere(['!=','id',$Page])->all();

        foreach($pages as $page)
        {
            if($page->getHome()) return true;
        }
        return false;
    }

    public function checkNewsPages($courseSite,$Page)
    {
        $pages = Page::find()->where(['course_site' => $courseSite])->andWhere(['!=','id',$Page])->all();

        foreach($pages as $page)
        {
            if($page->getHome()) return true;
        }
        return false;
    }

}
