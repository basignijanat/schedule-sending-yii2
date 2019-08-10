<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostInQueue;
use app\models\DescriptivePost;
use app\models\ContactPost;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelPost = new Post;
        $modelPostInQueue = new PostInQueue;
        $modelsForm = Post::getForms();  
        
        $form_status = 0;
        
        if ($modelPost->load(Yii::$app->request->post()) && $modelPost->save()){                                    
            $modelPostInQueue->post_id = $modelPost->id;            
            $modelsForm[$modelPost->type]->post_id = $modelPost->id;                          
            
            if ($modelPostInQueue->load(Yii::$app->request->post()) && $modelPostInQueue->save()){
                $result['piq'] = 1;
            }
            else{
                $result['piq'] = 0;
            }                        
            if ($modelsForm[$modelPost->type]->load(Yii::$app->request->post()) && $modelsForm[$modelPost->type]->save()){                    
                $result['form'] = 1;
            }            
            else{
                $result['form'] = 0;
            }

            if (count($result) == array_sum($result)){
                $modelPostInQueue->sendPost();

                $modelPost = new Post;
                $modelPostInQueue = new PostInQueue;
                $modelsForm = Post::getForms();  

                $form_status = 1;                
            }            
        }                  

        return $this->render('create', [
            'modelPost' => $modelPost,
            'PostInQueue' => $modelPostInQueue,
            'modelsForm' => $modelsForm,
            'forms' => $this->getForms($modelsForm),
            'attr_exceptions' => $this->getAttributeExceptions(),
            'form_status' => $form_status,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {        
        $errors = [
            'post' => true,
            'postinqueue' => true,
            'postforms' => true,
        ];

        $modelPost = $this->findModel($id);
        $modelPostInQueue = new PostInQueue;
        $modelsForm = [
            new DescriptivePost,
            new ContactPost,
        ];

        if ($modelPost->load(Yii::$app->request->post()) && $modelPost->validate()){
            $post_id = 1;
            $modelPostInQueue->setPostId($post_id);
            if ($modelPostInQueue->load(Yii::$app->request->post()) && $modelPostInQueue->validate()){
                $modelsForm[$modelPost->type]->setPostId($post_id);
                if ($modelsForm[$modelPost->type]->load(Yii::$app->request->post()) && $modelsForm[$modelPost->type]->validate()){                                    
                    return $this->redirect(['view', 'id' => $post_id]);
                }
                else{
                    $errors['postforms'] = false;                    
                }
            }
            else{
                $errors['postinqueue'] = false;
            }
        }
                
        /*if (Yii::$app->request->post()){
            //echo array_sum($errors);
            //echo var_dump(Yii::$app->request->post());
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/

        return $this->render('update', [
            'modelPost' => $modelPost,
            'PostInQueue' => $modelPostInQueue,
            'modelsForm' => $modelsForm,
            'forms' => $this->getForms($modelsForm),
            'attr_exceptions' => $this->getAttributeExceptions(),
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app\model', 'The requested page does not exist.'));
    }

    protected function getForms($forms){
        $form_names = [];

        foreach ($forms as $form){
            $form_names[] = $form->form_name;
        }
        
        return $form_names;
    }

    protected function getAttributeExceptions(){
        
        return [
            'id',
            'post_id',
            'start_at',
            'end_at',
        ];
    }    
}
