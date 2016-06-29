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
          <form role="form" action="{{ url('function/symptom2') }}" method="post">
            <input type="hidden" name="treatmentid" value="{{ $treatmentdata->record_id }}">
          <div class="box-header with-border">
            <h3 class="box-title"><strong>Symptom Check</strong></h3>
          </div>
          <div class="box-body text-center">
            <div class="col-md-8 col-md-offset-2">
              <hr>
              <h3><strong>Does the patient has Local edema?</strong></h3>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='Localedema' value='1' required {{ $treatmentdata->localedema == 1 ? 'checked' : '' }}>
                          <h1>Yes</h1>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='Localedema' value='0' {{ $treatmentdata->localedema == 0 ? 'checked' : '' }} >
                          <h1>No</h1>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>
                <h3><strong>งูกัดแล้วงับค้าง?</strong></h3>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='locked_jaw' value='1' required {{ $treatmentdata->locked_jaw == 1 ? 'checked' : '' }}>
                          <h1>Yes</h1>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='locked_jaw' value='0'  {{ $treatmentdata->locked_jaw == 0 ? 'checked' : '' }}>
                          <h1>No</h1>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <h3><strong>งูเข้ามากัดภายในบ้าน?</strong> </h3>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='indoor' value='1' required {{ $treatmentdata->indoor == 1 ? 'checked' : '' }}>
                          <h1>Yes</h1>
                        </label>
                      </div>
                      <div class='radio-inline'>
                        <label>
                          <input type='radio' name='indoor' value='0'  {{ $treatmentdata->indoor == 0 ? 'checked' : '' }}>
                          <h1>No</h1>
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
