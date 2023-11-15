<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DomainSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->domain.' '.Yii::t('app', 'Domain alias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute'=>'destination',
                'value'=>function ($model) { return Html::a($model->domain,Url::to(['update-alias','id'=>$model->id]),[]); },
                'format'=>'html',
                'label'=>'Domain alias',
            ],
            'description',
            'active:boolean',
            [
                'class' => 'kartik\grid\ActionColumn', 
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-pencil-alt"></span>',['update-alias','id'=>$model->id],[]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-trash-alt"></span>',['delete-alias','id'=>$model->id],['data-pjax'=>0,'data-method'=>'post',
                            'data-confirm' => Yii::t('kvgrid', 'Are you sure to delete this {item}?',['item'=>'domain alias'])]);
                    },
                ],
            ],
        ],
        'panel' => [
            'heading'=>$this->title,
            'type' => 'info',
        ],
        
        'toolbar' => [
            [
                'content' => Html::a(Yii::t('app', 'Create Domain Alias'), ['create-alias','domain'=>$model->domain], ['class' => 'btn btn-success']),
            ],
            '{toggleData}',
        ],
        
    ]); ?>


</div>
