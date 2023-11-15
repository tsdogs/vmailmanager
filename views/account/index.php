<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->domain.' '.Yii::t('app', 'Accounts');
$this->params['breadcrumbs'][] = $model->domain.' '.$this->title;
?>
<div class="account-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute'=>'username',
                'value' => function ($model) {
                    return $model->username.'@'.$model->domain;
                },
                'label' => 'Account',
                'format' => 'raw',
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
            'active:boolean',
            ['class' => 'kartik\grid\ActionColumn'],
        ],
        'panel' => [
            'heading'=>$this->title,
            'type' => 'info',
        ],
        
        'toolbar' => [
            [
                'content' => Html::a(Yii::t('app', 'Create Account'), ['create','domain'=>$model->domain], ['class' => 'btn btn-success']),
            ],
            '{toggleData}',
        ],
    ]); ?>


</div>
