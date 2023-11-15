<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }
    
    public function actionCreateDomain($domain)
    {
        $model = \app\models\Domain::find()->where(['domain'=>$domain])->one();
        if ($model==null) {
            echo "Creating domain: ".$domain."\n";
            $model = new \app\models\Domain();
            $model->domain=$domain;
            $model->destination=$domain;
            $model->description=$domain;
            $model->active=1;
            $model->aliases=0;
            $model->mailboxes=0;
            $model->quota=0;
            if (!$model->save()) {
                print_r($model->getErrors());
                die();
            }
        }
    }

    public function actionCreateAdmin($name,$domain,$password)
    {
        $this->actionCreateDomain($domain);
        $model = \app\models\Account::find()->where(['username'=>$name,'domain'=>$domain])->one();
        if ($model==null) {
            $model = new \app\models\Account;
            $model->username = $name;
            $model->domain = $domain;
            $model->name = $name;
            $model->scenario = 'insert';
            $model->active = 1;
            $model->send = 1;
            $model->receive = 1;
            $model->quota = 0;
            $model->calendar = 0;
        }
        $model->newpassword = $password;
        if ($model->save()) {
            $admin = new \app\models\Admin;
            $admin->id=$model->id;
            $admin->master=1;
            $admin->created_at=0;
            $admin->updated_at=0;
            if (!$admin->save()) {
                echo 'Admin failed'."\n";
                print_r($admin->getErrors());
                $model->delete();
            } else {
                echo "User created\n";
            }
        } else {
            print_r($model->getErrors());
        }

    }

    public function actionChangePwd()
    {
            foreach (\app\models\Account::find()->all() as $a) {
		    $x=exec("pwgen -cns -rl1I0O 10 1");
		    if ($x=='') { echo 'Installare pwgen'."\n"; die(); }
                    if ($a->username=='postmaster') continue;
                    echo $a->username.'@'.$a->domain.' : '.$x."\n";
                    $salt = substr(sha1(rand()), 0, 16);
                    $a->password = "{SHA512-CRYPT}" . crypt($x, "$6$$salt");;
                    $a->save();
            }
    }


}

