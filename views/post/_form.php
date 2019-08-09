<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$time_date_begin = true;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">
<div id="dialog" title="Basic dialog" hidden>
  <p>Success!</p>
</div>
    <? Pjax::begin() ?>
        <? $form = ActiveForm::begin([
            'id' => 'post-form',            
            'options' => [
                'class' => 'form-horizontal',
                'data-pjax' => '1',
            ],
        ]) ?>
            <?= Html::hiddenInput('form_satus', $form_satus, ['id' => 'form_satus']) ?>            
            <?= $form->field($modelPost, 'type')->dropdownList($forms, [
                'id' => 'select_form', 
                'value' => 0,
            ]) ?>
            <?= $form->field($modelPost, 'company_name') ?>
            <?= $form->field($modelPost, 'position') ?>

            <? foreach ($modelsForm as $modelForm): ?>
                <?= Html::beginTag('div', [
                    'id' => $modelForm->form_class_id,
                    'hidden' => $modelForm->form_name == $forms[0] ? false : true,
                ]) ?>
                    <? foreach ($modelForm->attributes() as $attribute): ?>
                        <? if (!in_array($attribute, $attr_exceptions)): ?>
                            <? if (strpos($attribute, 'at_time') || strpos($attribute, 'at_date')): ?>
                                <? if ($time_date_begin): ?>
                                    <div class="form-group row">                                    
                                <? endif ?>

                                <? if (strpos($attribute, 'at_time')): ?>                                    
                                    <div class="col-sm-6">
                                        <?= Html::label(Yii::t('app\model', $modelForm->attributeLabels()[$attribute]), $modelForm->form_class_id.'-'.$attribute, [
                                            'class' => 'control-label',
                                        ]) ?>                    
                                        <input type="time" id="<?= $modelForm->form_class_id.'-'.$attribute ?>" name="<?= $modelForm->getClassName().'['.$attribute.']' ?>" value="<?= $modelForm[$attribute] > 0 ? date('H:i', $modelForm[$attribute]) : date('H:i', time()) ?>" class ="form-control <?= $modelForm->form_class_id ?>" <?= $modelForm->form_name == $forms[0] ? '' : 'disabled' ?>>                    
                                    </div>
                                <? elseif (strpos($attribute, 'at_date')): ?>
                                    <div class="col-sm-6">
                                        <?= Html::label(Yii::t('app\model', $modelForm->attributeLabels()[$attribute]), $modelForm->form_class_id.'-'.$attribute, [
                                            'class' => 'control-label',
                                        ]) ?>                    
                                        <input type="date" id="<?= $modelForm->form_class_id.'-'.$attribute ?>" name="<?= $modelForm->getClassName().'['.$attribute.']' ?>" value="<?= $modelForm[$attribute] > 0 ? date('Y-m-d', $modelForm[$attribute]) : date('Y-m-d', time()) ?>" class ="form-control <?= $modelForm->form_class_id ?>" <?= $modelForm->form_name == $forms[0] ? '' : 'disabled' ?>>                    
                                    </div>
                                <? endif ?>

                                <? if (!$time_date_begin): ?>
                                    </div>                                    
                                <? endif ?>

                                <? $time_date_begin = !$time_date_begin ?>
                            <? elseif (strpos($attribute, 'email')): ?>
                                <?= $form->field($modelForm, $attribute)->input('email', [
                                    'class' => 'form-control '.$modelForm->form_class_id,
                                    'disabled' => $modelForm->form_name == $forms[0] ? false : true,
                                ]) ?>
                            <? else: ?>
                                <?= $form->field($modelForm, $attribute)->textInput([
                                    'class' => 'form-control '.$modelForm->form_class_id,
                                    'disabled' => $modelForm->form_name == $forms[0] ? false : true,
                                ]) ?>
                            <? endif ?>
                        <? endif ?>
                    <? endforeach ?>  
                <?= Html::endTag('div') ?>
            <? endforeach ?>           

            <div class="form-group row">                
                <div class="col-sm-6">
                    <?= Html::label(Yii::t('app\model', 'Place At Time'), 'post_in_queue-place_at_time', [
                        'class' => 'control-label',
                    ]) ?>                          
                    <input type="time" id="post_in_queue-place_at_time" name="PostInQueue[place_at_time]" value="<?= $modelPostInQueue->place_at > 0 ? date('H:i', $modelPostInQueue->place_at) : date('H:i', time()) ?>" class ="form-control">
                </div>                
                <div class="col-sm-6">
                    <?= Html::label(Yii::t('app\model', 'Place At Date'), 'post_in_queue-place_at_date', [
                        'class' => 'control-label',
                    ]) ?>                    
                    <input type="date" id="post_in_queue-place_at_date" name="PostInQueue[place_at_date]" value="<?= $modelPostInQueue->place_at > 0 ? date('Y-m-d', $modelPostInQueue->place_at) : date('Y-m-d', time()) ?>" class ="form-control">                    
                </div>
            </div>

            <div class="form-group">
                <div class="">
                    <?= Html::submitButton('Send', ['id' => 'submit-post-form', 'class' => 'btn btn-primary']) ?>
                </div>
            </div>
        <?php ActiveForm::end() ?>
    <? Pjax::end() ?>
</div>
