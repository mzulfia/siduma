<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pic */

$this->title = 'Edit Profile';
$this->params['breadcrumbs'][] = 'Edit Profile';
?>
<div class="support-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
