@extends('layout.main')
@section('customcss')
<link href="{{ url('assets/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
<link href="{{ url('assets/plugins/datapicker/datepicker3.css') }} " rel="stylesheet">
@endsection
@section('pageheader')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Mahidol Snake Envenomation Support System #5
    </h1>

  </section>
@endsection
@section('maincontent')
  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="row">
      <div class="col-sm-12">
        <div class="box">
          <form role="form" action="{{ url('function/confirmmanagement') }}" method="post">
            <input type="hidden" name="treatmentid" value="{{ $patientdata->record_id }}">
            <input type="hidden" name="state" value="{{ $patientdata->state }}">
            <input type="hidden" name="snaketype" value="{{ $patientdata->snake_type }}">
            <input type="hidden" name="systemic_bleeding" value="{{ $patientdata->systemic_bleeding }}">
            <input type="hidden" name="respiratory_failure" value="{{ $patientdata->respiratory_failure }}">
            <input type="hidden" name="motor_weakness" value="{{ $patientdata->motor_weakness }}">
            @if ($patientdata->snake_group == 1)
              @if ($patientdata->state == 1 or $patientdata->state == 2 or $patientdata->state == 3 or $patientdata->state == 5 )
                  <input type="hidden" name="logtext" value="BloodTest">
              @else
                <input type="hidden" name="logtext" value="{{$patientdata->state_text}} {{$patientdata->snake_name}} {{$patientdata->state_vials}}">
              @endif
            @endif

            @if ($patientdata->snake_group == 2)
              @if ($patientdata->state == 1 or $patientdata->state == 4  )
                  <input type="hidden" name="logtext" value="Observe">
              @else
                <input type="hidden" name="logtext" value="{{$patientdata->state_text}} {{$patientdata->snake_name}} {{$patientdata->state_vials}}">
              @endif
            @endif

            @if ($patientdata->snake_group == 3)
                <input type="hidden" name="logtext" value="Observe and Bloodtest">
            @endif



          <div class="box-header with-border">
            <h3 class="box-title"><strong>Management</strong></h3>
          </div>

          <div class="box-body">
            <div class="col-sm-4">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h2 class="panel-title">Patient Infomation</h2>
                </div>
                <div class="panel-body">
                  <div class="col-sm-12 ">

                    <h3><strong>Name :</strong> {{ $patientdata->patient_name }}</h3>
                    <hr>
                    <h3><strong>Snake type :</strong></h3>
                    <h3 class="text-success">
                      {{ $patientdata->snake_thai_name }}
                      </h3>
                    </div>
                </div>
              </div>

            </div>
            <div class="col-sm-8">


              <div class="panel panel-danger">
                <div class="panel-heading">
                  <h2 class="panel-title"><strong>Management</strong></h2>
                </div>
                <div class="panel-body">
                  @if ($patientdata->snake_group == 1)
                    @if ($patientdata->state == 4)
                      <h2>{{$patientdata->state_text}} {{$patientdata->snake_name}} {{$patientdata->state_vials}}</h2>
                      @else
                        <h2>{{$patientdata->state_text}}</h2>
                    @endif
                  @endif

                  @if ($patientdata->snake_group == 2)
                    @if ($patientdata->state == 3)
                      <h2>{{$patientdata->state_text}} {{$patientdata->snake_name}} {{$patientdata->state_vials}}</h2>
                      @else
                        <h2>{{$patientdata->state_text}}</h2>
                    @endif
                  @endif

                  @if ($patientdata->snake_group == 3)
                    @if ($patientdata->state == 2)
                      <h2><strong>Observe weakness and neuro sign q 1 hr for 24 hr <br>
                         Observe bleeding and bleeding precaution </strong><hr>
                         <strong>CBC,PT,INR,20-min WBCT initially and then <br>
                        every 6 hr for 4 times(0,6,12,18,24) <br>
                        Initial creatinine and then next 24 hr (0,24)</strong></h2>
                    @endif
                    @if ($patientdata->state == 7)
                      <h2><h2>{{$patientdata->state_text}}</h2></h2>
                    @endif
                    @if ($patientdata->state == 8)
                      <h2><h2>{{$patientdata->state_text}}</h2></h2>
                    @endif
                  @endif

                </div>
              </div>
                <button type='submit' class='btn btn-lg btn-success '>Save and Go to Patient Table</button>
            </div>



          </div><!-- /.box-body -->

          </form>
        </div><!-- /.box -->
      </div>
    </div>

  </section><!-- /.content -->
@endsection
@section('customjs')
  <!-- Clock picker -->
  <script src="{{ url('assets/plugins/clockpicker/clockpicker.js') }} "></script>
  <script src="{{ url('assets/plugins/datapicker/bootstrap-datepicker.js') }} "></script>
  <script>
      $(document).ready(function(){


        $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

          $('.clockpicker').clockpicker();

        });
  </script>
@endsection
