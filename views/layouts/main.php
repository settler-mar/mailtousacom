<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <base href="/"/>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?= skinka\widgets\gritter\AlertGritterWidget::widget() ?>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/img/mailtousa.png" alt="logo">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            //['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ?(
              '<li>'
              . Html::a('<i class="icon-metro-enter"></i> Sign In', ['/'])
              . '</li>'
              . '<li>'
              . Html::a('<i class="icon-metro-clipboard-2"></i> Registration', ['/registration'])
              . '</li>'
            ):(
                ((Yii::$app->params['showAdminPanel']==1)?
                  (
                    '<li>'.Html::a('Update my profile', ['/profile/'], ['class' => 'profile-link']) .'</li>'
                    .'<li>'.Html::a('Roles', ['/rbac/role/'], ['class' => 'btn btn-science-blue']) .'</li>'
                    .'<li>'.Html::a('Rules', ['/rbac/rule/'], ['class' => 'btn btn-science-blue']) .'</li>'
                    .'<li>'.Html::a('Permissions', ['/rbac/permission/'], ['class' => 'btn btn-science-blue']) .'</li>'
                    .'<li>'.Html::a('Assignments', ['/rbac/assignment/'], ['class' => 'btn btn-science-blue']) .'</li>'
                  ):
                  (
                    '<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="icon-metro-user-2"></i>&nbsp;&nbsp;Profile <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>'
                    . Html::a('Update my profile', ['/profile/'], ['class' => 'profile-link'])
                    .'</li>'
                    .'<li>'
                    .Html::a('Update my billing address', ['/address/create-order-billing'], ['class' => 'profile-link'])
                    .'</li>'
                    .'<li>'
                    .Html::a('View return address', ['/address/addressusa'], ['class' => 'profile-link'])
                    //.'</li>'
                    //.'<li>'
                    //. Html::a('Upgrade my account', ['/upgrade/'], ['class' => 'profile-link'])
                    //.'</li>'
                    .'</ul>'
                    .'</li>'
                    .'<li>'
                    .Html::a('<i class="fa fa-briefcase"></i>&nbsp;&nbsp;Му Orders', ['/'], ['class' => 'profile-link'])
                    .'</li>'
                  ))
                //. '<li>'
                //. Html::a('<i class="fa fa-map-marker"></i> My addresses', ['/address/'], ['class' => 'profile-link'])
                //. '</li>'
                .'<li>'
                . Html::a('<i class="fa fa-credit-card"></i>&nbsp;&nbsp;Payments', ['/payment/'], ['class' => 'profile-link'])
                . '</li>'
                //.'<li class="dropdown">
                //    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i> Configuration <span class="caret"></span></a>
                //   <ul class="dropdown-menu">
                //        <li>'
                //            . Html::a('Tariffs', ['/tariff/'], ['class' => 'profile-link'])
                //        .'</li>
                //        <li>'
                //            . Html::a('Taxes', ['/state/'], ['class' => 'profile-link'])
                //        .'</li>'
                //    .'</ul>'
                //.'</li>'.

                                  .'<li>'
                                  . Html::beginForm(['/logout'], 'post')
                                  . Html::submitButton(
                                    'Logout [' . Yii::$app->user->identity->username . '] <i class="icon-metro-exit"></i>',
                                    ['class' => 'btn btn-link logout']
                                  )
                )
                . Html::endForm()
                . '</li>'

        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"></p>
        <p class="pull-right">&copy; MailToUSA <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
