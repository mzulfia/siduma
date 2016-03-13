<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupportPositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Positions | All';
$this->params['breadcrumbs'][] = 'Support Positions';
?>
<div class="support-position-index">

    <h1>Support Positions</h1>
    
    <p>
        <?= Html::a('Create Support Position', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'position_name',
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
