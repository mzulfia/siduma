<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pic */

$this->title = $model->support_id;
$this->params['breadcrumbs'][] = ['label' => 'Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->support_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->support_id], [
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
            'support_id',
            'support_name',
            'company',
            'no_hp',
            'email',
            'support_position_id',
            'user_id',
        ],
    ]) ?>

</div>
