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
                        'actions' => ['logout', 'index', 'view', 'create','update','delete'],
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
    public function actionDelete($id="") {

        if(Yii::$app->request->isAjax && Yii::$app->user->identity->getId())
        {
            #操作的id
            $id = Yii::$app->request->post()['id'];
            if($id){
                //$ispass = yii::$app->authManager->checkAccess(Yii::$app->user->identity->getId(),'关闭'.$this->findModel($id)->staff_role);

                $value = $this->findModel($id)->status?0:10;
                if($this->findModel($id)->updateAttributes(['status'=>$value]))
                    echo Json::encode(['code'=>200,'message'=>'success']);
                exit;
            }
        }
        echo Json::encode(['code'=>400,'message'=>'操作失败']);
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
