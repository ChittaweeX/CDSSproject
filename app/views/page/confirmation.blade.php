@extends('layout.main')
@section('customcss')
<link href="{{ url('assets/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
<link href="{{ url('assets/plugins/datapicker/datepicker3.css') }} " rel="stylesheet">
@endsection
@section('pageheader')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Mahidol Snake Envenomation Support System #1
    </h1>

  </section>
@endsection
@section('maincontent')
  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <form role="form" action="{{ url('function/confirmdata') }}" method="post">
      <div class="box-header with-border">
        <h2 class="box-title "><strong>Confirmation of data</strong></h2>
      </div>

      <div class="box-body">
        <div class="col-sm-12">
          <h3>Physician's information</h3>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Physician's ID</label>
                  <input type="text" class="form-control"  name="physicianID" placeholder="" value="{{ $physicianData->physician_id }}" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Physician Name</label>
                  <input type="text" class="form-control" name="physicianname" placeholder="" value="{{ $physicianData->physician_name }}" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Location/Hospital</label>
                  <input type="text" class="form-control"  name="hostLocation" placeholder="" value="{{ $physicianData->physic_workplace }}" >
                </div>
              </div>
            </div>
            <hr>
            <h3>Patient's information</h3>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Patient's national ID</label>
                  <input type="text" class="form-control" name="patient_national_id" placeholder="" value="{{ $patientData->patient_national_id }}" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Patient's Name</label>
                  <input type="text" class="form-control" name="patient_name" placeholder="Name" value="{{ $patientData->patient_name }}" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Patient's Gender</label>
                  <select name="patientGender" class="form-control">
                    <option value="1" {{ $patientData->patient_gender == '1' ? 'selected' :'' }}>
                      Male
                    </option>
                    <option value="2" {{ $patientData->patient_gender == '2' ? 'selected' :'' }}>
                      Female
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Patient's Age</label>
                  <div class="row">
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="PatientAgeY" placeholder="Years" value="{{ $patientData->patient_ageY }}" required>
                    </div>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="PatientAgeM" placeholder="Months" value="{{ $patientData->patient_ageM }}" >
                    </div>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="PatientAgeD" placeholder="Days" value="{{ $patientData->patient_ageD }}" >
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <hr>
            <h3>Date and time of incident</h3>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Date of incident</label>
                  <div class="form-group" id="data_1">
                      <div class="input-group date">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="incident_date" value="" required>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Time of incident</label>
                  <div class="input-group clockpicker" data-autoclose="true">
                      <input type="text" class="form-control" value="" name="incident_time"  required>
                      <span class="input-group-addon">
                          <span class="fa fa-clock-o"></span>
                      </span>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <h3>Location of Incident</h3>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">District</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="incident_district" >
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="exampleInputPassword1">Province</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="" name="incident_province" required>
                </div>
              </div>
            </div>

        </div>

      </div><!-- /.box-body -->
      <div class="box-footer">
        <div class="text-center">
          <a href="{{ url('/') }}">
          <button type="button" class="btn btn-danger btn-lg btn-flat">Cancel</button></a>
          <button type="submit" class="btn btn-primary btn-lg btn-flat">Next</button>
        </div>
      </div><!-- /.box-footer-->
      </form>
    </div><!-- /.box -->

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
