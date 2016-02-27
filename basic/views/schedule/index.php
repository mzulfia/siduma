<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceFamilySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-family-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Schedule', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}",
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'label' => 'Date',
                'attribute' => 'date',
                'value' => 'date', 
                'filter' => DateRangePicker::widget([
                        'model'=>$searchModel,
                        'attribute'=>'date',
                        'convertFormat'=>true,
                        'pluginOptions'=>[
                            'locale'=>[
                                'format'=>'Y-m-d'
                            ]
                        ]
                    ]),
                'contentOptions' => ['style' => 'width:150px;']
            ],
            // [
            //     'label' => 'File',
            //     'format' => 'raw',
            //     'attribute' => 'file_path',
            //     'value' => function($model){
            //         return $model->file_path == NULL ? NULL : Html::a(Html::encode(explode("/", $model->file_path)[2]), 
            //             Url::toRoute(['report/download', 'file_path' => $model->file_path]), 
            //             [
            //                // 'title'=>'Clave',
            //                // 'data-confirm' => Yii::t('yii', 'Are you sure you want to change this password?'),
            //                'data-method' => 'post',
            //             ]);
            //     },
            //     'contentOptions' => ['style' => 'width:200px;']
            // ],
            [
                'label' => 'Support Name',
                'attribute' => 'support_id',
                'value' => 'support.support_name',
                
            ],
            [
                'label' => 'Shift Name',
                'attribute' => 'shift_id',
                'value' => 'shift.shift_name',
                'contentOptions' => ['style' => 'width:100px;']
            ],
            [
                'label' => 'Shift Start',
                'attribute' => 'shift_id',
                'value' => 'shift.shift_start',
                'contentOptions' => ['style' => 'width:100px;']
            ],
            [
                'label' => 'Shift End',
                'attribute' => 'shift_id',
                'value' => 'shift.shift_end',
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
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Actions',
            ],
        ],
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'bordered'=>true,
    ]); ?>

</div>
