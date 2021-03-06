<?php use yii\helpers\Html;
use app\modules\user\models\User;
use yii\captcha\Captcha;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$submitOption = [
    'class' => 'btn btn-science-blue btn_all',
    'name' => 'signup-button'
];
?>
<?= skinka\widgets\gritter\AlertGritterWidget::widget() ?>
<div class="user-form">
    <h4 class="modernui-neutral2">Registration <i class="icon-metro-clipboard-2"></i></h4>
     <?php $form = ActiveForm::begin(); ?>
     <?=  $form->field($model, 'email')->textInput(['placeholder' => 'Email']);?>
     <?=  $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']);?>
     <?=  Html::checkbox('I_accept',false,['label'=>'<span class="fa fa-check otst form-group"></span> Agreement have read and agree.'])?>
    <?=  Html::a('Confidentiality', ['/confidentiality'], ['id'=>'confidentiality','class'=>'confid']); ?>
     <?php if (Yii::$app->user->isGuest) {?>
         <?= Html::submitButton('SIGN UP', $submitOption ); ?>
     <?php } else {?>
         <?= Html::submitButton('CREATE', $submitOption ); }?>
     <?php ActiveForm::end();  ?>
</div>


