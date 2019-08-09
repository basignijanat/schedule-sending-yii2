<?php

namespace app\models;

use Yii;
use app\models\DescriptivePost;
use app\models\ContactPost;

/**
 * This is the model class for table "post".
 * 
 * @property int $type
 * @property string $company_name
 * @property string $position
 */
class Post extends \yii\db\ActiveRecord
{    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'company_name', 'position'], 'required'],
            [['type'], 'integer'],
            [['company_name', 'position'], 'string', 'max' => 255],                        
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [            
            'type' => Yii::t('app\model', 'Type'),
            'company_name' => Yii::t('app\model', 'Company Name'),
            'position' => Yii::t('app\model', 'Position'),
        ];
    }

    public function getForm(){
        switch ($this->type){
            case 0:
                return DescriptivePost::find()->where(['post_id' => $this->id])->one();                
            case 1:
                return ContactPost::find()->where(['post_id' => $this->id])->one();                
        }

        return self::getForms()[$this->type];
    }

    public static function getForms(){

        return [
            new DescriptivePost,
            new ContactPost,
        ];
    }
}
