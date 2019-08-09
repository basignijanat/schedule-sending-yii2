<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$time_date_begin = true;
?>


<div class="form-group">
    <h1>post/index</h1>
    <? Pjax::begin() ?>
        <? $form = ActiveForm::begin([
            'id' => 'post-form',            
            'options' => ['class' => 'form-horizontal'],
        ]) ?>
            <?= $form->field($modelPost, 'type')->dropdownList($forms) ?>
            <?= $form->field($modelPost, 'company_name') ?>
            <?= $form->field($modelPost, 'position') ?>

            <? foreach ($modelsForm as $modelForm): ?>
                <?= Html::beginTag('div', [
                    'id' => $modelForm->form_class_id,
                    'class' => 'forms'
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
                                        <input type="time" id="<?= $modelForm->form_class_id.'-'.$attribute ?>" name="<?= $modelForm->getClassName().'['.$attribute.']' ?>" value="<?= $modelForm[$attribute] > 0 ? date('H:i', $modelForm[$attribute]) : date('H:i', time()) ?>" class ="form-control">                    
                                    </div>
                                <? elseif (strpos($attribute, 'at_date')): ?>
                                    <div class="col-sm-6">
                                        <?= Html::label(Yii::t('app\model', $modelForm->attributeLabels()[$attribute]), $modelForm->form_class_id.'-'.$attribute, [
                                            'class' => 'control-label',
                                        ]) ?>                    
                                        <input type="date" id="<?= $modelForm->form_class_id.'-'.$attribute ?>" name="<?= $modelForm->getClassName().'['.$attribute.']' ?>" value="<?= $modelForm[$attribute] > 0 ? date('Y-m-d', $modelForm[$attribute]) : date('Y-m-d', time()) ?>" class ="form-control">                    
                                    </div>
                                <? endif ?>

                                <? if (!$time_date_begin): ?>
                                    </div>                                    
                                <? endif ?>

                                <? $time_date_begin = !$time_date_begin ?>
                            <? else: ?>
                                <?= $form->field($modelForm, $attribute)->textInput([
                                    'class' => 'form-control '.$modelForm->form_class_id,
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
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        <?php ActiveForm::end() ?>
    <? Pjax::end() ?>
</div>