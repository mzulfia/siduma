<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;

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
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Service Family',
                'attribute'=> 'service_family_id',
                'filter' => Html::activeDropDownList($searchModel, 'service_family_id', ArrayHelper::map(ServiceFamily::find()->all(), 'service_family_id', 'service_name'),['class'=>'form-control','prompt' => '-']),
                'value' => 'service.service_name'
            ],
            [
                'label' => 'Status',
                'attribute'=> 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', ['1' => 'OK', '0' => 'Tidak'],['class'=>'form-control','prompt' => '-']),
                'value' => function ($model) {
                    return $model->status == 1 ? 'Ok' : 'Tidak';
                }
            ],
            'information:ntext',
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
            ],
            [
                'label' => 'Support',
                'attribute' => 'support_id',
                'value' => 'support.support_name'
            ],
        ],
    ]); ?>

</div>
