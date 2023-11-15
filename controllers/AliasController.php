<?php

namespace app\controllers;

use Yii;
use app\models\Alias;
use app\models\AliasSearch;
use app\models\Domain;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * AliasController implements the CRUD actions for Alias model.
 */
class AliasController extends Controller
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
                        'actions' => ['index','view','create','delete','update'],
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
     * Lists all Alias models.
     * @return mixed
     */
    public function actionIndex($domain)
    {
        //$this->loadDomain($id);
        $searchModel = new AliasSearch();
        $params = Yii::$app->request->queryParams;
        $params['AliasSearch']['domain']=$domain;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$this->findDomain($domain),
        ]);
    }

    /**
     * Displays a single Alias model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Alias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($domain)
    {
        $model = new Alias();
        $model->domain = $domain;
        $model->active = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'domain' => $model->domain,'username'=>$model->username]);
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
    public function actionUpdate($username,$domain)
    {
        $model = new Alias();
        $model->username = $username;
        $model->domain = $domain;
        $model->active=1;
        

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // cancelliamo i vecchi alias e mettiamo i nuovi
            return $this->redirect(['index', 'domain' => $model->domain]);
        }
        $dataProvider = new ActiveDataProvider([
            'query'=>$model->getDestinations(),
            'pagination'=>false,
        ]);


        return $this->render('update', [
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ]);
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id=null,$username=null,$domain=null)
    {
        if ($id!=null) {
                $model = $this->findModel($id);
                $model->delete();
        } else if ($username!=null && $domain!=null) {
                $model = Alias::find()->where(['username'=>$username,'domain'=>$domain])->one();
                foreach (Alias::find()->where(['username'=>$username,'domain'=>$domain])->all() as $a) {
                        $a->delete();
                }
        } else {
                return $this->redirect(['index']);
        }
 
        if (Alias::find()->where(['username'=>$model->username,'domain'=>$model->domain])->count()>0) {
            return $this->redirect(['update','username'=>$model->username,'domain'=>$model->domain]);
        }
        return $this->redirect(['index','domain'=>$model->domain]);
    }

    /**
     * Finds the Alias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Alias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Alias::findOne($id)) !== null) {
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
