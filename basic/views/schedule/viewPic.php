<?php

use yii\helpers\Html;
use yii\grid\GridView;

// use app\models\Pic;
// use app\models\Schedule;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List PIC';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Name',
                'attribute' => 'pic_id',
                'value' => 'pic.pic_name'
            ],
            [
                'label' => 'Position',
                'attribute' => 'position_name',
                'value' => 'pic.pos.position_name'
            ],
            'shift_start',
            'shift_end',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
