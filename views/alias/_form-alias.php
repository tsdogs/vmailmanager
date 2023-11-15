<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Account;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alias */
/* @var $form yii\widgets\ActiveForm */

$options = [];
$destinations = ArrayHelper::map($model->destinations,'destination','destination');
foreach (Account::find()->where(['active'=>1,'domain'=>$model->domain])->all() as $d) {
    if (!in_array($d->email,$destinations)) {
        $options[$d->email]=$d->email;
    }
}
?>

<div class="alias-form" style="float: right; margin-right: 20px;">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_INLINE,'action'=>['create','domain'=>$model->domain]]); ?>

    <?= $form->field($model, 'domain')->hiddenInput()->label(false); ?>
    
    <?= $form->field($model, 'username')->hiddenInput()->label(false); ?>

    
    <?= $form->field($model, 'destination')->dropdownList($options,['prompt'=>'-- Existing account --']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
<div class="alias-form"  style="float: right">
    <?php ActiveForm::end(); ?>

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_INLINE,'action'=>['create','domain'=>$model->domain]]); ?>

    <?= $form->field($model, 'domain')->hiddenInput()->label(false); ?>
    
    <?= $form->field($model, 'username')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'destination')->textInput(); ?>
    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
