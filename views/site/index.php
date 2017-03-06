<?php
use app\modules\user\components\UserWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\payment\models\PaymentsList;
use yii\jui\DatePicker;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
$this->title = 'Shipping to USA and Canada';
?>
    <div class="site-index">
        <?= skinka\widgets\gritter\AlertGritterWidget::widget() ?>
        <?php if (Yii::$app->session->hasFlash('signup-success')) { ?> <p> <?= Yii::$app->session->getFlash('signup-success');  ?> </p>  <?php } ?>
        <?php if (Yii::$app->session->hasFlash('reset-success')) { ?> <p> <?= Yii::$app->session->getFlash('reset-success');  ?> </p>  <?php } ?>

        <?= UserWidget::widget() ?>

    </div>
<?php
if (!Yii::$app->user->isGuest) {
    ?>
    <h4 class="modernui-neutral2">My Orders</h4>
    <div class="row">
        <div class="col-md-12">
            <?= Html::a('<i class="fa fa-magic"></i> Create New Order', ['/orderInclude/create-order/'], ['class' => 'btn btn-success pull-right']) ?>
            <?= Html::a('<i class="fa fa-search"></i>', ['#collapse'], ['class' => 'btn btn-neutral-border','data-toggle' => 'collapse']) ?>
            <hr class="bottom_line">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 scrit">
            <?= $this->render('orderFilterForm', ['model' => $filterForm]);?>
        </div>
    </div>

    <div class="table-responsive">
        <?= GridView::widget(['dataProvider' => $orders, 'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                ['attribute'=> 'order_status',
                    'content' => function($data){
                        return $data::orderStatusText($data->order_status);
                    },
                ],
                ['attribute'=> 'created_at',
                    'content'=> function($data){
                        if ($data->created_at == 0) return '-';
                        else return date(\Yii::$app->params['data_time_format_php'],$data->created_at);
                    },
                    'format' => 'raw',
                ],
                ['attribute'=> 'transport_data',
                    'content'=> function($data){
                        if ($data->transport_data == 0) return '-';
                        else return date(\Yii::$app->params['data_time_format_php'],$data->transport_data);
                    }],
                ['attribute'=> 'payment_type',
                    'content' => function($data){
                        return PaymentsList::getPayStatus()[$data->payment_type];
                    },
                    'filter' => PaymentsList::getPayStatus(),
                ],
                ['attribute'=> 'payment_state',
                    'content' => function($data){
                        return PaymentsList::getTextStatus()[$data->payment_state];
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
                ['content' => function($data){
                    switch ($data->order_status) {
                        case '0' : return  Html::a('Update Order', ['/orderInclude/create-order/'.$data->id], ['class' => 'btn btn-info']); break;
                        case '1' : return Html::a('Order has been paid', ['/payment/index'], ['class' => 'btn btn-danger']);break;
                        case '2' : return Html::a('Update PDF', ['/'], ['class' => 'btn btn-warning']);break;
                        case '3' : return Html::a('View', ['/order/view/'.$data->id], ['class' => 'btn btn-info']);break;
                        default: return "Unknown status - ".$data->order_status;
                    }
                }],
            ],
        ]); ?>
    </div>
    <hr>
<?php }?>