<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ReportSupport */

$this->title = $model->support_report_id;
$this->params['breadcrumbs'][] = ['label' => 'Report Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-support-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
