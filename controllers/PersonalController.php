<?php


namespace app\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\ChangepasswordForm;


class PersonalController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['forward','password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionForward()
    {
        return $this->render('forward');
    }
    
    public function actionPassword()
    {
        $model = new ChangepasswordForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->user->identity->newpassword=$model->newpassword;
            Yii::$app->user->identity->save();
            Yii::$app->session->setFlash('success','Password was updated');
        }
        $model->newpassword='';
        $model->currentpassword='';
        $model->confirmpassword='';
        return $this->render('password', [
            'model'=>$model]);
    
    }
}
