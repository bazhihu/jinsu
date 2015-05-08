<?php
namespace backend\controllers;

use backend\models\AdminUser;
use backend\models\OrderMaster;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'captcha'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 6,
                'minLength' => 6,
                'height' => 45
            ],
        ];
    }

    public function actionIndex()
    {
        //$auth = Yii::$app->authManager;
        $data = [];
        if(Yii::$app->user->identity->staff_role == AdminUser::BACKOFFICESTAFF){
            $where = ['hospital_id' => Yii::$app->user->identity->hospital_id];
        }

        //待支付订单数
        $where['order_status'] = OrderMaster::ORDER_STATUS_WAIT_PAY;
        $waitPayCount = OrderMaster::find()->where($where)->count();
        $data['waitPayCount'] = $waitPayCount;

        //待确认订单数
        $where['order_status'] = OrderMaster::ORDER_STATUS_WAIT_CONFIRM;
        $waitConfirmCount = OrderMaster::find()->where($where)->count();
        $data['waitConfirmCount'] = $waitConfirmCount;

        //待服务订单数
        $where['order_status'] = OrderMaster::ORDER_STATUS_WAIT_SERVICE;
        $waitServiceCount = OrderMaster::find()->where($where)->count();
        $data['waitServiceCount'] = $waitServiceCount;

        //待评价订单数
        $where['order_status'] = OrderMaster::ORDER_STATUS_WAIT_EVALUATE;
        $waitEvaluateCount = OrderMaster::find()->where($where)->count();
        $data['waitEvaluateCount'] = $waitEvaluateCount;

        return $this->render('index', ['data' => $data]);
    }

    public function actionLogin()
    {
        $this->layout = "guest.php";
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->setScenario('login');
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
