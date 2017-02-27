<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;
use app\components\ParcelPrice;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\orderInclude\models\OrderIncludeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Border Form';
$this->params['breadcrumbs'][] = $this->title;


$submitOption = [
  'class' => 'btn btn-lg btn-success'
];

$form = ActiveForm::begin([
  'options' => ['class'=>'order_agreement'],
  'validateOnChange' => true,
]);
?>
<h4 class="modernui-neutral2">Print Border Form</h4>
<div class="row">
    <div class="col-md-offset-4 col-md-4">
        <div class="trans_text">You added <span class="trans_count"><?=count($order_elements);?> order</span>, value <span class="trans_count"><?=$total['price'];?>$</span> , width <span class="trans_count"><?=$total['weight'];?>lb</span></div>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-4 col-md-4">

    <div class="trans_text">When you need us to transport your orders to The US :</div>



    <div class="row">
    <div class="col-md-12">
    <?=$form->field($model, 'transport_data')->widget(DatePicker::className(),[
    'name' => 'check_issue_date',
    'removeButton' => false,
    //'value' => date('d-M-Y', strtotime('+1 days')),
    'options' => ['placeholder' => 'Choose date'],
    'pluginOptions' => [
      'startDate' => date('d-M-Y', strtotime('+5 hours')),
      'format' => 'dd-M-yyyy',
      'todayHighlight' => true,
      'autoclose'=>true,
    ]
  ]);
?>
    </div>
    </div>
    </div>
</div>
<div class="row">
<div class="col-md-12 padding-top-10 text-center text_certif" >
  <?= $form->field($model, 'agreement')->checkbox(['label' => '<span class="fa fa-check otst"></span> I certify..,my undefstanding..Im responsible for cross-bording, law, etc'])->label("") ?>

</div>
</div>
<hr>
<div class="form-group">
<?=Html::a('Print Border Form ABC123', ['/orderInclude/border-form-pdf/'.$order_id],
  [
    'class'=>'btn btn-info on_agreement',
    'target'=>'_blank',
    'data-toggle'=>'tooltip',
    'title'=>'Will open the generated PDF file in a new window'
  ])?>


  <?= Html::submitButton('Next <i class="glyphicon glyphicon-chevron-right"></i> ', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-success pull-right']) ?>
</div>

<?php ActiveForm::end(); ?>

<script>
  $(document).ready(function() {
    init_order_border()
  })
  var odrer_id=<?=$order_id;?>;
</script>
