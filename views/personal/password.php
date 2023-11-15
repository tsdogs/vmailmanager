<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<h3>Change password</h3>
<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'currentpassword')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newpassword')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'confirmpassword')->passwordInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Confirm'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

