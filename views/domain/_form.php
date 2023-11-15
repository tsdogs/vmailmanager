<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Domain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="domain-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>
    
    <?php if ($model->scenario=='alias') { ?>
        <?= $form->field($model, 'destination')->hiddenInput()->label(false) ?>
    <?php } else { ?>
        <?= $form->field($model, 'destination')->textInput(['maxlength' => true]) ?>
    <?php } ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php if ($model->scenario!='alias') { ?>
    <?= $form->field($model, 'aliases')->textInput() ?>

    <?= $form->field($model, 'mailboxes')->textInput() ?>

    <?= $form->field($model, 'quota')->textInput() ?>
    <?php } ?>

    <?= $form->field($model, 'active')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
