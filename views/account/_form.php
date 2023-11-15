<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username',['addon' => ['append' => ['content'=>'@'.$model->domain]]])->textInput() ?>

    <?= $form->field($model, 'newpassword')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?php if (Yii::$app->params['features']['quota']) { ?>
    <?= $form->field($model, 'quota')->textInput() ?>
<?php } else { ?>
    <?= $form->field($model, 'quota')->hiddenInput()->label(false) ?>
<?php } ?>

    <?= $form->field($model, 'send')->checkbox() ?>

    <?= $form->field($model, 'receive')->checkbox() ?>

<?php if (Yii::$app->params['features']['calendar']) { ?>
    <?= $form->field($model, 'calendar')->checkbox() ?>
<?php } else { ?>
    <?= $form->field($model, 'calendar')->hiddenInput()->label(false) ?>
<?php } ?>

    <?= $form->field($model,'password_renewtime')->textInput(['type'=>'number']) ?>

    <?= $form->field($model,'password_expired')->checkbox() ?>

    <?= $form->field($model, 'active')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
