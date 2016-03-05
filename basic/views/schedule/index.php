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

    <p>
        <?= Html::a('Create Schedule', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'contentOptions' => ['style' => 'width:100px;']
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
