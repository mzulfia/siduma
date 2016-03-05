<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Report */

$this->title = 'Report';
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-view">

     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Service Family',
                'value' => $model->service->service_name
            ],
            [
                'label' => 'Status',
                'value' => ($model->status == 2) ? "Normal" : ($model->status == 1 ? "Warning" : "Critical")
            ],
            [
                'label' => 'File',
                'format' => 'raw',
                'value' => $model->file_path == NULL ? NULL : Html::a(Html::encode(explode("/", $model->file_path)[3]), 
                        Url::toRoute(['dm-report/download', 'file_path' => $model->file_path]), 
                        [
                           'data-method' => 'post',
                        ])
            ],
            'information:ntext',
            [
                'label' => 'Support Name',
                'value' => $model->support->support_name
            ],
            [
                'label' => 'Email',
                'value' => $model->support->email
            ],
            [
                'label' => 'No HP',
                'value' => $model->support->no_hp
            ],
            'created_at',
        ],
    ]) ?>

</div>
