<?php

/* @var $this yii\web\View */

$this->title = 'VMailManage Home';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome <?= Yii::$app->user->identity->name; ?>!</h1>

        <p class="lead">Here you can manager your account information</p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <h2>Forwarding</h2>

                <p>Forward your e-mails to another account  or e-mail address</p>

            </div>
            <div class="col-lg-6">
                <h2>Password</h2>

                <p>Change your password</p>

            </div>
        </div>

    </div>
</div>
