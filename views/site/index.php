<?php
use app\modules\user\components\UserWidget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\modules\payment\models\PaymentsList;
use yii\jui\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;

CrudAsset::register($this);
/* @var $this yii\web\View */
$this->title = 'Shipping to USA and Canada';


    ?>
    <?php if (Yii::$app->params['showAdminPanel']!=1) { ?> <h4 class="modernui-neutral2">My Orders</h4> <?php } ?>

    <div class="row">

        <?php if ($orderElements) { ?>
          <div class="col-xs-2">
            <?= Html::a('<i class="fa fa-search"></i>', ['#collapse'], ['class' => 'btn btn-neutral-border ','data-toggle' => 'collapse']) ?>
          </div>
        <?php } ?>

        <hr class="bottom_line">
        <div class="row">
          <div class="col-md-12 scrit">
            <?= $this->render('elementFilterForm', ['model' => $filterForm]);?>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <?= $this->render('showParcelTableForm', ['model' => $showTable]);?>
          </div>
        </div>

        <div class="col-xs-3 pull-right">
          <?=Html::a('<i class="fa fa-magic"></i>Create new order', ['/order/create/'],
            [
              'role'=>'modal-remote',
              'class'=>'btn btn-success show_modal',
            ])?>
        </div>

    </div>
    <hr class="bottom_line">

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $orderElements,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
           //   'userOrder_id',
                ['attribute'=> 'order_id',
                  'visible' => (Yii::$app->params['showAdminPanel']==1),
                  'format' => 'raw',
                  'label'=>'Order ID',
                  'content'=> function($data){return $data->order_id; if ($data->user!=null)
                    return $data->user->lineInfo; else return '-empty-';
                  }
                ],
                ['attribute'=> 'status',
                  'content' => function($data){
                        return $data::elementStatusText($data->status);
                    },
                ],
                ['attribute'=> 'created_at',
                    'content'=> function($data){
                        if ($data->created_at == 0) return '-';
                        else return date(Yii::$app->params['data_time_format_php'],$data->created_at);
                    },
                    'format' => 'raw',
                ],
 //               ['attribute'=> 'transport_data',
   //                 'content'=> function($data){
     //                   if ($data->transport_data == 0) return '-';
       //                 else return date(\Yii::$app->params['data_format_php'],$data->transport_data);
         //           }],
                ['attribute'=> 'payment_state',
                  'content' => function($data){
                    return PaymentsList::statusText($data->payment_state);
                  },
                ],
                ['attribute'=> 'payment_type',
                  'content' => function($data){
                    return PaymentsList::statusPayText($data->payment_type);
                  },
                ],
                [
                    'attribute' => 'price',
                    'content'=> function($data){
                        if ($data->price == 0) return '-';
                        else return number_format($data->price,2);
                    },
                    'format'=>['decimal',2]
                ],
                [
                    'attribute' => 'qst',
                    'content'=> function($data){
                        if ($data->qst == 0) return '-';
                        else return number_format($data->qst,2);
                    },
                    'format'=>['decimal',2]
                ],
                [
                    'attribute' => 'gst',
                    'content'=> function($data){
                        if ($data->gst == 0) return '-';
                        else return number_format($data->gst,2);
                    },
                    'format'=>['decimal',2]
                ],
                [
                    'attribute' => 'total',
                    'content'=> function($data){
                        if ($data->gst == 0) return '-';
                        else return number_format($data->gst+$data->qst+$data->price,2);
                    },
                    'format'=>['decimal',2]
                ],

                // 'order_status',
                // 'created_at',
                // 'transport_data',
              //  ['attribute' => 'Action','content' => function($data){
              //      switch ($data->order_status) {
              //          case '0' : return  Html::a('Update Order', ['/orderInclude/create-order/'.$data->id], ['class' => 'btn btn-sm btn-info']); break;
              //          case '1' : return Html::a('Order has been paid', ['/payment/index'], ['class' => 'btn btn-sm btn btn-danger']);break;
                //        case '2' : return Html::a('Update PDF', ['/'], ['class' => 'btn btn-sm btn-warning']);break;
                  //      case '3' : return Html::a('View', ['/order/view/'.$data->id], ['class' => 'btn btn-sm btn-info']);break;
              //          default: return "Unknown status - ".$data->order_status;
                //    }
                //}],
            ],
        ]); ?>
    </div>


<?php Modal::begin([
  "id"=>"ajaxCrudModal",
  "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>