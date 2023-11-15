<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Domain */

$this->title = $model->domain;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="domain-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'domain',
            'destination',
            'description',
            'aliases',
            'mailboxes',
            'quota',
            [
                'attribute'=> 'active',
               'format'=> 'boolean',
               'type'=>'checkbox',
            ],
        ],
        'panel' => [
            'heading' => $this->title,
            'type' => 'info',
        ],
    ]) ?>

</div>
<hr />
        <div class="row">
            <div class="col-lg-4" style="text-align: center">
                <a class="btn btn-lg btn-info" href="<?= Url::to(['domain/alias','domain'=>$model->domain]) ?>" style="text-align: center">
                <img src="<?= Url::base().'/img/domainalias.gif' ?>"><br />
                Domain aliases
                <br />
                </a>
            </div>
            <div class="col-lg-4" style="text-align: center">
                <a class="btn btn-lg btn-info" href="<?= Url::to(['account/index','domain'=>$model->domain]) ?>" style="text-align: center">
                <img src="<?= Url::base().'/img/mailbox.gif' ?>"><br />
                User accounts
                <br />
                </a>
            </div>
            <div class="col-lg-4" style="text-align: center">
                <a class="btn btn-lg btn-info" href="<?= Url::to(['alias/index','domain'=>$model->domain]) ?>" style="text-align: center">
                <img src="<?= Url::base().'/img/aliases.gif' ?>"><br />
                Aliases / Forwards
                <br />
                </a>
            </div>
        </div>
