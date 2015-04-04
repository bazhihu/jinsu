<?php

namespace backend\controllers;

use backend\models\OrderMaster;
use backend\models\Worker;
use common\models\Order;
use kartik\alert\Alert;
use Yii;
use backend\models\Comment;
use backend\models\CommentSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommentSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        $comment_id_array = Yii::$app->request->post('selection');
        if($comment_id_array){
            $comment_ids = implode(',',$comment_id_array);
           // Comment::updateAll("comment_id in ("..")")";
        }


       // die();
      //  if($audit_yes)

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Comment model.
     * @param string $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//        return $this->redirect(['view', 'id' => $model->comment_id]);
//        } else {
//        return $this->render('view', ['model' => $model]);
//}
//    }

    /**
     * Creates a new Comment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($order_no)
    {
        $model = new Comment;

        if ($model->load(Yii::$app->request->post())) {
            $params_all = Yii::$app->request->post();
            $params =  $params_all['Comment'];
            $params['order_no'] = $order_no;
            $params['status'] = 1;
            $params['comment_date'] = date('Y-m-d H:i:s');
            $params['adder'] = yii::$app->user->getId();
            $params['type'] = 'system';
            //查找订单表，找护工编号,护工姓名
            $order_info = OrderMaster::findOne(['order_no' => $order_no]);
            $params['worker_name'] = $order_info['worker_name'];
            $params['worker_id'] = $order_info['worker_no'];
            $params['uid'] = $order_info['uid'];
            $params['comment_ip'] = Yii::$app->request->userIP;
            $model->attributes = $params;
            if ($model->save()) {
                //更新订单状态
                $orderModel = OrderMaster::findOne(['order_no'=>$order_no]);
                if($orderModel){
                    $commentStatus = $orderModel->evaluate();
                    Yii::$app->getSession()->setFlash('alert',$commentStatus['msg']);
                    return $this->redirect(Url::toRoute('comment/index'));
                }

            }else {
                return $this->render('create', ['model' => $model]);
            }
        }else{
            return $this->render('create', ['model' => $model]);
        }
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
   /* public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $params_all = Yii::$app->request->post();
            $params =  $params_all['Comment'];
            $params['edit_date'] = date('Y-m-d H:i:s');
            $params['editer'] = yii::$app->user->getId();
            $model->attributes = $params;
            if ($model->save()) {
                return $this->redirect(Url::toRoute('comment/index'));
            }else {
                return $this->render('update', ['model' => $model]);
            }
        }else{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Comment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
  /*  public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Comment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
