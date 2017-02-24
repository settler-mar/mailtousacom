<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\state\models\State */

$this->title = 'Edit Tax: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Taxes configuration', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name]; /* при задании 'url' попадаем в никуда*/
$this->params['breadcrumbs'][] = 'Edit: #'. $model->name;
?>
<div class="state-update">

    <h4 class="modernui-neutral2"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
