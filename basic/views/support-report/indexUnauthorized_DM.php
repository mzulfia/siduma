<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\daterange\DateRangePicker;

use app\models\ServiceFamily;
use app\models\Schedule;
use app\models\Shift;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Reports | All';
$this->params['breadcrumbs'][] = 'Support Reports';
?>
<div class="report-index">

    <h1>Support Reports</h1>

    <?php
        date_default_timezone_set("Asia/Jakarta");
        if(Schedule::getIsSupportNow(date('Y-m-d'), Shift::getShift(date("H:i:s"))->shift_id, User::getSupportId(Yii::$app->user->getId()))) {
            echo "<p>". Html::a('Create Report', ['create'], ['class' => 'btn btn-success']) . "</p>";
        }
    ?>

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
                'contentOptions' => ['style' => 'width:200px;']
            ],
            [
                'label' => 'File',
                'format' => 'raw',
                'attribute' => 'file_path',
                'value' => function($model){
                    return $model->file_path == NULL ? NULL : Html::a(Html::encode(explode("/", $model->file_path)[3]), 
                        Url::toRoute(['support-report/download', 'file_path' => $model->file_path]), 
                        [   
                           'data-method' => 'post',
                        ]);
                },
                'contentOptions' => ['style' => 'width:150px;']
            ],
            'information:ntext',
            [
                'attribute' => 'support_id',
                'value' => 'support.support_name',
                'contentOptions' => ['style' => 'width:200px;']
            ],
            [
                'header' => 'Action',
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}',
                'buttons'=> [
                    'update' => function ($url, $model){
                        return $model->support_id == User::getSupportId(\Yii::$app->user->getId()) ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, 
                            [ 'title' => Yii::t('app', 'Update') ]) : '';
                    }
                ],
                'contentOptions' => ['style' => 'width:50px;']
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
                // GridView::PDF => [
                //    'config' => [
                //        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                //    ],
                // ],
            ],
            'filename' => 'Support Report_' . date('Y-m-d'),
        ]) . '</ul>';
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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

</div>
