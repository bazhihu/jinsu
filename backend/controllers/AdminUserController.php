<?php

namespace backend\controllers;

use Yii;
use backend\models\AdminUser;
use backend\models\AdminUserSearch;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminUserController implements the CRUD actions for AdminUser model.
 */
class AdminUserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'view', 'create','update','delete','reset','default'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AdminUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminUserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Deletes an existing AdminUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

        if(Yii::$app->request->isAjax)
        {

            $admin = $this->findModel($id);
            $response = $admin->accountChanges();
            echo Json::encode($response);
        }
        exit;
    }
    /**
     * Displays a single AdminUser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel(['admin_uid'=>$id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else
        {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new AdminUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //Yii::$app->log->getLogger()->log('系统操作',Logger::LEVEL_ERROR);exit;
        $model = new AdminUser;
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AdminUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');
        if ($model->load(Yii::$app->request->post()) && $model->up()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            #员工职位
            $staff_role = yii::$app->authManager->getRoles();

            foreach($staff_role as $key=>$val)
            {
                $staff_role[$key]=$key;
            }

            $hospitals = \backend\models\Hospitals::find();
            foreach($hospitals->all() as $val){
                $hospital[$val->id] = $val->name;
            }

            $model->created_name = \backend\models\AdminUser::findOne(["admin_uid"=>$model->created_id])->username;
            return $this->render('update', [
                'model' => $model,
                'staff_role'=>$staff_role,
                'hospital'=>$hospital,
            ]);
        }
    }

    /**
     * 修改密码
     * @return string|\yii\web\Response
     */
    public function actionReset()
    {
        $model = new AdminUser();
        $model->setScenario('reset');
        if ($model->load(Yii::$app->request->post()) && $model->reset()) {
            return $this->redirect(['view', 'id' => yii::$app->user->identity->getId()]);
        }
        return $this->render('reset', [
            'model' => $model,
        ]);
    }

    /**
     * 恢复默认密码 123456
     * @throws NotFoundHttpException
     */
    public function actionDefault($id)
    {
        if(Yii::$app->request->isAjax)
        {
            $admin = $this->findModel($id);
            $response = $admin->defaultPwd();
            echo Json::encode($response);
        }
        exit;
    }

    /**
     * Finds the AdminUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
