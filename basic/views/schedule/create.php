<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Schedule */

$this->title = 'Create Schedule';
$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-create">

    <?= $this->render('_formCreate', [
        'model' => $model,
    ]) ?>

</div>
