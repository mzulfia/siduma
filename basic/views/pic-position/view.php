<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PicPosition */

$this->title = $model->pic_position_id;
$this->params['breadcrumbs'][] = ['label' => 'Pic Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pic-position-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pic_position_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pic_position_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pic_position_id',
            'position_name',
        ],
    ]) ?>

</div>
