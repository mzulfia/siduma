<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shift */

$this->title = $model->shift_id;
$this->params['breadcrumbs'][] = ['label' => 'Shifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shift-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->shift_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->shift_id], [
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
            'shift_id',
            'shift_name',
            'shift_start',
            'shift_end',
        ],
    ]) ?>

</div>
