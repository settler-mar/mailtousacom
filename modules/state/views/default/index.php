<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\state\models\StateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Taxes configuration';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
?>
<div class="state-index">

    <h4 class="modernui-neutral2"><?= Html::encode($this->title) ?></h4>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-md-12">
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Add Tax', ['create'], ['class' => 'btn btn-info pull-right push-up-margin-tiny']) ?>
        </div>
    </div>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'tableOptions' => [
            'class' => 'table table-bordered',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'qst',
            'gst',

            [
              'class' => 'yii\grid\ActionColumn',
              'header' => 'Actions',
              'template' =>'<div class="but_tab_style"> {update}{delete}</div>',

                'buttons' => ['update' => function ($url)
                { return Html::a( '<button class="btn btn-info btn-sm but_tab_marg"><span class="glyphicon glyphicon-pencil"></span> Edit</button>',
                    $url, [
                            'title' => 'Edit',
                            'data-pjax' => '0',
                    ] ); },
                    'delete' => function ($url)
                    { return Html::a( '<button class="btn btn-danger btn-sm but_tab_marg"><span class="glyphicon glyphicon-trash"></span> Delete</button>',
                        $url, [
                            'data' => [
                              'confirm-message' => 'Are you sure to delete this item?',
                              'confirm-title'=>"Delete line",
                              'pjax'=>'false',
                              'toggle'=>"tooltip",
                              'request-method'=>"post",
                            ],
                            'role'=>"modal-remote",
                        ] ); },


                ],
            ],
        ],

    ]); ?>
    </div>
    <?php Pjax::end(); ?>

</div>

<?php Modal::begin([
  "id"=>"ajaxCrudModal",
  "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>