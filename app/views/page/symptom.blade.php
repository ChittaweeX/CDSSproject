@extends('layout.main')
@section('customcss')
<link href="{{ url('assets/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
<link href="{{ url('assets/plugins/datapicker/datepicker3.css') }} " rel="stylesheet">
@endsection
@section('pageheader')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Mahidol Snake Envenomation Support System #2
    </h1>

  </section>
@endsection
@section('maincontent')
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box">
          <form role="form" action="{{ url('function/symptom') }}" method="post">
            <input type="hidden" name="treatmentid" value="{{ $treatmentdata->record_id }}">
          <div class="box-header with-border">
            <h3 class="box-title"><strong>Symptom Check</strong></h3>
          </div>
          <div class="box-body text-center">
            <div class="col-md-8 col-md-offset-2">
              <hr>
              <h3><strong>Does the patient has systemic bleeding?</strong></h3>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='systemicB' value='1' required {{ $treatmentdata->systemic_bleeding == 1 ? 'checked' : '' }}>
                          <h1>Yes</h1>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='systemicB' value='0' {{ $treatmentdata->systemic_bleeding == 0 ? 'checked' : '' }} >
                          <h1>No</h1>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>
                <h3><strong>Does the patient have impending respiratory failure?</strong></h3>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='respiratoryF' value='1' required {{ $treatmentdata->respiratory_failure == 1 ? 'checked' : '' }}>
                          <h1>Yes</h1>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='respiratoryF' value='0'  {{ $treatmentdata->respiratory_failure == 0 ? 'checked' : '' }}>
                          <h1>No</h1>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <h3><strong>Does the patient have Motor Weakness?</strong></h3>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='motorweakness' value='1' required {{ $treatmentdata->motor_weakness == 1 ? 'checked' : '' }}>
                          <h1>Yes</h1>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='motorweakness' value='0'  {{ $treatmentdata->motor_weakness == 0 ? 'checked' : '' }}>
                          <h1>No</h1>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>


                <h3><strong>Type of snake</strong></h3>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class='radio-inline'>
                        <label>
                          <img src="http://placehold.it/150x150" alt="" />
                          <h3><input type='radio' name='snaketype' value='1' required {{ $treatmentdata->snake_type == 1 ? 'checked' : '' }}>
                            งูแมวเซา</h3>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>

                          <img src="http://placehold.it/150x150" alt="" />
                          <h3><input type='radio' name='snaketype' value='2'  {{ $treatmentdata->snake_type == 2 ? 'checked' : '' }}>
                            งูเขียวหางไหม้</h3>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>
                          <img src="http://placehold.it/150x150" alt="" />
                          <h3><input type='radio' name='snaketype' value='3'  {{ $treatmentdata->snake_type == 3 ? 'checked' : '' }}>
                            งูกะปะ</h3>
                        </label>
                      </div><hr>
                      <div class='radio-inline'>
                        <label>
                          <img src="http://placehold.it/150x150" alt="" />
                          <h3><input type='radio' name='snaketype' value='4'  {{ $treatmentdata->snake_type == 4 ? 'checked' : '' }}>
                            งูเห่า</h3>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>
                          <img src="http://placehold.it/150x150" alt="" />
                          <h3><input type='radio' name='snaketype' value='5'  {{ $treatmentdata->snake_type == 5 ? 'checked' : '' }}>
                            งูจงอาง</h3>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>

                          <img src="http://placehold.it/150x150" alt="" />
                          <h3><input type='radio' name='snaketype' value='6'  {{ $treatmentdata->snake_type == 6 ? 'checked' : '' }}>
                            งูสามเหลี่ยม</h3>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>

                          <img src="http://placehold.it/150x150" alt="" />
                          <h3><input type='radio' name='snaketype' value='7'  {{ $treatmentdata->snake_type == 7 ? 'checked' : '' }}>
                            งูทับสมิงคลา</h3>
                        </label>
                      </div><hr>
                      <div class='radio-inline'>
                        <label>
                          <h2><input type='radio' name='snaketype' value='8'  {{ $treatmentdata->snake_type == 8 ? 'checked' : '' }}>
                            งูไม่ทราบชนิด</h2>
                        </label>
                      </div>

                    </div>
                  </div>
                </div>
            </div>

          </div><!-- /.box-body -->
          <div class="box-footer">
            <div class="text-center">
              <button type="submit" class="btn  btn-primary btn-lg btn-flat">Next</button>

            </div>
          </div><!-- /.box-footer-->
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
