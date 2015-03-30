<?php

namespace backend\controllers;

use Yii;
use backend\Models\Workerother;
use backend\Models\WorkerotherSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkerotherController implements the CRUD actions for Workerother model.
 */
class WorkerotherController extends Controller
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
     * Displays a single Workerother model.
     * @param string $id
     * @return mixed
     */
    public function actionView($worker_id)
    {
        $model = $this->findModel($worker_id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * Creates a new Workerother model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Workerother;
        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
            $this->saveWorkerOther($model,$params);
            return $this->redirect(['view', 'worker_id' => $params['worker_id']]);
        }else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Workerother model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($worker_id,$act='')
    {
        $model =Workerother::findAll(['worker_id'=>$worker_id]);
        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
            //先全部删除，再重新入库
            $this->delete($worker_id);
            $this->saveWorkerOther($model,$params);
            return $this->redirect(['view', 'worker_id' => $worker_id]);
        }else{
            return $this->render('update', [
                'model' => $model,
            ]);
       }
    }

    /**
     * Deletes an existing Workerother model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $worker_id
     * @return mixed
     */
    public function delete($worker_id)
    {
        Workerother::deleteAll(['worker_id'=>$worker_id]);
    }

    /**
     * Finds the Workerother model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $worker_id
     * @return Workerother the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($worker_id)
    {
        if (($model = Workerother::find()->where(['worker_id' => $worker_id])->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     *  新增和修改护工其他信息时，共用方法
     * @param $model
     * @param $params
     */

    protected function saveWorkerOther($model,$params){
        $worker_id = $params['worker_id'];
        for ($i = 1; $i <= 4; $i++) {
            if ($i == 2 || $i == 4) {
                $max = 0;
            } else {
                $max = 2;
            }
            for ($j = 0; $j <= $max; $j++) {
                $key1 = 'ext1_' . $i;
                $key2 = 'ext2_' . $i;
                $key3 = 'ext3_' . $i;
                $key4 = 'ext4_' . $i;
                $ext1='';
                $ext2='';
                $ext3='';
                $ext4='';
                $ext1 = $params[$key1][$j];
                if($i<>2){
                    $ext2 = $params[$key2][$j];
                    $ext3 = $params[$key3][$j];
                    $ext4 = $params[$key4][$j];
                }
                $sql = "INSERT INTO `yayh_workerother` (`worker_id`,`ext1`,`ext2`,`ext3`,`ext4`,`info_type`) VALUES ($worker_id,'$ext1','$ext2','$ext3','$ext4',$i)";
                Workerother::workerOtherAdd($sql);

            }
        }
    }
}
