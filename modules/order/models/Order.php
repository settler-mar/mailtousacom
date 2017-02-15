<?php

namespace app\modules\order\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $billing_address_id
 * @property integer $order_type
 * @property integer $user_id
 * @property integer $user_id_750
 * @property integer $order_status
 * @property string $created_at
 * @property string $transport_data
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['billing_address_id', 'order_type', 'user_id', 'user_id_750', 'order_status'], 'required'],
            [['billing_address_id', 'order_type', 'user_id', 'user_id_750', 'order_status'], 'integer'],
            [['created_at', 'transport_data'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'billing_address_id' => 'Billing Address ID',
            'order_type' => 'Order Type',
            'user_id' => 'User ID',
            'user_id_750' => 'User Id 750',
            'order_status' => 'Order Status',
            'created_at' => 'Created At',
            'transport_data' => 'Transport Data',
        ];
    }
}
