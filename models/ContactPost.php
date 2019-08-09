<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact_post".
 * 
 * @property int $post_id
 * @property string $contact_name
 * @property string $contact_email
 */
class ContactPost extends \yii\db\ActiveRecord
{
    public $form_name = 'Form 2';
    public $form_class_id = 'form2';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'contact_name', 'contact_email'], 'required'],
            [['post_id'], 'integer'],
            [['contact_name', 'contact_email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [            
            'post_id' => Yii::t('app\model', 'Post ID'),
            'contact_name' => Yii::t('app\model', 'Contact Name'),
            'contact_email' => Yii::t('app\model', 'Contact Email'),
        ];
    }

    public function setPostId($post_id){

        return $this->post_id = $post_id;
    }

    public function getClassName(){

        return end(explode('\\', get_class($this)));
    }
}
