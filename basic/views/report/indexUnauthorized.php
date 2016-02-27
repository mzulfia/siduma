<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;

use app\models\ServiceFamily;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
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
                'filter' => Html::activeDropDownList($searchModel, 'status', ['1' => 'Baik', '0' => 'Tidak'],['class'=>'form-control','prompt' => '-']),
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
        ]
    ]); ?>

</div>
