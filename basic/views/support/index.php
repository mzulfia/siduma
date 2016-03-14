<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supports | All';
$this->params['breadcrumbs'][] = 'Supports';
?>
<div class="support-index">

    <h1>Supports</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Username',
                'attribute' => 'support_username',
                'value' => 'user.username'
            ],
            'support_name',
            'company',
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
