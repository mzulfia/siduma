<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Management */

$this->title = $model->management_id;
$this->params['breadcrumbs'][] = ['label' => 'Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="management-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->management_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->management_id], [
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
            'management_id',
            'mgt_nip',
            'mgt_name',
            'mgt_position',
            'user_id',
        ],
    ]) ?>

</div>
