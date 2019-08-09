<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

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
                            <?= $form->field($modelForm, $attribute)->textInput([
                                'class' => 'form-control '.$modelForm->form_class_id,
                            ]) ?>
                        <? endif ?>
                    <? endforeach ?>  
                <?= Html::endTag('div') ?>
            <? endforeach ?>           

            <div class="form-group">
                <div>
                    <?= Html::label(Yii::t('app\model', 'Place At Date'), 'post_in_queue-place_at_date', [
                        'class' => 'control-label',
                    ]) ?>                    
                    <input type="date" id="post_in_queue-place_at_date" name="PostInQueue[place_at_date]" value="<?= $modelPostInQueue->place_at > 0 ? date('Y-m-d', $modelPostInQueue->place_at) : date('Y-m-d', time()) ?>" class ="form-control" aria-required=true aria-invalid=false>
                    <div class="help-block">123</div>
                </div>
                <div>
                    <?= Html::label(Yii::t('app\model', 'Place At Time'), 'post_in_queue-place_at_time', [
                        'class' => 'control-label',
                    ]) ?>                          
                    <input type="time" id="post_in_queue-place_at_time" name="PostInQueue[place_at_time]" value="<?= $modelPostInQueue->place_at > 0 ? date('H:i', $modelPostInQueue->place_at) : date('H:i', time()) ?>" class ="form-control" aria-required=true aria-invalid=false>
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