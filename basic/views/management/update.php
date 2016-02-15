<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Management */

$this->title = 'Update Management: ' . ' ' . $model->management_id;
$this->params['breadcrumbs'][] = ['label' => 'Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->management_id, 'url' => ['view', 'id' => $model->management_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="management-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
