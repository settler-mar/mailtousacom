<?php

namespace app\modules\payment\models;

use Yii;

/**
 * This is the model class for table "payments_list".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $order_id
 * @property integer $status
 */
class PaymentsList extends \yii\db\ActiveRecord
{
    public static function getTextStatus(){
        return array(
            ''=>'All',
            '0'=>"Don't paid",
            '1'=>'Through Paypal',
            '2'=>'On the delivery address',
            '3'=>'Per Month',
            '4'=>'Unknown'
        );
    }

    public static function statusText($param)
    {
        $textForStatus = PaymentsList::getTextStatus();
        if ($param < (count($textForStatus)-1)) return  $textForStatus[$param];
        else return 'Unknown status';
    }
    public static function getPayStatus(){
        return array(
            ''=>'All',
            '0'=>"0t",
            '1'=>'1t',
            '2'=>'2t',
            '3'=>'3t',
            '4'=>'Unknown'
        );
    }

    public static function statusPayText($param)
    {
        $textForStatus = PaymentsList::getPayStatus();
        if ($param < (count($textForStatus)-1)) return  $textForStatus[$param];
        else return 'Unknown pay system';
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['type', 'order_id', 'price', 'code','client_id'], 'required'],
          [['type', 'order_id', 'status','client_id','pay_time','create_time'], 'integer'],
          [['price','qst','gst'], 'number'],
          [['code'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'status' => 'Status',
          'qst' => 'PST (%)',
          'gst' => 'GST/HST (%)',
        ];
    }
}
