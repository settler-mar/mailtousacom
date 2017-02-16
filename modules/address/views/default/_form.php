<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\state\models\State;

/* @var $this yii\web\View */
/* @var $model app\modules\address\models\Address */
/* @var $form yii\widgets\ActiveForm */
// формируем массив, с ключем равным полю 'id' и значением равным полю 'name'
$states = State::find()->all();
$state_names = ArrayHelper::map($states,'name','name');
?>

<div class="address-form">

    <?php $form = ActiveForm::begin([
      'options' => ['class'=>'add_new_address'],
      'id'=>'created_address',
      'validateOnChange' => true,
    ]); ?>

    <?= $form->field($model, 'address_type')->checkbox(['label' => 'Personal/Corporate', 'class'=>'show_company'])->label("Type") ?>

    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'class'=>'company_name form-control']) ?>

    <?= $form->field($model, 'adress_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'adress_2')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-md-4">
    <?= $form->field($model, 'city')->textInput() ?>
        </div>
        <div class="col-md-4">
    <?= $form->field($model, 'zip')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    </div>
    </div>
    <?= $form->field($model, 'state')->dropDownList($state_names) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script>
  init_address_edit();
</script>