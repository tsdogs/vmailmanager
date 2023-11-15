<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Alias */

$this->title = Yii::t('app', 'Update Alias: {name}', [
    'name' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aliases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="alias-update">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'username',
                'value' => $model->username.'@'.$model->domain,
                'label'=>'Alias'
            ],
            'active:boolean',
        ],
    ]) ?>
<hr />    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'destination',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-trash-alt"></span>',['delete','id'=>$model->id],['data-pjax'=>0,'data-method'=>'post',
                            'data-confirm' => Yii::t('kvgrid', 'Are you sure to delete this {item}?',['item'=>'alias'])]);
                    },
                ],
            ],
        ],
        'panel' => [
            'heading'=> 'Destinations',
            'type' => 'info',
        ],
        'toolbar' => [
            [
                'content' => $this->render('_form-alias',['model'=>$model]),
            ],
            //'{toggleData}',
        ],
        
    ]); ?>

    
</div>
