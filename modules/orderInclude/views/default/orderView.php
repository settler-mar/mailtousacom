<?php
use app\modules\payment\models\PaymentsList;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use yii\widgets\Pjax;

CrudAsset::register($this);

$this->title = 'Order group';
$this->params['breadcrumbs'][] = $this->title;


?>
    <h4 class="modernui-neutral2">Group management of parcels</h4>
<div class="row">
<div class="col-md-3 text-center">
    <b>Total users</b> <div class="trans_count"><?=count($users);?></div>
</div>
    <div class="col-md-3 text-center">
        <b>Total parcels</b> <div class="trans_count"><?=count($parcels);?></div>
    </div>
    <div class="col-md-3 text-center">
        <b>Total weight</b> <div class="trans_count"><?=floor($total['weight']);?> Lb <?=floor(($total['weight']-floor($total['weight']))*16);?> Oz</div>
    </div>
    <div class="col-md-3">
    <?=Html::a('Set new status to group', ['/orderInclude/choose-status/'.$order_id],
  [
    'id'=>'choose_receiving_point',
    'role'=>'modal-remote',
    'class'=>'btn btn-default pull-right show_modal',
  ]
); ?>
</div>
</div>
    <hr class="bottom_line">
<div class="table-responsive">
<?php Pjax::begin(); ?>
<table class="table table-art" id="crud-datatable-pjax">
  <tr>
    <th>#</th>
    <th>User</th>
    <th>Parcels</th>
    <th>Total weight</th>
  </tr>

  <?php
    $user_num=1;
    foreach ($users as $user){
      ?>
      <tr data-toggle="collapse" data-target="#user_parcels_<?=$user->id;?>">
        <td><?=$user_num;?></td>
        <td><?=$user->getLineInfo();?></td>
        <td><?=count($users_parcel[$user->id]);?></td>
        <td>
          <?=floor($total['weight_by_user'][$user->id]);?> Lb
          <?=floor(($total['weight_by_user'][$user->id]-floor($total['weight_by_user'][$user->id]))*16);?> Oz
        </td>
      </tr>
      <tr id="user_parcels_<?=$user->id;?>" class="collapse">

        <td colspan="4" class="padding-off-top">
          <table class="table table-pod">
            <tr>
              <th>#</th>
              <th>Track Number</th>
              <th>Status</th>
              <th>Price</th>
              <th>PST</th>
              <th>GST/HST</th>
              <th>Payment State</th>
              <th>Weight</th>
              <th></th>
            </tr>
            <?php
              $parcel_n=1;
              foreach ($users_parcel[$user->id] as $parcel){
                ?>
                <tr>
                  <td><?=$parcel_n;?></td>
                  <td><?=$parcel->track_number;?></td>
                  <td><?=$parcel->getFullTextStatus();?></td>
                  <td><?=$parcel->price;?></td>
                  <td><?=$parcel->qst;?></td>
                  <td><?=$parcel->gst;?></td>
                  <td><?=PaymentsList::statusTextParcel($parcel->payment_state);?></td>
                  <td>
                    <?=floor($parcel->weight);?> Lb
                    <?=floor(($parcel->weight-floor($parcel->weight))*16);?> Oz
                  </td>
                  <td><?=Html::a('Remove from order',
                      ['/orderInclude/group-remove/'.$order_id."/".$parcel->id],
                      [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                          'confirm-message' => 'Are you sure to remove this item from this order?',
                          'confirm-title'=>"Remove",
                          'pjax'=>'false',
                          'toggle'=>"tooltip",
                          'request-method'=>"post",
                        ],
                        'role'=>"modal-remote",
                      ]); ?></td>
                </tr>
                <?php
                $parcel_n++;
              }
            ?>
          </table>
        </td>
      </tr>
      <?php
      $user_num++;
    }
  ?>
</table>

<?php Pjax::end(); ?>

</div>
<?php Modal::begin([
  "id"=>"ajaxCrudModal",
  "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>