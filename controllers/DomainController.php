<?php

namespace app\controllers;

use Yii;
use app\models\Domain;
use app\models\DomainSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DomainController implements the CRUD actions for Domain model.
 */
class DomainController extends Controller
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
                        'actions' => ['index','alias','view','create','delete','update','update-alias','create-alias'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Domain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DomainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('domain.destination=domain.domain or domain.destination is NULL');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAlias($domain)
    {
        $model = $this->findDomain($domain);

        $searchModel = new DomainSearch();
        $params = Yii::$app->request->queryParams;
        $params['DomainSearch']['destination']=$domain;
        $dataProvider = $searchModel->search($params);
        $dataProvider->query->andWhere('domain.destination!=domain.domain');

        return $this->render('alias', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }
    
   
    /**
     * Displays a single Domain model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    public function actionView($id) 
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();   
        // process ajax delete
        if (Yii::$app->request->isAjax && isset($post['kvdelete'])) {
            echo Json::encode([
                'success' => true,
                'messages' => [
                    'kv-detail-info' => 'Domain was successfully deleted. ' . 
                        Html::a('<i class="fas fa-hand-right"></i>  Click here', 
                            ['/domains/index'], ['class' => 'btn btn-sm btn-info']) . ' to proceed.'
                ]
            ]);
            return;
        }
        // return messages on update of record
        if ($model->load($post) && $model->save()) {
            Yii::$app->session->setFlash('kv-detail-success', 'Domain updated');
        }
        return $this->render('view', ['model'=>$model]);
    }
    /**
     * Creates a new Domain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Domain();
        $model->active = 1;
        $model->quota = 0;
        $model->aliases =0;
        $model->mailboxes = 0;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateAlias($domain)
    {
        $model = new Domain;
        $model->destination = $domain;
        $model->scenario = 'alias';
        $model->active = 1;
        $model->quota = 0;
        $model->aliases =0;
        $model->mailboxes = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['alias', 'domain' => $domain]);
        }

        return $this->render('create-alias', [
            'model' => $model,
        ]);
        
    }
    
    /**
     * Updates an existing Domain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateAlias($id)
    {
        $model = $this->findModel($id);
        $model->scenario='alias';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['alias', 'domain' => $model->destination]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    /**
     * Deletes an existing Domain model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Domain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Domain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Domain::findOne($id)) !== null) {
            if ($model->canUpdate())
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
