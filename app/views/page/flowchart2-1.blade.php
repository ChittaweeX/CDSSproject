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
    @if ($patientdata->snake_type==4 or $patientdata->snake_type==5)<div><textarea id="code" style="width: 100%;" rows="11" hidden="">
st=>operation: การดูแลผู้ป่วยถูก{{$patientdata->snake_thai_name}}กัด|past
e=>operation: Done|{{$patientdata->state == 6 ? 'current':'past'}}
op1=>operation: Observe motor weakness q 1 hr for 24 hr|{{$patientdata->state == 1 ? 'current':'past'}}
op2=>operation: Intubation and ventilation support
(Consult PC)|{{$patientdata->state == 2 ? 'current':'past'}}
op3=>operation: Antivenom for {{$patientdata->snake_name}} 10 vials
Observe motor weakness q 1 hr for 12 hr|{{$patientdata->state == 4 ? 'current':'past'}}
op4=>operation: Consult PC|{{$patientdata->state == 5 || $patientdata->state == 8 || $patientdata->state == 9 || $patientdata->state == 10  ? 'current':'past'}}
@if ($patientdata->state == 6)
:>{{url("page/flowchart2/$patientdata->record_id")}}
@endif
cond1=>condition: Impending respiratory
failure|approved
cond2=>condition: Any motor weakness|approved
cond3=>condition: Progression of weakness|approved
cond4=>condition: At 12 hr, any motor
weakness|approved

st->op1->cond1
cond1(yes,right)->op2->op3->cond3
cond1(no)->cond2
cond3(yes,right)->op4
cond3(no)->cond4
cond4(yes,right)->op4
cond4(no)->e
cond2(yes)->op3
cond2(no)->e
    </textarea></div>
    @else<div><textarea id="code" style="width: 100%;" rows="11" hidden="">
st=>operation: การดูแลผู้ป่วยถูก{{$patientdata->snake_thai_name}}กัด|past
e=>operation: Done|{{$patientdata->state == 6 ? 'current':'past'}}
op1=>operation: Observe motor weakness q 1 hr for 24 hr|{{$patientdata->state == 1 ? 'current':'past'}}
op2=>operation: Intubation and ventilation support
(Consult PC)|{{$patientdata->state == 2 ? 'current':'past'}}
op3=>operation: Antivenom for {{$patientdata->snake_name}} 10 vials
Observe motor weakness q 1 hr for 12 hr|{{$patientdata->state == 4 ? 'current':'past'}}
op4=>operation: Consult PC|{{$patientdata->state == 5 || $patientdata->state == 8 || $patientdata->state == 9 || $patientdata->state == 10  ? 'current':'past'}}
@if ($patientdata->state == 6)
:>{{url("page/flowchart2/$patientdata->record_id")}}
@endif
cond1=>condition: Impending respiratory
failure|approved
cond2=>condition: Any motor weakness|approved
cond3=>condition: Progression of weakness|approved
cond4=>condition: At 12 hr, any motor
weakness|approved

st->cond1
cond1(yes,right)->op2->op3->cond3
cond1(no)->op3
cond3(yes,right)->op4
cond3(no)->cond4
cond4(yes,right)->op4
cond4(no)->e
cond2(yes)->op3
cond2(no)->e

    </textarea></div>
    @endif
    <div><button id="run" type="button" hidden="">Run</button></div>

    <div class="col-sm-12">
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title"><strong>Flowchart</strong></h3>
        </div>

        <div class="box-body">
          <div class="col-sm-12 text-center">
           <div class='table-responsive'>
             <div id="canvas"></div>
           </div>


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
