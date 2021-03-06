<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\growl\Growl;
use kartik\widgets\Select2;

use app\models\BaseModel;
use app\models\TransactionLabor;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransactionLaborSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Direct Labor';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php foreach (Yii::$app->session->getAllFlashes() as $msg):; ?>
    <?php
    Growl::widget([
        'type' => (!empty($msg['type'])) ? $msg['type'] : 'danger',
        'title' => (!empty($msg['title'])) ? Html::encode($msg['title']) : 'Title Not Set!',
        'icon' => (!empty($msg['icon'])) ? $msg['icon'] : 'fa fa-info',
        'body' => (!empty($msg['message'])) ? Html::encode($msg['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 3, //This delay is how long before the message shows
        'pluginOptions' => [
            'delay' => (!empty($msg['duration'])) ? $msg['duration'] : 1500, //This delay is how long the message shows for
            'placement' => [
                'from' => (!empty($msg['positionY'])) ? $msg['positionY'] : 'top',
                'align' => (!empty($msg['positionX'])) ? $msg['positionX'] : 'right',
            ]
        ],
        'useAnimation'=>true
    ]);
    ?>
<?php endforeach; ?>

<div class="transaction-direct-labor-index">
    <section class="content">
        <div class="row">
            <div class="col-md-4">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Direct Labor</h3>
                </div>
                <div class="box-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
              </div>
            </div>

            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Direct Labor Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <?php
                            $gridcolumns = [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'width' => '10px;',
                                    'vAlign' => 'left'
                                ],
                                [
                                    'label'=>'Mode of Payment',
                                    'attribute'=>'mode_of_payment_id',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('modeOfPayment')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'modeOfPayment.id', 'modeOfPayment.name'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select Mode of Payment'],
                                    'value'=>function($model){
                                        if ($model->modeOfPayment->name == '' || $model->modeOfPayment->name == NULL){
                                            return '-';
                                        } else {
                                            return $model->modeOfPayment->name;
                                        }
                                    },
                                    'width' => '150px;'
                                ],
                                [
                                    'label'=>'OR Number',
                                    'attribute'=>'or_number',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('users.userinfo')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'or_number', 'or_number'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select OR Number'],
                                    'value'=>function($model){
                                        if ($model->or_number == '' || $model->or_number == NULL){
                                            return '-';
                                        } else {
                                            return $model->or_number;
                                        }
                                    },
                                    'width' => '150px;',
                                    'pageSummary' => 'Total',
                                ],
                                [
                                    'label'=>'Amount',
                                    'attribute'=>'amount',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('users.userinfo')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'amount', 'amount'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select Amount'],
                                    'value'=>function($model){
                                        if ($model->amount == '' || $model->or_number == NULL){
                                            return '-';
                                        } else {
                                            return $model->amount;
                                        }
                                    },
                                    'width' => '150px;',
                                    'format' => ['decimal', 2],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label'=>'First Name',
                                    'attribute'=>'firstName',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('users.userinfo')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'users.userinfo.firstName', 'users.userinfo.firstName'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select First Name'],
                                    'value'=>function($model){
                                        if ($model->users->userinfo->firstName == '' || $model->users->userinfo->firstName == NULL){
                                            return '-';
                                        } else {
                                            return $model->users->userinfo->firstName;
                                        }
                                    },
                                    'width' => '150px;'
                                ],
                                [
                                    'label'=>'Middle Name',
                                    'attribute'=>'middleName',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('users.userinfo')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'users.userinfo.middleName', 'users.userinfo.middleName'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select Middle Name'],
                                    'value'=>function($model){
                                        if ($model->users->userinfo->middleName == '' || $model->users->userinfo->middleName == NULL){
                                            return '-';
                                        } else {
                                            return $model->users->userinfo->middleName;
                                        }
                                    },
                                    'width' => '150px;'
                                ],
                                [
                                    'label'=>'Last Name',
                                    'attribute'=>'lastName',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('users.userinfo')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'users.userinfo.lastName', 'users.userinfo.lastName'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select Last Name'],
                                    'value'=>function($model){
                                        if ($model->users->userinfo->lastName == '' || $model->users->userinfo->lastName == NULL){
                                            return '-';
                                        } else {
                                            return $model->users->userinfo->lastName;
                                        }
                                    },
                                    'width' => '150px;'
                                ],
                                [
                                    'label'=>'Extension Name',
                                    'attribute'=>'ext_name',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('users.userinfo')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'users.userinfo.ext_name', 'users.userinfo.ext_name'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select Extension Name'],
                                    'value'=>function($model){
                                        if ($model->users->userinfo->ext_name == '' || $model->users->userinfo->ext_name == NULL){
                                            return '-';
                                        } else {
                                            return $model->users->userinfo->ext_name;
                                        }
                                    },
                                    'width' => '150px;'
                                ],
                                [
                                    'label'=>'Position Name',
                                    'attribute'=>'position',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('users.position')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'users.position.id', 'users.position.name'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select Position'],
                                    'value'=>'users.position.name',
                                    'width' => '150px;'
                                ],
                                [
                                    'label'=>'Position Description',
                                    'value'=>'users.position.description',
                                    'width' => '150px;'
                                ],
                                [
                                    'label'=>'Salary Type',
                                    'attribute'=>'salary',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('users.salary')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'users.salary.id', 'users.salary.description'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select Salary'],
                                    'value'=>'users.salary.description',
                                    'width' => '150px;',
                                ],
                                [
                                    'label'=>'Salary Amount',
                                    'value'=>'users.salary.amount',
                                    'width' => '150px;',
                                    'format' => ['decimal', 2],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label'=>'Date Encoded',
                                    'attribute'=>'date_encoded',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('users.userinfo')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'date_encoded', 'date_encoded'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select Date Encoded'],
                                    'value'=>function($model){
                                        if ($model->date_encoded == '' || $model->date_encoded == NULL){
                                            return '-';
                                        } else {
                                            return $model->date_encoded;
                                        }
                                    },
                                    'width' => '150px;',
                                    'pageSummary' => 'Total',
                                ],
                                [
                                    'label'=>'Remarks',
                                    'attribute'=>'remarks',
                                    'filterType'=>GridView::FILTER_SELECT2,
                                    'filter'=>ArrayHelper::map(TransactionLabor::find()->joinWith('users.userinfo')->where(['transaction_labor.mode'=>'DIRECT LABOR'])->asArray()->all(), 'remarks', 'remarks'), 
                                    'filterWidgetOptions'=>[
                                        'pluginOptions'=>[
                                            'allowClear'=>true,
                                        ],
                                        'theme' => Select2::THEME_DEFAULT,
                                    ],
                                    'filterInputOptions'=>['placeholder'=>'Select Remarks'],
                                    'value'=>function($model){
                                        if ($model->remarks == '' || $model->remarks == NULL){
                                            return '-';
                                        } else {
                                            return $model->remarks;
                                        }
                                    },
                                    'width' => '150px;',
                                    'pageSummary' => 'Total',
                                ],
                                [
                                  'class' => 'kartik\grid\ActionColumn',
                                  'template' => '{update}{delete}',
                                  'hAlign'=>'center',
                                  'vAlign'=>'middle',
                                  'buttons' => [
                                      //view button
                                      'view' => function ($url, $model) {
                                          $t = 'view?id='.$model->id;
                                          return ' ' . Html::button('<span class="fa fa-eye"></span>', ['value'=>Url::to($t), 'class' =>'btn btn-flat btn-info btn-xs modalButtonview', 'data-placement'=>'top', 'data-toggle'=>'tooltip', 'title'=>'View']);
                                      },
                                      //update button
                                      'update' => function ($url, $model) {
                                          if(Yii::$app->user->can('_EDIT-DIRECT-LABOR')){
                                              $t = 'update?id='.$model->id;
                                              return ' ' . Html::button('<span class="fa fa-pencil-square-o"></span>', ['value'=>Url::to($t), 'class' =>'btn btn-flat btn-primary btn-xs modalButtonedit', 'data-placement'=>'top', 'data-toggle'=>'tooltip', 'title'=>'Edit'])
                                              ;
                                          }
                                      },
                                      //delete button
                                      'delete' => function ($url, $model) {
                                          if(Yii::$app->user->can('_DELETE-DIRECT-LABOR')){
                                              return ' ' . Html::a('<span class="fa fa-trash-o"></span>', ['delete', 'id'=>$model->id], [
                                                  'class' => 'btn btn-flat btn-danger btn-xs',
                                                  'data' => [
                                                      'confirm' => "Are you sure to delete this item?",
                                                      'method' => 'post',
                                                  ], 
                                                  'data-placement'=>'top', 'data-toggle'=>'tooltip', 'title'=>'Delete'
                                              ])
                                              ;
                                          }
                                      },
                                  ],
                                  'width' => '50px;'
                              ],
                            ];

                            if(Yii::$app->user->can('_DELETE-MULTIPLE-DIRECT-LABOR')){
                              $gridcolumns[] = [
                                'class' => 'kartik\grid\CheckboxColumn',
                                'width' => '50px;',
                              ]; 
                            }

                            $headercols = [
                                ['content' => 'Direct Labor Information', 'options' => ['colspan' => 100, 'class' => 'text-center bg-primary']],
                            ];

                            $heading = 'List of Direct Labor Information';

                            $export = ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => $gridcolumns,
                                'target' => ExportMenu::TARGET_BLANK,
                                'fontAwesome' => true,
                                'pjaxContainerId' => 'transactiondirectlabor',
                                'enableFormatter' => true,
                                'showColumnSelector' => true,
                                'dropdownOptions' => [
                                    'label' => 'Export All',
                                    'class' => 'btn btn-default btn-flat',
                                    'itemsBefore' => [
                                        '<li class="dropdown-header">Export All Data</li>',
                                    ],
                                ],
                                'filename' => 'Transaction Direct Labor',
                            ]);

                            if(Yii::$app->user->can('_DELETE-MULTIPLE-DIRECT-LABOR')){
                              $after = '<div class="pull-right">
                              <button type="button" class="btn btn-flat btn-danger deleteSelecteddirectlaborbutton" data-placement="left" data-toggle="tooltip", title="Delete Selected">Delete Selected</button>
                              </div><div style="padding-top: 5px;">
                              <em>&nbsp;</em>
                              </div>
                              <div class="clearfix"></div>';
                            } else {
                              $after = '';
                            }

                            if(Yii::$app->user->can('_VIEW-LOGS')){
                              $logs = Html::button('<i class=""></i> Logs', ['class' =>'btn btn-flat btn-default modalButtonlogs', 'data-placement'=>'bottom', 'data-toggle'=>'tooltip', 'title'=>'Show Logs']);

                            } else {
                              $logs = '';
                            }
                        ?>
                        <?=
                          GridView::widget([
                              'dataProvider' => $dataProvider,
                              'filterModel' => $searchModel,
                              'columns' => $gridcolumns,

                              'floatHeader'=>true,
                              'floatHeaderOptions'=>[
                                  'top'=>'0',
                                  'position'=>'absolute',
                              ],
                              'resizableColumns'=>true,
                              'beforeHeader' => [
                                  [
                                      'columns' => $headercols,
                                  ]
                              ],
                              'rowOptions' => function($model) {
                                    if($model->users->status == 0 || ($model->amount > $model->users->salary->amount) ){
                                        return ['class' => 'warning', 'style'=>'font-weight:bold;'];
                                    }else{
                                        return ['class'=>'success'];
                                    }
                               },
                              'options' => ['id' => 'transactiondirectlabor'],
                              'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                              'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                              'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                              'pjax' => true, // pjax is set to always true for this demo
                              'pjaxSettings' =>[
                                  'neverTimeout'=>true,
                                  'options'=>[
                                          'id'=>'kv-unique-id-1',
                                      ]
                                  ],
                              // set your toolbar
                              'toolbar' => [
                                  ['content' =>
                                      Html::a('<i class="fa fa-repeat"></i>', ['index'], ['data-pjax' => 1, 'class' => 'btn btn-flat btn-default', 'title' => 'Reset Grid']) . $export . '{toggleData}' . $logs,
                                  ],
                                  //'{export}',
                                  //'{toggleData}',
                              ],
                              // set export properties
                              'export' => [
                                  'fontAwesome' => true
                              ],
                              // parameters from the demo form
                              'bordered' => true,
                              'striped' => true,
                              'condensed' => true,
                              'responsive' => true,
                              'hover' => true,
                              'showPageSummary' => true,
                              'panel' => [
                                  'type' => GridView::TYPE_PRIMARY,
                                  'heading' => $heading,
                                  'after'=>$after,
                              ],
                              'persistResize' => false,
                              'exportConfig' => true,
                          ]);
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
    Modal::begin(
            [
                //'header' => '<h2>Create New Region</h2>',
                'id' => 'modalcreate',
                'size' => 'modal-md',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => TRUE , 'class'=>'modal modal-primary'],
                'options' => [
                    'tabindex' => false // important for Select2 to work properly
                ],
            ]
    );
        echo "<div class='box box-success' id='modalContent'></div>";
        Modal::end();
?>


<?php
    Modal::begin(
            [
                //'header' => '<h2>Edit Region</h2>',
                'id' => 'modaledit',
                'size' => 'modal-md',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => TRUE],
                'options' => [
                    'tabindex' => false // important for Select2 to work properly
                ],
            ]
    );
    echo "<div class='box box-primary' id='modalContent'></div>";
    Modal::end();
?>

<?php
    Modal::begin(
            [
                //'header' => '<h2>Region</h2>',
                'id' => 'modalview',
                'size' => 'modal-md',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => TRUE],
                'options' => [
                    'tabindex' => false // important for Select2 to work properly
                ],
            ]
    );
    echo "<div class='box box-info' id='modalContent'></div>";
    Modal::end();
?>

<?php
    Modal::begin([
        //'header' => '<h2>Events</h2>',
        'id' => 'modal',
        'size'=>'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE, 'class'=>'modal modal-primary'],
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ],
    ]);

    echo "<div class='box box-primary' id='modalContent'></div>";
    Modal::end();
?>

<?php
$js = "
$(document).on('click','.modalButtonlogs', function(){        
    $.get('logs',{},function(data){

        var clear_datatable = $('#table_datails').DataTable();
        clear_datatable.clear();
        $('#modal').modal('show').find('#modalContent').html(data);
        
        $('#table_datails').DataTable({
             'processing': true,
             'dom': 'lBfrtip',
             'order': [[ 0, 'desc' ]],
             'columnDefs': [
                {
                    'targets': [ 0 ],
                    'visible': true,
                    'searchable': false
                },
             ],
             'buttons': [
                {
                    extend: 'collection',
                    text: 'Export to...',
                    buttons: [
                        'copy',
                        'excel',
                        'csv',
                        'pdf',
                        'print'
                    ]
                }
            ]
        });
    });
});

$('body').on('click', '.deleteSelecteddirectlaborbutton', function(){
    var deleteSelected = $('#transactiondirectlabor').yiiGridView('getSelectedRows');
    if (deleteSelected == ''){
        swal('Error', 'No selected record!', 'error');
    }
    else {
        swal({
          title: 'Are you sure?',
          text: 'The selected direct labor will be deleted.',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes, I agree!',
          closeOnConfirm: false
        },
        function(){
            $.ajax({
                type: 'POST',
                url : 'deletemultiple',
                data : {row_id: deleteSelected},
                success : function() {
                    $.pjax.reload({container:'#kv-unique-id-1'});
                    swal('Success!', 'Direct Labor Successfully Deleted.', 'success');
                },
                error: function () {
                    swal('Error', 'Direct Labor Not Deleted.', 'error');
                }
            });
        });
    }
});

";
$this->registerJs($js, $this::POS_END);
?>
