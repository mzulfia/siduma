<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\export\ExportMenu;
// use kartik\date\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\data\ArrayDataProvider;


use app\models\ServiceFamily;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Report', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
        $gridColumns = [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'attribute' => 'created_at',
                'value' => 'created_at', 
                'filter' => DateRangePicker::widget([
                        'model'=>$searchModel,
                        'attribute'=>'created_at',
                        'convertFormat'=>true,
                        'pluginOptions'=>[
                            'locale'=>[
                                'format'=>'Y-m-d'
                            ]
                        ]
                    ]),
                'contentOptions' => ['style' => 'width:150px;']
            ],
            [
                'label' => 'Service Family',
                'attribute'=> 'service_family_id',
                'filter' => Html::activeDropDownList($searchModel, 'service_family_id', ArrayHelper::map(ServiceFamily::find()->all(), 'service_family_id', 'service_name'),['class'=>'form-control','prompt' => '-']),
                'value' => 'service.service_name',
                'contentOptions' => ['style' => 'width:200px;']
            ],
            [
                'label' => 'Status',
                'attribute'=> 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', ['1' => 'OK', '0' => 'Tidak'],['class'=>'form-control','prompt' => '-']),
                'value' => function ($model) {
                    return $model->status == 1 ? 'Ok' : 'Tidak';
                },
                'contentOptions' => ['style' => 'width:75px;']
            ],
            [
                'label' => 'File',
                'format' => 'raw',
                'attribute' => 'file_path',
                'value' => function($model){
                    return $model->file_path == NULL ? NULL : Html::a(Html::encode(explode("/", $model->file_path)[2]), 
                        Url::toRoute(['report/download', 'file_path' => $model->file_path]), 
                        [
                           // 'title'=>'Clave',
                           // 'data-confirm' => Yii::t('yii', 'Are you sure you want to change this password?'),
                           'data-method' => 'post',
                        ]);
                },
                'contentOptions' => ['style' => 'width:150px;']
            ],
            'information:ntext',
            [
                'label' => 'Support',
                'attribute' => 'support_id',
                'value' => 'support.support_name',
                'contentOptions' => ['style' => 'width:150px;']
            ],
            ['class' => 'yii\grid\ActionColumn'],
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
                // GridView::PDF => [
                //    'config' => [
                //        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                //    ],
                // ],
            ],
            'filename' => 'exported-data_' . date('Y-m-d'),
        ]) . '</ul>';
    ?>


    <?= 
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function($model){
                    if($model->status == 1){
                        return ['class' => 'success'];
                    } else {
                        return ['class' => 'danger'];
                    }
                },
            'columns' => $gridColumns,
            'responsive'=>true,
            'hover'=>true,
            'condensed'=>true,
            'floatHeader'=>true,
            'bordered'=>true,
        ]); 

    ?>
   
 
</div>
