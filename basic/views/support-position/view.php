<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SupportPosition */

$this->title = 'Support Positions | View Position';
$this->params['breadcrumbs'][] = ['label' => 'Support Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View Position';
?>
<div class="support-position-view">

    <h1>View Position</h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->support_position_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->support_position_id], [
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
            'support_position_id',
            'position_name',
        ],
    ]) ?>

</div>
