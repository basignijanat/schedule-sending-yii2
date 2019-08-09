<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "descriptive_post".
 * 
 * @property int $post_id
 * @property string $position_description
 * @property int $salary
 * @property int $start_at
 * @property int $end_at
 */
class DescriptivePost extends \yii\db\ActiveRecord
{
    public $form_name = 'Form 1';
    public $form_class_id = 'form1';
    public $start_at_time;
    public $start_at_date;
    public $end_at_time;
    public $end_at_date;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'descriptive_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'start_at', 'end_at'], 'required'],
            [['post_id', 'salary', 'start_at', 'end_at'], 'integer'],
            [['position_description'], 'string', 'max' => 255],
            [['start_at_time', 'start_at_date', 'end_at_time', 'end_at_date'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [            
            'post_id' => Yii::t('app\model', 'Post ID'),
            'position_description' => Yii::t('app\model', 'Position Description'),
            'salary' => Yii::t('app\model', 'Salary'),
            'start_at_time' => Yii::t('app\model', 'Start at Time'),
            'start_at_date' => Yii::t('app\model', 'Start at Date'),
            'end_at_time' => Yii::t('app\model', 'End at Time'),            
            'end_at_date' => Yii::t('app\model', 'End at Date'),            
        ];
    }

    public function attributes(){

        return array_merge(parent::attributes(), ['start_at_time', 'start_at_date', 'end_at_time', 'end_at_date']);
    }

    public function setPostId($post_id){

        return $this->post_id = $post_id;
    }

    public function beforeValidate(){
        $this->start_at = strtotime($this->start_at_time.' '.$this->start_at_date);
        $this->end_at = strtotime($this->end_at_time.' '.$this->end_at_date);

        if ($this->start_at < time()){
            $this->start_at = time();
        }

        if ($this->end_at < $this->start_at + $this->minStartEnd()){
            $this->end_at = $this->start_at + $this->minStartEnd();
        }

        return parent::beforeValidate();
    }

    public function getClassName(){

        return end(explode('\\', get_class($this)));
    }

    private static function minStartEnd(){

        return 60 * 60 * 24 * 31 * 3;
        // 60 sec * 60 min * 24 hours * 31 days * 3
    }
}
