<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
 use kartik\form\ActiveForm;

use kartik\daterange\DateRangePicker;
use app\models\Shift;

 use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceFamilySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Schedules | All';
$this->params['breadcrumbs'][] = 'Schedules';


$this->registerJs(
   '$("#multipleDelete").click(function(){ 
        var checked=$("#grid").yiiGridView("getSelectedRows");
        var count=checked.length;
        if(count>0 && confirm("Do you want to delete these "+count+" item(s)"))
        {
            $.ajax({
                    type: "POST",
                    cache:false,
                    data:{checked:checked},
                    url:"remove",
                    success:function(data){$.pjax.reload({container:"#schedule-grid"});},         
            });
        }
    });'
);

// $this->registerJs(
//    '$("document").ready(function(){ 
//         $("#delete-form").on("pjax:end", function() {
//             $.pjax.reload({container:"#schedule-grid"}); 
//         });
//     });'
// );
?>
<div class="schedule-index">

    <h1>Schedules</h1>
    <p>
        <?= Html::a('Create Schedule', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="col-md-12" style = 'text-align: center;'> 

        <?php Pjax::begin(['id' => 'delete-form'])?>
            <?php 
                $form = ActiveForm::begin(
                [
                    'id' => 'deletebydate-form',
                    'type' => ActiveForm::TYPE_INLINE,
                ],
                ['options' => ['data-pjax' => true ]
                ]
                );

            ?>
            
            <?= 
                $form->field($model, 'date', [
                    'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
                    'options'=>['class'=>'drp-container form-group'] 
                ])->widget(DateRangePicker::classname(), [
                    'name' => 'date_1',
                    'value' => 'date',
                    'convertFormat'=>true,
                    
                    'pluginOptions'=>[
                        'locale'=>['format' => 'Y-m-d'],
                    ],
                    'presetDropdown'=>true,
                ]);
            ?>

            <?= Html::submitButton('Delete', ['name' => 'delete-button', 'class' => 'btn btn-primary']) ?>        
            
            <?php ActiveForm::end(); ?>
        <?php Pjax::end() ?>
        <br>
    </div>

    <?php $initial_date = date('Y-m-d'). ' - ' . date('Y-m-d'); ?>

    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
            <?php Pjax::begin(['id' => 'schedule-grid'])?>

                <?= GridView::widget([
                    'id' => 'grid',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {
                                return ['value' => $data->schedule_id];
                            },
                            'contentOptions' => ['style' => 'width:10px;']
                        ],
                        [
                            'label' => 'Date',
                            'attribute' => 'date',
                            'value' => 'date', 
                            'filter' => DateRangePicker::widget([
                                'name' => 'date_1',
                                'model' => $searchModel,
                                'attribute' => 'date',
                                'convertFormat'=>true,
                                'pluginOptions'=>[
                                    'locale'=>['format' => 'Y-m-d'],
                                ],
                                'presetDropdown'=>true,
                            ]),   
                            'contentOptions' => ['style' => 'width:200px;']
                        ],
                        [
                            'label' => 'Support Name',
                            'attribute' => 'support_id',
                            'value' => 'support.support_name',
                            
                        ],
                        [
                            'label' => 'Shift Name',
                            'filter' => Html::activeDropDownList($searchModel, 'shift_id', ArrayHelper::map(Shift::find()->all(), 'shift_id', 'shift_name'),['class'=>'form-control','prompt' => '-']),
                            'attribute' => 'shift_id',
                            'value' => 'shift.shift_name',
                            'contentOptions' => ['style' => 'width:100px;']
                        ],
                       [
                            'label' => 'Is Dm',
                            'attribute' => 'is_dm',
                            'filter' => Html::activeDropDownList($searchModel, 'is_dm', ['1' => 'Ya', '0' => 'Tidak'],['class'=>'form-control','prompt' => '-']),
                            'value' => function ($model) {
                                return $model->is_dm == 1 ? 'Ya' : 'Tidak';
                            },
                             'contentOptions' => ['style' => 'width:100px;']
                        ],
                        [
                            'header' => 'Action',
                            'class' => 'yii\grid\ActionColumn',
                            'template'=>'{update}',
                            'contentOptions' => ['style' => 'width:50px;']
                        ],
                    ],
                    'pager' => [
                        'firstPageLabel' => 'First',
                        'lastPageLabel' => 'Last',
                    ],
                    'responsive'=>true,
                    'hover'=>true,
                    'condensed'=>true,
                    'bordered'=>true,
                ]); ?>  

            <?php Pjax::end()?>  
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style = 'text-align: center;'> 
                <p>
                    <button class="btn btn-primary" id="multipleDelete">Delete Selected Items</button>
                </p>
            </div>    
        </div>    
    </div>   
</div>
