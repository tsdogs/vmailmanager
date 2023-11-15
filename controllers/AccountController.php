<?php

namespace app\controllers;

use Yii;
use app\models\Account;
use app\models\AccountSearch;
use app\models\Domain;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex($domain)
    {
        $searchModel = new AccountSearch();
        $params = Yii::$app->request->queryParams;
        $params['AccountSearch']['domain']=$domain;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$this->findDomain($domain),
        ]);
    }

    /**
     * Displays a single Account model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $domain = $this->findDomain($model->domain);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Account model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($domain)
    {
        $this->findDomain($domain);
        $model = new Account();
        $model->domain = $domain;
        $model->scenario = 'insert';
        $model->active = 1;
        $model->send = 1;
        $model->receive = 1;
        $model->quota = 0;
        if (isset(Yii::$app->params['defaults']) && isset(Yii::$app->params['defaults']['Account'])) {
            foreach (Yii::$app->params['defaults']['Account'] as $f => $v) {
                $model->setAttribute($f,$v);
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['account/index','domain'=>$domain]);
            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Account model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $domain = $this->findDomain($model->domain);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'domain' => $model->domain]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index','domain'=>$model->domain]);
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    protected function findDomain($domain)
    {
        if (($model = Domain::findOne(['domain'=>$domain])) !== null) {
            if ($model->canUpdate())
                return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
}
