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
            [['start_at', 'end_at'], 'required'],
            [['post_id', 'salary', 'start_at', 'end_at'], 'integer'],
            [['position_description'], 'string', 'max' => 255],
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
            'start_at' => Yii::t('app\model', 'Start At'),
            'end_at' => Yii::t('app\model', 'End At'),
        ];
    }
}
