<?php


use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

use app\models\ServiceFamily;

$this->title = 'Support Areas | All';
$this->params['breadcrumbs'][] = 'Support Areas';
?>
<div class="support-area-index">

    <h1>Support Areas</h1>

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
                'filter' => Html::activeDropDownList($searchModel, 'service_family_id', ArrayHelper::map(ServiceFamily::find()->all(), 'service_family_id', 'service_name'),['class'=>'form-control','prompt' => '-']),
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