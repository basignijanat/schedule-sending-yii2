<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostInQueue;
use app\models\DescriptivePost;
use app\models\ContactPost;

class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $modelPost = new Post;
        $modelPostInQueue = new PostInQueue;
        $modelsForm = [
            new DescriptivePost,
            new ContactPost,
        ];
        
        if ($modelPost->load(Yii::$app->request->post()) && $modelPost->validate()){
            $post_id = 1;
            $modelPostInQueue->setPostId($post_id);
            if ($modelPostInQueue->load(Yii::$app->request->post()) && $modelPostInQueue->validate()){
                if ($modelsForm[$modelPost->type]->load(Yii::$app->request->post()) && $modelsForm[$modelPost->type]->validate()){
                    echo 'postforms:ok';                
                }
                else{
                    echo 'postforms:fail';                
                }
            }
            else{
                echo 'postinqueue:fail';                
            }
        }        

        return $this->render('index', [
            'modelPost' => $modelPost,
            'PostInQueue' => $modelPostInQueue,
            'modelsForm' => $modelsForm,
            'forms' => $this->getForms($modelsForm),
            'attr_exceptions' => $this->getAttributeExceptions(),
        ]);
    }

    private function getForms($forms){
        $form_names = [];

        foreach ($forms as $form){
            $form_names[] = $form->form_name;
        }
        
        return $form_names;
    }

    private function getAttributeExceptions(){
        
        return [
            'id',
            'post_id',
        ];
    }
}
