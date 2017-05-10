<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\additional_services\models\AdditionalServicesList */

$this->title = 'Update Additional Services: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Additional Services Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="additional-services-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>