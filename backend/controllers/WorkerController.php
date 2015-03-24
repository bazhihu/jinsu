<?php

namespace backend\controllers;

use Yii;
use backend\Models\Worker;
use backend\Models\WorkerSearch;
use backend\Models\City;
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
     * Creates a new Worker model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Worker;

        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            if($params['Worker']['certificate']){
                $params['Worker']['certificate'] =implode(',', $params['Worker']['certificate']);
            }
            if ($params['Worker']['hospital_id']) {
                $params['Worker']['hospital_id'] = implode(',', $params['Worker']['hospital_id']);
            }
            if ($params['Worker']['office_id']) {
                $params['Worker']['office_id'] = implode(',', $params['Worker']['office_id']);
             }

            if($params['Worker']['good_at']) {
                $params['Worker']['good_at'] = implode(',', $params['Worker']['good_at']);
            }

            //户口所在地
            if($params['Worker']['birth_place']){
                $params['Worker']['birth_place'] =$params['Worker']['birth_place'].",".$params['Worker']['birth_place_city'].",".$params['Worker']['birth_place_area'];
            }

            //添加时间
            $params['Worker']['add_date'] = date('Y-m-d H:i:s');
            $params['Worker']['adder'] = yii::$app->user->getId();

            $worker = new Worker();

            $worker->createWorker($params);
            return $this->redirect(['view', 'id' => $worker->worker_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Worker model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        var_dump($model->certificate);
        die();

        if($params['Worker']['certificate']){
            $params['Worker']['certificate'] =implode(',', $params['Worker']['certificate']);
        }
        if ($params['Worker']['hospital_id']) {
            $params['Worker']['hospital_id'] = implode(',', $params['Worker']['hospital_id']);
        }
        if ($params['Worker']['office_id']) {
            $params['Worker']['office_id'] = implode(',', $params['Worker']['office_id']);
        }

        if($params['Worker']['good_at']) {
            $params['Worker']['good_at'] = implode(',', $params['Worker']['good_at']);
        }

        //户口所在地
        if($params['Worker']['birth_place']){
            $params['Worker']['birth_place'] =$params['Worker']['birth_place'].",".$params['Worker']['birth_place_city'].",".$params['Worker']['birth_place_area'];
        }

        //添加时间
        $params['Worker']['add_date'] = date('Y-m-d H:i:s');
        $params['Worker']['adder'] = yii::$app->user->getId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->worker_id]);
        } else {
            return $this->render('update', [
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $birth_place = $parents[0];
                $out = City::getListPlace($birth_place);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    //获取选定城市下的区县
    public function actionGetarea() {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            $birth_place_city = $parents[0];
            if ($birth_place_city != null) {
                $out = City::getListPlace($birth_place_city);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
}
