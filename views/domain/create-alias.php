<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Domain */

$this->title = $model->destination.' '.Yii::t('app', 'Create Domain Alias');
?>
<div class="domain-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
