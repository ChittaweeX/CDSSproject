@extends('layout.main')
@section('customcss')

@endsection
@section('pageheader')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Mahidol Snake Envenomation Support System #4
    </h1>

  </section>
@endsection
@section('maincontent')
  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <form role="form" action="{{ url('function/bloodrecord') }}" method="post">
      <input type="hidden" name="treatmentid" value="{{ $patientdata->record_id }}">
    <div class="row">
      <div class="col-sm-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><strong>Blood Test
            </strong></h3>
          </div>
          <div class="box-body">
            <div class="col-sm-12">
              <h2>Patient : {{ $patientdata->patient_name }}</h2>
              <h2>Snake : {{ $patientdata->snake_thai_name }}</h2>
              <hr>
              <h2>State :
                {{ $patientdata->state_repeat }}</h2>
              <hr>
            </div>
            <div class="col-sm-5">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="exampleInputEmail1">INR</label>
                      <input type="text" class="form-control" autofocus="autofocus" name="INR" placeholder="" value="" >
                      <p class="help-block">Default < 1.2 </p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">20 min WBCT</label>
                      <select class="form-control" name="WBCT" required>
                        <option value="1">
                          clotted
                        </option>
                        <option value="0">
                          unclotted
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <hr>
                <h3>CBC</h3>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="exampleInputEmail1">WBC</label>
                      <input type="number" class="form-control" name="WBC" placeholder="" value="" >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Hct</label>
                      <input type="number" name="Hct" class="form-control" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Platelet</label>
                      <input type="number" name="Platelet" class="form-control" value="">
                    </div>
                  </div>
                </div>
                <hr>
                <h3>UA</h3>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Blood</label>
                      <select class="form-control" name="Blood">
                        <option value="1">
                          +Ve
                        </option>
                        <option value="0">
                          -Ve
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">RBC</label>
                      <select class="form-control" name="RBC">
                        <option value="1">
                          0-1
                        </option>
                        <option value="2">
                          2-5
                        </option>
                        <option value="3">
                          5-10
                        </option>
                        <option value="4">
                          10-20
                        </option>
                        <option value="5">
                          >20
                        </option>
                      </select>
                    </div>
                  </div>
                </div>

            </div>
            <div class="col-sm-7">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title"> Note :</h3>
                </div>
                <div class="panel-body">
                  หาก ร.พ.ไม่มี lab PT ,INR ให้ดูเพียง CBC และ 20-min WBCT
                </div>
              </div>
            </div>
            <div class="col-sm-12">

              <a href="{{ URL::previous() }}">
              <button type="button" class="btn btn-primary btn-lg">Back</button></a>
              <button type="submit" class="btn btn-success btn-lg">Save And Check</button>
            </div>
          </div><!-- /.box-body -->




        </div><!-- /.box -->
      </div>




    </div>
      </form>

  </section><!-- /.content -->
@endsection
@section('customjs')



@endsection
