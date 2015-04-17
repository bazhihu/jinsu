<?php
/**
 * Created by PhpStorm.
 * User: HZQ
 * Date: 2015/4/15
 * Time: 0:31
 */

namespace api\modules\v1\controllers;

use backend\models\Comment;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\QueryParamAuth;

class CommentController extends ActiveController {
    public $modelClass = 'backend\models\comment';
    public $responseCode = 200;
    public $responseMsg = null;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return ArrayHelper::merge($behaviors, [
            'authenticator' => [
                'class' => QueryParamAuth::className()
            ],
        ]);
    }
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index'], $actions['view'], $actions['delete'], $actions['create'] ,$actions['update'] ,$actions['options']);

        return $actions;
    }

    /**
     * 评价列表
     * @param $id 护工ID
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionView($id)
    {
        $worker_id = $id;
        $comments = Comment::find()
            ->andFilterWhere(['worker_id'=>$worker_id])
            ->orderBy('comment_id DESC')
            ->all();
        return $comments;
    }

    /**
     * 评价
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate(){
        $post = Yii::$app->getRequest()->getBodyParams();

        $comment = \common\models\Comment::createComment($post);
        if(!$comment){
            $this->responseCode = 500;
            $this->responseMsg = '评论失败';
            return null;
        }
        return [];
    }

    /**
     * 返回数据处理
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        $response = [
            'code' => $this->responseCode,
            'msg' => $this->responseMsg,
            'data' => null
        ];
        $result = parent::afterAction($action, $result);
        $response['data'] = $result;
        return $this->serializeData($response);
    }
}