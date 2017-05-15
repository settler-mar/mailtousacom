<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\config\models\SearchConfig */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'System configuration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-index">

    <h4 class="modernui-neutral2"><?= Html::encode($this->title) ?></h4>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">
        <?= GridView::widget([
          'dataProvider' => $dataProvider,
          //'filterModel' => $searchModel,
          'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
              //'type',
              //'pay_status',
            /*[
              'attribute' => 'pay_status',
              'content' => function($data){
                  return date(Yii::$app->config->get('data_time_format_php'),$data->updated);
              }
            ],*/
              [
                'attribute' => 'create',
                'content' => function($data){
                    return date(Yii::$app->config->get('data_time_format_php'),$data->create);
                }
              ],

            [
              'attribute' => 'Action',
              'content' => function($data){
                  return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span> Update',
                    ['/invoice/edit/' . $data->id],
                    ['class' => 'btn btn-sm btn-science-blue marg_but']
                  );
              }
            ]
          ],
        ]); ?>
    </div>
</div>
