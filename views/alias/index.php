<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AliasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->domain.' '.Yii::t('app', 'Aliases');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alias-index">


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'username',
                'value' => function ($model) {
                    return $model->username.'@'.$model->domain;
                },
                'label' => 'Alias',
                'format' => 'raw',
            ],
            [
                'attribute'=>'destinations',
                'value' => function ($model) {
                    $result = '';
                    foreach ($model->destinations as $x) {
                        $result .= $x->destination.'<br />';
                    }
                    return $result;
                },
                'format' => 'html',
            ],
            'active:boolean',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-pencil-alt"></span>',['update','username'=>$model->username,'domain'=>$model->domain],[]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-trash-alt"></span>',['delete','username'=>$model->username,'domain'=>$model->domain],['data-pjax'=>0,'data-method'=>'post',
                            'data-confirm' => Yii::t('kvgrid', 'Are you sure to delete this {item}?',['item'=>'alias'])]);
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
                'content' => Html::a(Yii::t('app', 'Create Alias'), ['create','domain'=>$model->domain], ['class' => 'btn btn-success']),
            ],
            '{toggleData}',
        ],
        
    ]); ?>

    <?php Pjax::end(); ?>

</div>
