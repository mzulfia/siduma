<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupportAreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Support Areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-area-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Support Area', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'support_area_id',
            'support_id',
            'service_family_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
