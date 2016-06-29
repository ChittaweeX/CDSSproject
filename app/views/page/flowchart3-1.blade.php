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
    @if ($patientdata->state == 4)<div><textarea id="code" style="width: 100%;" rows="11" hidden="">
st=>operation: Identification for
Neurotoxic snake|past
e=>operation: Done|past

op1=>operation: งูจงอาง|past

op2=>operation: งูเห่า|past

op3=>operation: งูทับสมิงคลา|past

op4=>operation: Consult PC
(งูกะปะ/งูสามเหลี่ยม แยกด้วยระบาดวิทยา)|current

cond1=>condition: Local edema|approved

cond2=>condition: งูกัดแล้วงับค้าง|approved

cond3=>condition: งูเข้ามากัดภายในบ้าน|approved





st->cond1
cond1(yes,right)->cond2
cond1(no)->cond3
cond2(yes,right)->op1
cond2(no)->op2
cond3(yes,right)->op3
cond3(no)->op4
    </textarea></div>
  @elseif ($patientdata->state == 6)<div><textarea id="code" style="width: 100%;" rows="11" hidden="">
st=>operation: Identification for
Hematotoxic snake|past
e=>operation: Done|past

op2=>operation: งูแมวเซา|past
op3=>operation: งูแมวเซา|past

op4=>operation: Consult PC
(งูเขียวหางไหม้/งูกะปะ แยกด้วยระบาดวิทยา)|current

cond1=>condition: Acute renal failue|approved
cond2=>condition: Local edema|approved





st->cond1
cond1(yes,right)->op2
cond1(no)->cond2
cond2(yes,right)->op4
cond2(no)->op3
    </textarea></div>
    @else<div><textarea id="code" style="width: 100%;" rows="11" hidden="">
st=>operation: Identification for snake
without systemic symptom|past
e=>operation: Done|past

op1=>operation: 1.Observe weakness and neuro sign q 1 hr for 24 hr
2.Observe bleeding and bleeding precaution
3.CBC,PT,INR,20-min WBCT initially and then
every 6 hr for 4 times(0,6,12,18,24)
4.Initial creatinine and then next 24 hr (0,24)|{{$patientdata->state == 2 ? 'current':'past'}}

op2=>operation: Identification for Neurotoxic snake|past
op3=>operation: Identification for Hematotoxic snake|past
op4=>operation: CBC,PT,INR,20-min WBCT,creatinine
once daily for 2 time(48,72)|{{$patientdata->state == 7 ? 'current':'past'}}
op5=>operation: Done|{{$patientdata->state == 8 ? 'current':'past'}}

cond1=>condition: Motor
weakness|approved
cond2=>condition: Thrombocytopenia,or
INR prolong,or
20-min WBCT unclotted|approved
cond3=>condition: กรอกค่า lab ครบ 2 รอบ|approved




st->op1->cond1
cond1(yes,right)->op2
cond1(no)->cond2
cond2(yes,right)->op3
cond2(no)->op4
op4->cond3
cond3(yes)->op5
cond3(no)->cond2
    </textarea></div>
    @endif
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
