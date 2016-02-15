<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pic */

$this->title = $model->pic_id;
$this->params['breadcrumbs'][] = ['label' => 'Pics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pic-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pic_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pic_id], [
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
            'pic_id',
            'pic_nip',
            'pic_name',
            'company',
            'no_hp',
            'pic_position_id',
            'user_id',
        ],
    ]) ?>

</div>