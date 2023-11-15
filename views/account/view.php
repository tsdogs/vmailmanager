<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Account */

$this->title = $model->username.'@'.$model->domain;
?>
<div class="account-view">

    <p style="float: right">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'username',
                'value'=> function ($model) {
                    return $model->username.'@'.$model->domain;
                },
            ],
            'name',
            [
                'attribute' => 'quota',
                'format' => 'integer',
                'visible' => Yii::$app->params['features']['quota'],
            ],
            'send:boolean',
            'receive:boolean',
            [
                'attribute' => 'calendar',
                'format' => 'boolean',
                'visible' => Yii::$app->params['features']['calendar'],
            ],
            'password_expireson:datetime',
            'password_renewtime:integer',
            [
                'attribute' => 'password_expired',
                'value' => function($model) {
                    if ($model->password_expired) {
                        return true;
                    } else {
                        if ($model->password_expireson!=null && $model->password_expireson < time()) {
                            return true;
                        }
                    }
                    return false;
                },
                'format' => 'boolean',
                'label' => Yii::t('app','Password expired'),
            ],
            'last_login:datetime',
            'last_login_ip',
            'active:boolean',
        ],
    ]) ?>

</div>
