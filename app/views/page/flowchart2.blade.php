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
              'line-width': 2,
              'line-length': 40,
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
st=>operation: Management for systemic bleeding from hematotoxic snake bite|past
e=>operation: Done|past

op1=>operation: 1.Resuscitation
2.Give antivenom ไม่ต้องรอผล lab
3.Check CBC,PT,INR,20 min WBCT,Creatinine
4.G/M blood component และให้ตามความเหมาะสม โดยเริ่มหลังจากให้ antivenom
5.ปรึกษาศูนย์พิษวิทยา โทร 1367|past

op2=>operation: Give Polyvalent
Hematotoxic Snake
antivenom 5 vials|past

op3=>operation: ปรึกษาศุนย์พิษวิทยา โทร 1367|current

op4=>operation: Give Malayan Pit
Viper antivenom 5 vials|{{$patientdata->snake_type == 3 ? 'current':'past'}}

op5=>operation: Give Green Pit
Viper antivenom 5 vials|{{$patientdata->snake_type == 2 ? 'current':'past'}}

op6=>operation: Give Russell
Viper antivenom 5 vials|{{$patientdata->snake_type == 1 ? 'current':'past'}}

cond1=>condition: Known
type of
snake|approved

cond2=>condition: Malayan Pit Viper ?|approved

cond3=>condition: Green Pit Viper ?|approved

cond4=>condition: Russell Viper ?|approved



st->op1->cond1
cond1(yes)->op2
cond1(no)->cond2
cond2(yes)->op4
cond2(no)->cond3
cond3(yes)->op5
cond3(no)->cond4
cond4(yes)->op6
op4->op3
op2->op3
op5->op3
op6->op3
    </textarea></div>
    <div><button id="run" type="button" hidden="">Run</button></div>

    <div class="col-sm-12">
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title"><strong>Flowchart</strong></h3>
        </div>

        <div class="box-body">
          <div class='table-responsive'>
            <div class="col-sm-12 text-center">

                <div id="canvas"></div>

            </div>
          </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
          <div >
            <a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary btn-lg">Back</button></a>
          </div>
        </div><!-- /.box-footer-->

      </div><!-- /.box -->
    </div>



  </section><!-- /.content -->
@endsection


@section('customjs')

@endsection
