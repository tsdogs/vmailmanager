<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\icons\FontAwesomeAsset;



AppAsset::register($this);
FontAwesomeAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-nav navbar-light navbar-expand-md', 'style'=>"background-color: #e3f2fd;"
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Domains', 'url' => ['/domain/index'],'visible'=>!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin],
        ],
    ]);
    NavBar::end();
    ?>
<div class="d-flex" id="wrapper">
<?php if (!Yii::$app->user->isGuest) { ?>
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">Menu</div>
        <!-- /#sidebar-wrapper -->

        <?php
        
            $domains = [];
            foreach (Yii::$app->user->identity->domains as $d) {
                if ($d->domain==$d->destination || empty($d->destination)) {
                    $domains[] = [
                        'title' => $d->domain,
                    // 'folder' => true,
                        'icon' => Url::base().'/img/dtree/globe.gif',
                        'data'=>['url'=>Url::to(['domain/view','id'=>$d->id])],
                        'selected' => Url::to(['domain/view','id'=>$d->id])==Yii::$app->request->url,
                        'expanded' => (
                                        Url::to(['domain/view','id'=>$d->id])==Yii::$app->request->url || 
                                        (isset($_GET['domain']) && $d->domain==$_GET['domain'])
                                    ),
                        'children' => [
                            [
                                'title'=>'Domain aliases',
                                'icon' => Url::base().'/img/dtree/domainalias.gif',
                                'data'=>['url'=>Url::to(['domain/alias','domain'=>$d->domain])],
                                'selected' => Url::to(['domain/alias','domain'=>$d->domain])==Yii::$app->request->url,
                            ],
                            [
                                'title'=>'User accounts',
                                'icon' => Url::base().'/img/dtree/mailbox.gif',
                                'data'=>['url'=>Url::to(['account/index','domain'=>$d->domain])],
                                'selected' => Url::to(['account/index','domain'=>$d->domain])==Yii::$app->request->url,
                            ],
                            [
                                'title'=>'Aliases / Forwards',
                                'icon' => Url::base().'/img/dtree/aliases.gif',
                                'data'=>['url'=>Url::to(['alias/index','domain'=>$d->domain])],
                                'selected' => Url::to(['alias/index','domain'=>$d->domain])==Yii::$app->request->url,
                            ],
                        ],
                    ];
                }
            }
            $items = [
                [
                    'title' => 'Personal',
                    'icon' => Url::base().'/img/dtree/base.gif',
                    'data'=>['url'=>Url::to(['site/index'])],
                    //'folder' => true,
                    'expanded'=>true,
                    'children' => [
                        [
                            'title'=> 'Forwarding',
                            'icon' => Url::base().'/img/dtree/forward.gif',
                            'data'=>['url'=>Url::to(['personal/forward'])],
                            'selected'=>Url::to(['personal/forward'])==Yii::$app->request->url,
                        ],
                        [
                            'title'=>'Password',
                            'icon' => Url::base().'/img/dtree/password.gif',
                            'data'=>['url'=>Url::to(['personal/password'])],
                            'selected'=>Url::to(['personal/password'])==Yii::$app->request->url,
                        ],
                        [
                            'title'=>'Quit',
                            'data'=>['url'=>Url::to(['site/logout'])],
                            //'icon' => Url::base().'/img/dtree/quit.gif',
                        ],
                    ],
                ]
            ];
            if (Yii::$app->user->identity->isMaster) {
                $items[]=[
                        'title' => 'Administration',
                       // 'folder' => true,
                       'icon' => Url::base().'/img/dtree/base.gif',
                       'data'=>['url'=>Url::to(['admins/index'])],
                       'selected'=>Url::to(['admins/index'])==Yii::$app->request->url,
                ];
            }
            if (Yii::$app->user->identity->isAdmin) {
                $items[] = [
                    'title' => 'Domains',
                    'folder' => false,
                    'icon' => Url::base().'/img/dtree/base.gif',
                    'data'=>['url'=>Url::to(['domain/index'])],
                    'expanded'=>true,
                    'selected' => Url::to(['domain/index'])==Yii::$app->request->url,
                    'children' => $domains,
                ];

            }
            echo yii2mod\tree\Tree::widget([
            'items' => $items,
            'clientOptions' => [
                'autoCollapse' => false,
                'clickFolderMode' => 3,
                'activate' => new \yii\web\JsExpression('
                        function(node, data) {
                              node  = data.node;
                              // Log node title
                              window.location = node.data.url;
                              //console.log(node.data.url);
                        }
                '),
            ],
        ]); ?>
    </div>    
    <?php } ?>
    <!-- Page Content -->
    <div id="page-content-wrapper" class="containerx">
        <?= Alert::widget() ?>
 
        <?= $content ?>
    </div>
</div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Alessandro Briosi <?= date('Y') ?></p>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
