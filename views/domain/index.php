<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DomainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Domains');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute'=>'domain',
                'value'=>function ($model) { return Html::a($model->domain,Url::to(['view','id'=>$model->id]),[]); },
                'format'=>'html',
            ],
            'destination',
            'description',
            //'aliases',
            //'mailboxes',
            //'quota',
            'active:boolean',
            //'created_at',
            //'updated_at',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
        'panel' => [
            'heading'=>$this->title,
            'type' => 'info',
        ],
        
        'toolbar' => [
            [
                'content' => Html::a(Yii::t('app', 'Create Domain'), ['create'], ['class' => 'btn btn-success']),
            ],
            '{toggleData}',
        ],
        
    ]); ?>


</div>
