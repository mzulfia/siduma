<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shift */

$this->title = 'Update Shift: ' . ' ' . $model->shift_id;
$this->params['breadcrumbs'][] = ['label' => 'Shifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->shift_id, 'url' => ['view', 'id' => $model->shift_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shift-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
