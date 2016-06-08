@extends('layout.main')
@section('customcss')

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
    <div class="row">
      <div class="col-sm-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><strong>TEST API</strong></h3>
          </div>
          <div class="box-body">
            <div class="col-sm-12 text-center">
              <form action="http://cdss.topwork.asia:9080/snake-­envenomation/api/login" method="get">
                <div class="form-group">
                  <label for=""></label>
                  <input type="text" class="form-control" id="username" placeholder="">
                </div>
                <div class="form-group">
                  <label for=""></label>
                  <input type="text" class="form-control" id="patient_national_id" placeholder="">
                </div>
                <button type='submit' class='btn btn-lg btn-default '>SEND</button>
              </form>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <div >
              <a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary btn-lg">Back</button></a>
            </div>
          </div><!-- /.box-footer-->
        </div><!-- /.box -->
      </div>
    </div>





  </section><!-- /.content -->
@endsection
@section('customjs')

@endsection
