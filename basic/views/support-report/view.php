<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ReportSupport */

$this->title = 'Support Report | View Report';
$this->params['breadcrumbs'][] = ['label' => 'Support Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View Report';
?>
<div class="report-support-view">

    <h1>View Report</h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->support_report_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->support_report_id], [
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
            'support_report_id',
            'information:ntext',
            'file_path',
            'created_at',
            'support_id',
            'service_family_id',
        ],
    ]) ?>

</div>
