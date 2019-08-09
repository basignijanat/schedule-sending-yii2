<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = Yii::t('app\model', 'Update Post: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app\model', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app\model', 'Update');
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelPost' => $modelPost,
        'PostInQueue' => $modelPostInQueue,
        'modelsForm' => $modelsForm,
        'forms' => $forms,
        'attr_exceptions' => $attr_exceptions,
        'form_status' => $form_status,
    ]) ?>

</div>
