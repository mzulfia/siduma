<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\daterange\DateRangePicker;

use app\models\ServiceFamily;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'DM Reports | All';
$this->params['breadcrumbs'][] = 'Duty Manager Reports';
?>
<div class="report-index">

    <h1>Duty Manager Reports</h1>

    <?php
        $gridColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'attribute' => 'created_at',
                'value' => 'created_at', 
                'filter' => DateRangePicker::widget([
                    'name' => 'created_at_1',
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'locale'=>['format' => 'Y-m-d'],
                    ],
                    'presetDropdown'=>true,
                ]),
                'contentOptions' => ['style' => 'width:200px;']
            ],
            [
                'label' => 'Service Family',
                'attribute'=> 'service_family_id',
                'filter' => Html::activeDropDownList($searchModel, 'service_family_id', ArrayHelper::map(ServiceFamily::find()->all(), 'service_family_id', 'service_name'),['class'=>'form-control','prompt' => '-']),
                'value' => 'service.service_name',
                'contentOptions' => ['style' => 'width:175px;']
            ],
            [
                'label' => 'Status',
                'attribute'=> 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', ['2' => 'Normal', '1' => 'Warning', '0' => 'Critical'],['class'=>'form-control','prompt' => '-']),
                'value' => function ($model) {
                    return $model->status == 2 ? 'Normal' : ($model->status == 1 ? 'Warning' : 'Critical');
                },
                'contentOptions' => ['style' => 'width:125px;']
            ],
            [
                'label' => 'File',
                'format' => 'raw',
                'attribute' => 'file_path',
                'value' => function($model){
                    return $model->file_path == NULL ? NULL : Html::a(Html::encode(explode("/", $model->file_path)[3]), 
                        Url::toRoute(['dm-report/download', 'file_path' => $model->file_path]), 
                        [   
                           'data-method' => 'post',
                        ]);
                },
                'contentOptions' => ['style' => 'width:200px;']
            ],
            'information:ntext',
            [
                'attribute' => 'support_id',
                'value' => 'support.support_name',
                'contentOptions' => ['style' => 'width:200px;']
            ],
        ];


         echo '<ul style = "text-align: right; list-style-type: none; margin: 0; padding: 0;">' . ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'target' => ExportMenu::TARGET_SELF,
            'fontAwesome' => true,
            'asDropdown' => false,
            'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_CSV => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_PDF => false,
            ],
            'filename' => 'Duty Manager Report_' . date('Y-m-d'),
        ]) . '</ul>';

    ?>



    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function($model){
                        if($model->status == 2){
                            return ['class' => 'success'];
                        } elseif($model->status == 1){
                            return ['class' => 'warning'];
                        } else {
                            return ['class' => 'danger'];
                        }
                    },
            'columns' => $gridColumns,
            'pager' => [
                    'firstPageLabel' => 'First',
                    'lastPageLabel' => 'Last',
            ],
            'responsive'=>true,
            'hover'=>true,
            'condensed'=>true,
            'bordered'=>true,
    ]); ?>

    <div class="row">
        <div class="col-md-12" style = 'text-align: center;'> 
            <?= Html::a('Export Report', ['/dm-report/exportreport'], ['class'=>'btn btn-primary']) ?>
        </div>    
    </div>    

</div>
