<?php


use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Support Areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-area-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Support Name',
                'attribute' => 'support_id',
                'value' => 'support.support_name'
            ],
            [
                'label' => 'Service Family',
                'attribute' => 'service_family_id',
                'value' => 'serviceFamily.service_name'
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