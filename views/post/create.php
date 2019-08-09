<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = Yii::t('app\model', 'Create Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app\model', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

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
