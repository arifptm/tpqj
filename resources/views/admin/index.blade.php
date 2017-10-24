
@extends('template.layout')

@section('header-scripts')
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
@endsection

@section('footer-scripts')
<script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
<script src="/bower_components/chart.js/dist/Chart.js"></script>
<script src="/js/custom.js"></script>

<script>
  $.ajax({
    url: "/data/i-teachers",
    method: "GET",
    success: function(data) {
      var institution = [];
      var all_male_teacher = [];
      var all_female_teacher = [];
      var datateacher = data.data_teacher;

      datateacher.sort(function(a, b){
        return (b.male_teacher.count + b.female_teacher.count) - (a.male_teacher.count + a.female_teacher.count)
      });

      for(var i in datateacher) {
        institution.push(datateacher[i].institution);
        all_male_teacher.push(datateacher[i].male_teacher.count);
        all_female_teacher.push(datateacher[i].female_teacher.count);

      }  
 
      var chartdata1 = {
        labels: institution,
        datasets : [{
          label: 'Ustadz',
          backgroundColor: '#4F98C3',            
          hoverBackgroundColor: '#25536D',
          data: all_male_teacher, 
        },{
          label: 'Ustadzah',
          backgroundColor: '#D2D6DE',                        
          hoverBackgroundColor: '#8795A7',
          data: all_female_teacher, 
        }
        ]
      };   

      var ctx = $("#teacherChart");
      
      function show() {

        $('#teacherChart').delay(500).fadeIn(function() {
        


      var barGraph = new Chart(ctx, {
        type: 'horizontalBar',
        data: chartdata1,
        options: {
          responsive: true,
          legend: {
            position: 'top',
          },                  
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              },
              stacked:true
            }],
          },
        }
      });
});
    }                       
  })
</script>

<script>
  $.ajax({
    url: "/data/i-students",
    method: "GET",
    success: function(data) {
      var institution = [];
      var tpqa_ac_male = [];
      var tpqa_ac_female = [];
      var tpqd_ac_male = [];
      var tpqd_ac_female = [];
      // var tpqa_na = [];
      // var tpqd_na = [];
      var datastudent = data.data_student;

      for(var i in datastudent) {
        institution.push(datastudent[i].institution);
        tpqa_ac_male.push(datastudent[i].tpqa_ac_male);
        tpqa_ac_female.push(datastudent[i].tpqa_ac_female);
        tpqd_ac_male.push(datastudent[i].tpqd_ac_male);
        tpqd_ac_female.push(datastudent[i].tpqd_ac_female);
        // tpqa_na.push(datastudent[i].tpqa_na * -1);
        // tpqd_na.push(datastudent[i].tpqd_na * -1);       
      }  

      var chartdata2 = {
        labels: institution,
        datasets : [
        {
          stack: 'Stack 1',
          label: 'TPQA - L',
          backgroundColor: '#00C0EF',            
          data: tpqa_ac_male, 
        },
        {
          stack: 'Stack 1',
          label: 'TPQA - P',
          backgroundColor: '#DD4B39',                        
          data: tpqa_ac_female, 
        },
        // {
        //   stack: 'Stack 1',
        //   label: 'TPQA NA',
        //   backgroundColor: '#333333',
        //   data: tpqa_na, 
        // },
        {
          stack: 'Stack 2',
          label: 'TPQD - L',
          backgroundColor: '#07A65A',                        
          data: tpqd_ac_male, 
        },
        {
          stack: 'Stack 2',
          label: 'TPQD - P',
          backgroundColor: '#F39C12',
          data: tpqd_ac_female, 
        },
        // {
        //   stack: 'Stack 2',
        //   label: 'TPQD NA',
        //   backgroundColor: '#999999',
        //   data: tpqd_na, 
        // }          
        ]
      };   

      var ctx = $("#studentChart");
      var barGraph = new Chart(ctx, {
        type: 'horizontalBar',
        data: chartdata2,
        options: {
          responsive: true,
          legend: {
            // position: 'right',
          display:true,
            labels: {
              boxWidth:20
            }
          },          
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              },
              stacked:true
            }],
          },
        }
      });
    }                  
  })
</script>

<script>
  $.ajax({
    url: "/data/i-achievements",
    method: "GET",
    success: function(data) {
      var stage = [];
      var count = [];
      var dataachievement = data.data_achievement;

        // datateacher.sort(function(a, b){
        //   return (b.male_teacher.count + b.female_teacher.count) - (a.male_teacher.count + a.female_teacher.count)
        // });

        for(var i in dataachievement) {
          stage.push(dataachievement[i].name);
          count.push(dataachievement[i].student.length);
        }  

        var chartdata2 = {
          labels: stage,
          datasets : [{
            label: 'Jumlah Santri',
            backgroundColor: '#4F98C3',            
            hoverBackgroundColor: '#25536D',
            data: count, 
          }
          ]
        };   

        var ctx = $("#achievementChart");
        var barGraph = new Chart(ctx, {
          type: 'horizontalBar',
          data: chartdata2,
          options: {
            responsive: true,
            legend: {
              position: 'top',
            },                  
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true
                },
                stacked:true
              }],
            },
          }
        });
      }                       
    })
  </script>  




  @endsection

  @section('content-top')
  @include('flash::message')
  <h1>Dashboard</h1>
  @endsection

  @section('content-main')
  <div class="row">
    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Guru Qiraati DIY</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="teacherChart" style="height:320px"></canvas>
            <div class="loader" style="min-height: 200px;"></div>  
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Santri Qiraati DIY</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="studentChart" style="height:320px"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-sm-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Grafik Prestasi Santri</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="achievementChart" style="height:320px"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Statistik</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-xs-6 col-sm-3 col-md-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{ $institutions }}<!-- <sup style="font-size: 20px"> orang</sup></h3></h3> -->

                  <p>Lembaga</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="/institutions" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-xs-6 col-sm-3 col-md-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{ $students }}

                  <p>Santri</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="/students" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-xs-6 col-sm-3 col-md-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{ $teachers }}</h3>

                  <p>Pengurus</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="/persons" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-xs-6 col-sm-3 col-md-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{ $nonteachers }}</h3>

                  <p>Amanah</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="/persons" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>          
        </div>
      </div>
    </div>
  </div>  










@endsection