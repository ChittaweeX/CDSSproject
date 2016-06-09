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
          @if (!empty($patientdata->state_give))
            <input type="hidden" name="logtext" value="{{$patientdata->state_give}} {{$patientdata->snake_name}}{{$patientdata->state_vials}}">
            @else
            @if ($patientdata->snake_group == 1)
              <input type="hidden" name="logtext" value="Blood Test">
            @endif
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
                    <h2><strong>Snake type</strong></h2>
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
                  @if (!empty($patientdata->state_give))
                    <h2>{{$patientdata->state_give}} {{$patientdata->snake_name}}{{$patientdata->state_vials}}</h2>
                  @endif
                  <h2>{{$patientdata->state_repeat}}</h2>

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
