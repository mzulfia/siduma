<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceFamilySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-family-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Schedule', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            [
                'label' => 'Support Name',
                'attribute' => 'support_id',
                'value' => 'support.support_name'
            ],
            [
                'label' => 'Shift Name',
                'attribute' => 'shift_id',
                'value' => 'shift.shift_name'
            ],
            [
                'label' => 'Shift Start',
                'attribute' => 'shift_id',
                'value' => 'shift.shift_start'
            ],
            [
                'label' => 'Shift End',
                'attribute' => 'shift_id',
                'value' => 'shift.shift_end'
            ],
            [
                'label' => 'Is Dm',
                'attribute' => 'is_dm',
                'filter' => Html::activeDropDownList($searchModel, 'is_dm', ['1' => 'Ya', '0' => 'Tidak'],['class'=>'form-control','prompt' => '-']),
                'value' => function ($model) {
                    return $model->is_dm == 1 ? 'Ya' : 'Tidak';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
