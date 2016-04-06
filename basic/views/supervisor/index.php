<?php


use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Supervisors | All';
$this->params['breadcrumbs'][] = 'Supervisors';
?>
<div class="supervisor-index">

    <h1>Supervisors</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Username',
                'attribute' => 'supervisor_username',
                'value' => 'user.username'
            ],
            'spv_name',
            'position',
            'no_hp',
            'email',
             [
                'header' => 'Action',
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 100px']
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