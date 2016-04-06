<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;

use app\models\SupportPosition;
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
            'email',
            'no_hp',
            [
                'label' => 'Position',
                'filter' => Html::activeDropDownList($searchModel, 'support_position_id', ArrayHelper::map(SupportPosition::find()->all(), 'support_position_id', 'position_name'),['class'=>'form-control','prompt' => '-']),
                'attribute' => 'support_position_id',
                'value' => 'pos.position_name'
            ],
            'company',
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
