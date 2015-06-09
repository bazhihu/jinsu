<?php

namespace backend\controllers;

use backend\models\OrderMaster;
use Yii;
use backend\models\Worker;
use backend\models\WorkerSearch;
use backend\models\City;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;


/**
 * WorkerController implements the CRUD actions for Worker model.
 */
class WorkerController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'upload' => ['post']
                ],
            ],
        ];
    }

    /**
     * Lists all Worker models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkerSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        $workerIdArray = Yii::$app->request->post('selection');
        $op = Yii::$app->request->post('op');

       // die();
        //上线OR下线
        if($workerIdArray) {
            $worker_ids = implode(',', $workerIdArray);
            Worker::workerAudit($worker_ids,$op);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Worker model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->worker_id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Finds the Worker model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Worker the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Worker::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Worker model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        $model = new Worker;

        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            $params['start_work'] = str_replace('年','-',$params['start_work']);
            $params['start_work'] = str_replace('月','-',$params['start_work']);
            $params['Worker']['start_work'] = $params['start_work']."01";

            $model->attributes = $model->saveData($params['Worker'], 'create');
            if ($model->save()){
                //上传照片
                $model->uploadPic($model->worker_id);
                return $this->redirect(["workerother/update", "worker_id" => $model->worker_id]);
            }else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Worker model.
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
     * Updates an existing Worker model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id){
        $model = $this->findModel($id);

        //户口所在地
        if($model['birth_place']){
            $place = explode(',',$model['birth_place']);
            $model->birth_place = @$place[1];
            $model->birth_place_city = @$place[2];
            $model->birth_place_area = @$place[3];
        }

        //资质证书
        if($model['certificate']){
            $model['certificate']= explode(',',$model['certificate']);
        }

        //常住医院
        if($model['hospital_id']){
            $model['hospital_id']= explode(',',$model['hospital_id']);
        }

        if($model['office_id']){
            $model['office_id']= explode(',',$model['office_id']);
        }

        if($model['start_work']){
            $model['start_work']= substr($model['start_work'],0,7);
            $model['start_work']= str_replace('-','年',$model['start_work'])."月";
        }
//        if($model['good_at']){
//            $model['good_at']= explode(',',$model['good_at']);
//        }

        $pic = $model['pic'];
        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();

            $startWork = str_replace('年', '-', str_replace('月', '-', $params['start_work']));
            $params['Worker']['start_work'] = $startWork."01";
            if($pic){
                $params['Worker']['pic'] = $pic;
             }

            $model->attributes = $model->saveData($params['Worker'], 'create');
            if ($model->save()) {
                //上传照片
                $model->uploadPic($model->worker_id);

                return $this->redirect(["workerother/update", "worker_id" => $model->worker_id]);
            }else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateCities()
    {
        //cities
        $data = AddCities::model()->findAll('provinceid=:idProvince',array(':idProvince'=>(int)$_POST['idProvince']));
        $data = Html::listData($data,'cityid','city');
        $dropDownCities = "选择城市";
        foreach($data as $value=>$name){
            $dropDownCities = Html::tag('option',array('value'=>$value),Html::encode($name),true);
        }

        //District
        $dropDownDistricts = "选择区域";

        //return data(JSON formatted)
        echo CJSON::encode(array(
            'dropDownCities'=>$dropDownCities,
            'dropDownDistricts'=>$dropDownDistricts
        ));
    }

    public function actionUpdateUpdateDistricts()
    {
        $data = AddAreas::model()->findAll('cityid=:idCity',array(':idCity'=>(int)$_POST['idCity']));
        $data = Html::listData($data,'areaid','area');
        echo "选择区域";
        foreach($data as $value=>$name){
            echo Html::tag('option',array('value'=>$value),Html::encode($name),true);
        }
    }


    // 获取选定省份下的城市
    public function actionGetcity() {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $birthPlace = $parents[0];
                $data = City::getList($birthPlace, false, false);
                echo Json::encode(['output'=>$data,'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    //获取选定城市下的区县
    public function actionGetarea() {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            $birthPlaceCity = $parents[0];
            if ($birthPlaceCity != null) {
                $out = City::getList($birthPlaceCity, false, false);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * 选择护工
     * @return bool|string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     * @author zhangbo
     */
    public function actionSelect(){
        //设置已选择的护工
        if(isset($_POST['order_id']) && isset($_POST['worker_id'])){
            $orderId = $_POST['order_id'];
            $workerId = $_POST['worker_id'];
            $startTime = $_POST['start_time'];

            $worker = Worker::findOne($workerId);
            if(empty($worker)){
                throw new NotFoundHttpException('找不到护工');
            }

            //判断护工是否在工作中
//            if(WorkerSchedule::isWorking($workerId, $startTime)){
//                $response = ['code' => '412', 'msg' => '此护工已被预定，请选择其他护工'];
//                echo Json::encode($response);
//                return false;
//            }

            $response = OrderMaster::setWorker($orderId, $workerId, $worker->name);
            echo Json::encode($response);
            return false;
        }

        $template = Yii::$app->getRequest()->get('template');
        if($template == 'select_modal'){
            $this->layout = "modal.php";
            if(empty($_GET['start_time']) || empty($_GET['city_id'])){
                throw new BadRequestHttpException('请求参数错误');
            }

            $orderId = 0;
            $startTime = $_GET['start_time'];
            $cityId = $_GET['city_id'];

        }else{
            $template = 'select';
            if(empty($_GET['order_id']) || empty($_GET['start_time']) || empty($_GET['city_id'])){
                throw new BadRequestHttpException('请求参数错误');
            }

            $orderId = $_GET['order_id'];
            $startTime = $_GET['start_time'];
            $cityId = $_GET['city_id'];
        }

        //获取在工作中的护工
        $searchModel = new WorkerSearch;
        $dataProvider = $searchModel->select(Yii::$app->request->getQueryParams());


        return $this->render($template, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'orderId' => $orderId,
            'startTime' => $startTime,
            'cityId' => $cityId
        ]);
    }

    public function actionSchedule(){

        return $this->render('schedule');
    }
}