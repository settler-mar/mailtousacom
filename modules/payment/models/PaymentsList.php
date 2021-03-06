<?php

namespace app\modules\payment\models;

use Yii;
use app\modules\payment\models\PaymentInclude;
use app\modules\user\models\User;

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
  public $include_pay;

    public static function getTextStatus(){
        return array(
            ''=>'All',
            '0'=>"Don't paid",
            '1'=>'Through Paypal',
            '2'=>'On the delivery address',
            '3'=>'Per Month',
            '4'=>'Unknown',
            '-1'=>'Canceled',
        );
    }

    public static function statusText($param)
    {
        $textForStatus = PaymentsList::getTextStatus();
        if ($param < (count($textForStatus)-1)) return  $textForStatus[$param];
        else return 'Unknown status';
    }

    public static function statusTextParcel($param)
    {
        $textForStatus = PaymentsList::getTextStatusParcel();
        if ($param=='-1') return 'Canceled';
        if ($param < (count($textForStatus)-1)) return  $textForStatus[$param];
        else return 'Unknown status';
    }

    public static function getPayStatus(){
        return array(
            ''=>'All',
            '0'=>"-",
            '1'=>'PayPal',
            '2'=>'Per month',
            '3'=>'At the point',
            '4'=>'Unknown'
        );
    }

  public static function getTextStatusParcel(){
    return array(
      ''=>'All',
      '0'=>'<div class="dan_pay">Not pay</div>',
      '1'=>'<div class="awa_pay">Awaiting</div>',
      '2'=>'<div class="acc_pay">Accepted</div>',
      '3'=>'<div class="mon_pay">Pending</div><small>payment monthly</small>',
    );
  }

    public static function statusPayText($param)
    {
        $textForStatus = PaymentsList::getPayStatus();
        if ($param=='-1') return 'Canceled';
        if ($param < (count($textForStatus)-1)) return  $textForStatus[$param];
        else return 'Unknown pay system';
    }

    public function getStatusPay()
    {
      $param=$this->type;
      $textForStatus = PaymentsList::getPayStatus();
      if ($param=='-1') return 'Canceled';
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
          [['type','client_id'], 'required'],
          [['type', 'status','client_id','pay_time','create_time'], 'integer'],
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

  public static function create($option){
    $base_option=[
      'client_id'=>Yii::$app->user->identity->id,
      'user_id'=>Yii::$app->user->identity->id,
      'type'=>0,
      'create_time'=>time(),
    ];
    $option=array_merge($base_option,$option);

    $pay=new PaymentsList();
    foreach ($option as $k=>$v){
      $pay->$k=$v;
    }
    if($pay->save()){
      return $pay;
    }else{
      throw new NotFoundHttpException('Error creating order.');
    }

  }

  public function getPaymentInclude()
  {
    return $this->hasMany(PaymentInclude::className(),['payment_id' => 'id']);
  }

  public function getUser(){
    return User::find()->where(['id'=>$this->user_id])->one();
  }

  public function getClient(){
    return User::find()->where(['id'=>$this->client_id])->one();
  }

  public function setData($data){
    Yii::$app->db->createCommand()
      ->update('payment_include', $data, ['payment_id' => $this->id])
      ->execute();
  }
}
