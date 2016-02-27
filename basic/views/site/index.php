<?php
 use miloschuman\highcharts\Highcharts;
 use kartik\form\ActiveForm;
 use kartik\daterange\DateRangePicker;
 use yii\helpers\Html;
 use yii\helpers\Url;
 use yii\helpers\ArrayHelper;
 use yii\widgets\Pjax;
 use app\models\ServiceFamily;
 use app\models\Schedule;


/* @var $this yii\web\View */

$this->title = 'SIDUMA';

$this->registerJs(
   '$("document").ready(function(){ 
        $("#new_chart").on("pjax:end", function() {
            $.pjax.reload({container:"#columnChart"});  //Reload columnChart
        });
    });'
);

?>
<div class="site-index">

    <div class="jumbotron">
        <h1><b><i class="fa fa-dashboard"></i><span>Dashboard</span></b></h1>
    </div>           
    <div class="col-md-12" style = 'text-align: center; margin-bottom: 20px'> 
        <?php Pjax::begin(['id' => 'new_chart'])?>
            <?php 
                $form = ActiveForm::begin(
                [
                    'id' => 'dashboard-form',
                    'type' => ActiveForm::TYPE_INLINE,
                ],
                ['options' => ['data-pjax' => true ]
                ]
                );
            ?>
                    
            <?= $form->field($model, 'date', [
                        'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
                        'options'=>['class'=>'drp-container form-group']
                    ])->widget(DateRangePicker::classname(), [
                    'useWithAddon'=>true,
                ]);
            ?>

            <?= Html::submitButton('Get', ['name' => 'dashboard-button', 'class' => 'btn btn-success']) ?>        
            
             <?php ActiveForm::end(); ?>
        <?php Pjax::end() ?>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-6">
                <?php Pjax::begin(['id' => 'columnChart'])?>
                <?= 
                Highcharts::widget([
                    'options' => [
                        'chart' => [ 'type' => 'column' ],
                        'title' => [ 'text' => $date ],
                        'xAxis' => [
                            'categories' => ['ERP','Email dan Jaringan Data', 'AP2T', 'P2APST', 'BBO', 'APKT', 'ITSM']
                        ],
                        'yAxis' => [
                            'title' => ['text' => 'Amounts']
                        ],
                        'series' => [
                            [
                                'name' => 'Baik',
                                'data' => [$ok_erp, $ok_email, $ok_ap2t, $ok_p2apst, $ok_bbo, $ok_apkt, $ok_itsm]
                            ],
                            [
                                'name' => 'Tidak', 
                                'data' => [$bad_erp, $bad_email, $bad_ap2t, $ok_p2apst, $bad_bbo, $bad_apkt, $bad_itsm]
                            ],
                        ],
                        'plotOptions' => [
                            'series' => [
                                'borderWidth' => 0,
                                'dataLabels' => [
                                    'enabled' => true,
                                    'format' => '{point.y:.1f}%'
                                ]
                            ]
                        ],
                        'tootip' => [
                            'headerFormat' => '<span style="font-size:11px">{series.name}</span><br>',
                            'pointFormat' => '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                        ]
                        //     [
                        //         'name' => 'AP2T', 
                        //         'data' => [$ok, $bad]
                        //     ],
                        //     [
                        //         'name' => 'P2APST', 
                        //         'data' => [$ok, $bad]
                        //     ],
                        //     [
                        //         'name' => 'BBO', 
                        //         'data' => [$ok, $bad]
                        //     ],
                        //     [
                        //         'name' => 'APKT', 
                        //         'data' => [$ok, $bad]
                        //     ],
                        //     [
                        //         'name' => 'ITSM', 
                        //         'data' => [$ok, $bad]
                        //     ]
                        // ],
                        // 'tooltip' => [
                        //     'formatter' => function() {
                        //         return '<b>' + this.series.name + '</b><br/>' +
                        //         this.point.y + ' ' + this.point.name.toLowerCase();
                        //     }
                        // ]
                        ]
                    ]); 
                ?>  
               
               <?php Pjax::end()?>
            </div>
            <div class="col-lg-6">
                <h3 style='text-align: center'><b><i class="fa fa-users"></i><span>Duty Manager Now</span></b></h3>
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Shift</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            // $array = Schedule::getDmNow();
                            // echo '
                            //     <tr>
                            //         <td>' . $array->support->support_name . '</td>
                            //         <td>' . $array->support->no_hp . '</td>
                            //         <td>' . $array->support->email . '</td>
                            //         <td>' . $array->shift->shift_name . '<br>' . $array->shift->shift_start . ' s.d. ' . $array->shift->shift_end . '</td>
                            //     </tr>';
                        ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
// $js = <<<JS

// // get the form id and set the event
// $('#dashboard-form').on('beforeSubmit', function(e) { 
//    var form = $(this);
//     if(form.find('.has-error').length) {
//         return false;
//     }
//     $.ajax({
//         url: form.attr('action'),
//         type: 'post',
//         data: form.serialize(),
//         success: function(response) { 
//             var csrf = yii.getCsrfToken();
//             var date = $('#schedule-date').val();
//             var service-family_id = $('#servicefamily-service_family_id').val();
//             var url = form.attr('action')+ '&_csrf='+csrf+'&Schedule[date]='+date+'&ServiceFamily[service_family_id]='+service_family_id;
//             $.pjax.reload({url: url, container:'#pieChart'});
//         }
//     });    
// }).on('submit', function(e){
// e.preventDefault();
// });


// JS;
// $this->registerJs($js);
?>