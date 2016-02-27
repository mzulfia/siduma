<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pic', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'support_id',
            'support_name',
            'company',
            'no_hp',
            'email',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'bordered'=>true,
    ]); ?>

</div>
