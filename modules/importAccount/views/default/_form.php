<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\importAccount\models\ImportParcelAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="import-parcel-account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'client_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_update')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
