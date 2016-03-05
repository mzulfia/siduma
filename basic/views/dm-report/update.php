<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Report */

$this->params['breadcrumbs'][] = ['label' => 'Duty Manager Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Report';
?>
<div class="report-update">

    <?= $this->render('_formUpdate', [
        'model' => $model,
    ]) ?>

</div>
