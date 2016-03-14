<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceFamily */

$this->title = 'Service Families | View Service Family';
$this->params['breadcrumbs'][] = ['label' => 'Service Families', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View Service Family';
?>
<div class="service-family-view">

    <h1>View Service Family</h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->service_family_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->service_family_id], [
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
            'service_family_id',
            'service_name',
        ],
    ]) ?>

</div>
