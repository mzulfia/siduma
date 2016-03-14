<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

use kartik\daterange\DateRangePicker;
use app\models\Shift;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceFamilySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Schedules | All';
$this->params['breadcrumbs'][] = 'Schedules';
?>
<div class="service-family-index">

    <h1>Schedules</h1>
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
                'template'=>'{update}{delete}',
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

</div>
