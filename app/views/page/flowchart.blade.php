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
              'line-length': 50,
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
                'past' : { 'fill' : '#FFFFF', 'font-size' : 12},
                'current' : {'fill' : 'yellow', 'font-color' : 'red', 'font-weight' : 'bold'},
                'future' : { 'fill' : '#FFFF99'},
                'request' : { 'fill' : 'blue'},
                'invalid': {'fill' : '#444444'},
                'approved' : { 'fill' : '#58C4A3', 'font-size' : 12, 'yes-text' : 'APPROVED', 'no-text' : 'n/a' },
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
st=>operation: การดูแลผู้ป่วยถูกงู...กัด|past
e=>end: Done|past
op1=>operation: CBC,PT,INR, 20 min WBCT,BUN,Creatinine,UA|past
op2=>operation: Stuff|current
sub1=>subroutine: My Subroutine|invalid
cond=>condition: Indication for antivenom|approved
c2=>condition: Good idea|rejected
io=>inputoutput: catch something...|request

st->op1->cond


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
            <a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary btn-lg">Back</button></a>
          </div>
        </div><!-- /.box-footer-->

      </div><!-- /.box -->
    </div>



  </section><!-- /.content -->
@endsection


@section('customjs')

@endsection
