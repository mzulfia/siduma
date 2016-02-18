<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

// use app\models\Pic;
// use app\models\Schedule;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Team';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Name',
                'value' => 'support.support_name'
            ],
            [
                'label' => 'Position',
                'value' => 'support.pos.position_name'
            ],
            [
                'label' => 'Email',
                'value' => 'support.email'
            ],
            [
                'label' => 'No Hp',
                'value' => 'support.no_hp'
            ],
            [
                'label' => 'Company',
                'value' => 'support.company'
            ],
            [
                'label' => 'Shift',
                'value' => 'shift.shift_name'
            ],
            [
                'label' => 'Is Duty Manager',
                'value' => function ($model) {
                    return $model->is_dm == 1 ? 'Ya' : 'Tidak';
                }
            ],
        ],
    ]); ?>

</div>
