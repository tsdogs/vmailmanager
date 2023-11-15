<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'domain')->hiddenInput()->label(false); ?>
    
    <?= $form->field($model, 'username', ['addon' => ['append' => ['content'=>'@'.$model->domain]]])->textInput(['maxlength' => true])->label('Alias') ?>

    <?= $form->field($model, 'destination')->textInput(); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
