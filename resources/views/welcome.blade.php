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
    url: "/institution/teacherdata",
    method: "GET",
    success: function(data) {
      //console.log(data);
      var institution = [];
      var count_m_teacher = [];
      var count_f_teacher = [];
      var datacount = data.count;

      datacount.sort(function(a, b){
        return (b.male_teacher + b.female_teacher) - (a.male_teacher + a.female_teacher)
      });

      for(var i in datacount) {
        institution.push(datacount[i].institution);
        count_m_teacher.push(datacount[i].male_teacher);
        count_f_teacher.push(datacount[i].female_teacher);
      }

      var chartdata = {
        labels: institution,
        datasets : [
          {
            label: 'Ustadz',
            backgroundColor: '#4F98C3',            
            hoverBackgroundColor: '#25536D',
            data: count_m_teacher, 
          },
          {
            label: 'Ustadzah',
            backgroundColor: '#D2D6DE',                        
            hoverBackgroundColor: '#8795A7',
            data: count_f_teacher, 
          }
        ]
      };

      var ctx = $("#teacherChart");
      var barGraph = new Chart(ctx, {
        type: 'horizontalBar',
        data: chartdata,
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
            xAxes:[{
              stacked:true
            }]
          },
          title:{
            display:true,
            text:"Jumlah " + (data.all_male_teacher + data.all_female_teacher) + " orang | L="+ data.all_male_teacher + " / P=" + data.all_female_teacher
          }
        }
      });
      $('#metal').text('metal')
    },
    error: function(data) {
      console.log(data);
    }

   
  });         
</script>


  <script>
    $.ajax({
    url: "/institution/studentdata",
    method: "GET",
    success: function(data) {
      //console.log(data);
      var institution = [];
      var tpqa_ac_male = [];
      var tpqa_ac_female = [];
      var tpqd_ac_male = [];
      var tpqd_ac_female = [];
      var tpqa_na = [];
      var tpqd_na = [];

      institution.sort();

      for(var i in data) {
        institution.push(data[i].institution);
        tpqa_ac_male.push(data[i].tpqa_ac_male);
        tpqa_ac_female.push(data[i].tpqa_ac_female);
        tpqd_ac_male.push(data[i].tpqd_ac_male);
        tpqd_ac_female.push(data[i].tpqd_ac_female);
        tpqa_na.push(data[i].tpqa_na * -1);
        tpqd_na.push(data[i].tpqd_na * -1);
      }

      var chartdata = {
        labels: institution,
        datasets : [
          {
            stack: 'Stack 0',
            label: 'TPQA - L',
            backgroundColor: '#00C0EF',            
            data: tpqa_ac_male, 
          },
          {
            stack: 'Stack 0',
            label: 'TPQA - P',
            backgroundColor: '#DD4B39',                        
            data: tpqa_ac_female, 
          },
          {
            stack: 'Stack 1',
            label: 'TPQD - L',
            backgroundColor: '#07A65A',                        
            data: tpqd_ac_male, 
          },
          {
            stack: 'Stack 1',
            label: 'TPQD - P',
            backgroundColor: '#F39C12',
            data: tpqd_ac_female, 
          },
          {
            stack: 'Stack 0',
            label: 'TPQA NA',
            backgroundColor: '#333333',
            data: tpqa_na , 
          },
          {
            stack: 'Stack 1',
            label: 'TPQD NA',
            backgroundColor: '#999999',
            data: tpqd_na , 
          }          
        ]
      };

      var ctx = $("#studentChart");
      var barGraph = new Chart(ctx, {
        type: 'horizontalBar',
        data: chartdata,
        options: {
          responsive: true,
          legend: {
            position: 'right',
          },                  
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              },
              stacked:true
            }],
            xAxes:[{
              stacked:true
            }]
          },
        }
      });
    },
    error: function(data) {
      console.log(data);
    }
  });         
</script>

@endsection

@section('content-top')
      @include('flash::message')
      <h1>Dashboard</h1>
@endsection

@section('content-main')





<!--<div class="row">
  <div class="col-sm-4">
    <div class="box box-primary">
      <div class="box-header">
          <h3 class="box-title">Pengguna</h3>
      </div>
      <div class="box-body">

      </div>
    </div>
  </div>-->
  
  <div class="col-sm-6">
   <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Ustadz/ah</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="teacherChart"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
  </div>

  <div class="col-sm-6">
   <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Santri</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="studentChart"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
  </div>
  <div id="metal"></div>
  <div class="col-sm-6">
    @foreach($transaction_groups as $key=>$transaction_group)
      {{ $key }} = {{ $transaction_group }} <br>
    @endforeach
    Total dana = {{ array_sum($transaction_groups) }}

    @foreach($transaction_dates as $key=>$transaction_date)
      {{ $key }} = {{ $transaction_date }} <br>
    @endforeach
  </div>


</div>









@endsection