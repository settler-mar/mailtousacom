<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\orderInclude\models\OrderInclude */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-include-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'no_foreign_letters form-control']) ?>

    <?= $form->field($model, 'price')->textInput([
      'autocomplete'=>"off"
    ]) ?>

    <?= $form->field($model, 'country')->widget(Select2::classname(), [
        'data' => Yii::$app->params['country'],
        'language' => 'en',
        'options' => ['placeholder' => 'Select the country','tabindex'=>'10'],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ]);?>

    <?= $form->field($model, 'quantity')->textInput([
      'autocomplete'=>"off"
    ]) ?>

  <?= $form->field($model, 'reference_number')->textInput([
      'autocomplete'=>"off"
    ]) ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<script>
    $('#ajaxCrudModal').removeAttr("tabindex")
</script>