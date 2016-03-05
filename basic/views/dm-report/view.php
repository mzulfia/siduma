<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Report */

$this->title = $model->dm_report_id;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(User::getRoleId(Yii::$app->user->id) == User::ROLE_ADMINISTRATOR): ?>
            <?= Html::a('Update', ['update', 'id' => $model->dm_report_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->dm_report_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif;?>

    </p>

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
            'created_at',
        ],
    ]) ?>

</div>
