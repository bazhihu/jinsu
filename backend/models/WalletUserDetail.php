<?php

namespace backend\models;

use Yii;
use common\models\Wallet;

/**
 * This is the model class for table "{{%wallet_user_detail}}".
 *
 * @property integer $detail_id
 * @property string $detail_id_no
 * @property integer $order_id
 * @property string $order_no
 * @property integer $worker_id
 * @property integer $uid
 * @property string $detail_money
 * @property integer $detail_type
 * @property string $wallet_money
 * @property string $detail_time
 * @property string $remark
 * @property string $pay_from
 * @property string $extract_to
 * @property integer $admin_uid
 */
class WalletUserDetail extends Wallet
{

}
