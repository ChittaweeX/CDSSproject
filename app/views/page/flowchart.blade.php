@extends('layout.main')
@section('customcss')
<style type="text/css">
  .end-element { background-color : #FFCCFF; }
</style>
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://flowchart.js.org/flowchart-latest.js"></script>
<script>

    window.onload = function () {
        var btn = document.getElementById("run"),
            cd = document.getElementById("code"),
            chart;

        (btn.onclick = function () {
            var code = cd.value;

            if (chart) {
              chart.clean();
            }

            chart = flowchart.parse(code);
            chart.drawSVG('canvas', {
              // 'x': 30,
              // 'y': 50,
              'line-width': 3,
              'line-length': 80,
              'text-margin': 10,
              'font-size': 20,
              'font': 'normal',
              'font-family': 'Helvetica',
              'font-weight': 'normal',
              'font-color': 'black',
              'line-color': 'black',
              'element-color': 'black',
              'fill': 'white',
              'yes-text': 'yes',
              'no-text': 'no',
              'arrow-end': 'block',
              'scale': 1,
              'symbols': {
                'start': {
                  'font-color': 'red',
                  'element-color': 'green',
                  'fill': 'yellow'
                },
                'end':{
                  'class': 'end-element'
                }
              },
              'flowstate' : {
                'past' : { 'fill' : '#5cb85c', 'font-size' : 12},
                'current' : {'fill' : '#f0ad4e', 'font-size' : 12, 'class' : 'animated infinite flash' },
                'future' : { 'fill' : '#FFFF99'},
                'request' : { 'fill' : 'blue'},
                'invalid': {'fill' : '#444444'},
                'approved' : { 'fill' : '#428bca', 'font-size' : 12, 'yes-text' : 'Y', 'no-text' : 'N'  },
                'rejected' : { 'fill' : '#C45879', 'font-size' : 12, 'yes-text' : 'n/a', 'no-text' : 'REJECTED' }
              }
            });

            $('[id^=sub1]').click(function(){
              alert('info here');
            });
        })();

    };
</script>
@endsection
@section('pageheader')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Mahidol Snake Envenomation Support System
    </h1>

  </section>
@endsection
@section('maincontent')
  <!-- Main content -->
  <section class="content">
    <div><textarea id="code" style="width: 100%;" rows="11" hidden="">
st=>operation: การดูแลผู้ป่วยถูก{{$patientdata->snake_thai_name}}กัด|past
e=>operation: Done|{{$patientdata->state == 10 ? 'current':'past'}}
op1=>operation: CBC,PT,INR, 20 min WBCT,BUN,Creatinine,UA|{{$patientdata->state == 1 ? 'current':'past'}}
op2=>operation: CBC,PT,INR, 20 min WBCT q 6 hr for 2 times(6,12)|{{$patientdata->state == 2 ? 'current':'past'}}
op3=>operation: Antivenom for {{$patientdata->snake_name}} 5 vials
Repeat CBC,PT,INR, 20 min WBCT q 4 hr for 3 times|{{$patientdata->state == 5 ? 'current':'past'}}
op4=>operation: D/C CBC,PT,INR,20 min WBCT,Creatinine
Once daily for 3 day (24-36,48-60,72-84)|{{$patientdata->state == 3 ? 'current':'past'}}
op5=>operation: @if ($patientdata->state == 6)
  (Systemic bleeding)
@endif
@if ($patientdata->state == 11)
  Emergency case
@endif
@if ($patientdata->state == 7)
  Discordance of data
@endif
@if ($patientdata->state == 8)
  Chang Snake type
@endif
Consult PC|{{$patientdata->state == 6 || $patientdata->state == 11 || $patientdata->state == 7 || $patientdata->state == 8 || $patientdata->state == 9 ? 'current':'past'}}
@if ($patientdata->state == 6)
:>{{url("page/flowchart2/$patientdata->record_id")}}
@endif
cond1=>condition: Indication for antivenom|approved
cond2=>condition: Indication for antivenom|approved
cond3=>condition: Indication for antivenom|approved
cond4=>condition: Indication for antivenom|approved
st->op1->cond1
cond1(yes,right)->op3
cond1(no)->op2
op2->cond2
cond2(yes,right)->op3
cond2(no)->op4
op3->cond4
cond4(yes)->op5
cond4(no)->op4
op4->cond3
cond3(yes,right)->op3
cond3(no)->e

    </textarea></div>
    <div><button id="run" type="button" hidden="">Run</button></div>

    <div class="col-sm-12">
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title"><strong>Flowchart</strong></h3>
        </div>

        <div class="box-body">
          <div class="col-sm-12 text-center">

              <div id="canvas"></div>

          </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
          <div >
            <a href="{{ url('page/patienttable') }}"><button type="button" class="btn btn-primary btn-lg">Back</button></a>
          </div>
        </div><!-- /.box-footer-->

      </div><!-- /.box -->
    </div>



  </section><!-- /.content -->
@endsection


@section('customjs')

@endsection
