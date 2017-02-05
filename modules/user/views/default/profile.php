<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\components\fileImageInput\FileInput;

$submitOption = [
  'class' => 'btn btn-lg btn-success'
];

if ( Yii::$app->session->hasFlash('success')) {
  ?>
  <script type='text/javascript'>
    $(document).ready(function () {
      popup.open({message: '<?=Yii::$app->session->getFlash('success');?>', type: 'success',time:10000});
    });
  </script>
  <?php
};

$form = ActiveForm::begin([
  'layout' => 'horizontal',
  'enableAjaxValidation' => false,
  'enableClientValidation' => true,
  'options' => ['enctype'=>'multipart/form-data']
]); ?>

<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'first_name') ?>
<?= $form->field($model, 'last_name') ?>
<?= $form->field($model, 'phone');?>
<?= $form->field($model, 'doc0')->widget(FileInput::classname(),['hasDelate'=>true]);?>
<?= $form->field($model, 'doc1')->widget(FileInput::classname(),['hasDelate'=>true]);?>

<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']);?>



  <div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
      <?= Html::submitButton('Update', $submitOption) ?>
    </div>
  </div>

<?php ActiveForm::end(); ?>
