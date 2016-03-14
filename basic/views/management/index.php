<?php


use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Managements | All';
$this->params['breadcrumbs'][] = 'Managements';
?>
<div class="management-index">

    <h1>Managements</h1>

    <p>
        <?= Html::a('Create Management', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            'mgt_name',
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