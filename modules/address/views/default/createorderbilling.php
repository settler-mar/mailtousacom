<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;

CrudAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\address\models\AddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Billing address';
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Html::a('Main menu', ['/'], ['class' => 'btn btn-success']) ?>
<?= $this->render('_form', [
  'model' => $model,
  'show_button' => $show_button,
]) ?>