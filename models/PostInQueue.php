<?php

namespace app\models;

use Yii;
use app\models\Post;

/**
 * This is the model class for table "post_in_queue".
 * 
 * @property int $post_id
 * @property int $place_at
 * @property int $notification_email_at
 */
class PostInQueue extends \yii\db\ActiveRecord
{
    public $place_at_time;
    public $place_at_date;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_in_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'place_at'], 'required'],
            [['post_id', 'notification_email_at', 'place_at'], 'integer'],                         
            [['place_at_time', 'place_at_date'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [            
            'post_id' => Yii::t('app\model', 'Post ID'),
            'place_at' => Yii::t('app\model', 'Place At'),
            'notification_email_at' => Yii::t('app\model', 'Notification Email At'),
        ];
    }

    public function setPostId($post_id){

        return $this->post_id = $post_id;
    }

    public function beforeValidate(){
        $this->place_at = strtotime($this->place_at_time.' '.$this->place_at_date);        

        if ($this->place_at < time()){
            $this->place_at = time();
        }

        return parent::beforeValidate();
    }

    public function sendPost(){
        if ($this->notification_email_at == 0){
            if ($this->place_at >= time()){
                $modelPost = Post::find()->where(['id' => $this->post_id])->one();
                $modelForm = $modelPost->getForm();
                $this->notification_email_at = time();

                return Yii::$app->mailer->compose()
                    ->setFrom('from@domain.com')
                    ->setTo('to@domain.com')
                    ->setSubject('Message Topic')
                    ->setTextBody(implode(',', $modelForm->getAttributes()))                    
                    ->send();
            }
            else{

            }
            
        }
        
    }
}
