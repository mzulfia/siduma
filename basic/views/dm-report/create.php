<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Report */

$this->title = 'Create Report';
$this->params['breadcrumbs'][] = ['label' => 'Duty Manager Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-create">

    <?= 
    	$this->render('_formCreate',[
            'erp'=>$erp,
            'email'=>$email,
            'ap2t'=>$ap2t,
            'p2apst'=>$p2apst,
            'bbo'=>$bbo,
            'apkt'=>$apkt,
            'itsm'=>$itsm,
        ]);
    ?>

</div>
