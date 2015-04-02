<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

use backend\models\User;
use backend\models\Tq;
use backend\models\LoginForm;
use yii\filters\AccessControl;

class TqController extends Controller
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
                        'actions' => ['index', 'select'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }
/*
 * TQ客服登录跳转此方法
 * */
    public function actionIndex()
    {
        if(isset($_GET['uin']) && !empty($_GET['uin']))
        {
            $username = $_GET['uin'];
            $LoginForm = array('username' => $username, 'password' => '111111', 'rememberMe' => '1');
            $model = new LoginForm();
            $model_TQ = new Tq();
            $model->attributes = $LoginForm;
            if($model->login() && $model_TQ->load_TQ($LoginForm))
            {
                return $this->redirect(['order/index']);
            } else {
                return $this->redirect(['site/login']);
            }
        }
    }
/*
 * TQ外呼与呼入时调用此方法
 * */
    public function actionSelect()
    {
            if(isset($_GET['callerid']) && !empty($_GET['callerid'])) {
                $callid = $_GET['callerid'];
                $userModel = new User();
                $user = $userModel->findByMobile($callid);
                if ($user && isset($user->id)) {
                    $uid = $user->id;
                    $this->redirect(['user/view', 'id' => $uid]);
                } else {
                    $this->redirect(['order/create', 'callid' => $callid]);
                }
            }
    }

}
