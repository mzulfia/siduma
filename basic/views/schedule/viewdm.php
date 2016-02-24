<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

// use app\models\Pic;
use app\models\Schedule;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Duty Manager';
$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['viewschedule']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php  
// $this->registerJs("$(function() {
//    $('.popupModal').click(function(e) {
//     e.preventDefault();
//     $('#modal').modal('show').find('#modalContent')
//     .load($(this).attr('href'));
//     e.preventDefault();
//    });
// });");

$this->registerJs("$(function() {
    $(document).on('click', '.popupModal', function(){
    $('#modal').modal('show').find('#modalContent')
    .load($(this).attr('value'));
   });
});");

?>


<?php
        Modal::begin([
            'header' => '<h4>Schedule</h4>',
            'id' => 'modal',
            'size' => 'modal-lg'
        ]);

        echo "<div id='modalContent'>

        </div>";

        Modal::end(); 
?>

<div class="pic-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Name',
                'value' => 'support.support_name'
            ],
            [
                'label' => 'Position',
                'value' => 'support.pos.position_name'
            ],
            [
                'label' => 'Email',
                'value' => 'support.email'
            ],
            [
                'label' => 'No Hp',
                'value' => 'support.no_hp'
            ],
            [
                'label' => 'Company',
                'value' => 'support.company'
            ],
            [
                'label' => 'Shift',
                'value' => 'shift.shift_name'
            ],
            [
                'header'=>'Team Info',
                'format' => 'raw',
                'value'=> function($data)
                        { 
                            return Html::button('details', ['value' => Url::to(['schedule/viewteam', 'id'=>$data->schedule_id]), 'title' => 'details', 'class' => 'popupModal btn btn-success']); 
                        },
            ],
        ],

    ]); 
    ?>

</div>
