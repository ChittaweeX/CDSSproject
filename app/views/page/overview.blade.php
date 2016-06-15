@extends('layout.main')
@section('customcss')


@section('pageheader')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Mahidol Snake Envenomation Support System #7
    </h1>

  </section>
@endsection
@section('maincontent')
  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h2 class="box-title "><strong>Overview</strong></h2>
      </div>
      <div class="box-body">
        <div class="col-sm-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h2 class="panel-title">Patient Infomation</h2>
            </div>
            <div class="panel-body">
              <div class="col-sm-12 ">

                <h4><strong>Name :</strong> {{ $patientdata->patient_name }}</h4>
                <h4><strong>CardID :</strong> {{ $patientdata->patient_national_id }}</h4>
                <h4><strong>Gender :</strong> {{ ( $patientdata->patient_gender == '1' ? 'Male' : 'Female') }}</h4>
                <h4><strong>Age :</strong> {{ $patientdata->patient_ageY }} Y , {{ $patientdata->patient_ageM }} M, {{ $patientdata->patient_ageD }} D</h4>
                <hr>
                <h3><strong>Incident Info</strong></h3>
                <h4><strong>Date :</strong> {{ $patientdata->incident_date }}</h4>
                <h4><strong>Time :</strong> {{ $patientdata->incident_time }}</h4>
                <h4><strong>Location of Incident</strong></h4>
                <h4><strong>District :</strong> {{ $patientdata->incident_district }}</h4>
                <h4><strong>Province :</strong> {{ $patientdata->incident_province }}</h4>
                <hr>
                <h3><strong>Snake Info</strong></h3>
                <h3><strong>Snake type :</strong><span class="text-success">
                  {{ $patientdata->snake_thai_name }}
                </span></h3>
                @if($patientdata->systemic_bleeding == 1)
                  <h2 class="text-danger"><strong>Systemic bleeding</strong></h2>
                @endif
                @if($patientdata->respiratory_failure == 1)
                  <h2 class="text-danger"><strong>Respiratory failure</strong></h2>
                @endif
                @if($patientdata->motor_weakness == 1)
                  <h2 class="text-danger"><strong>Motor Weakness</strong></h2>
                @endif


              </div>
            </div>

          </div>
        </div>
        <div class="col-sm-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>Blood Test Record</strong></h3>
            </div>
            <div class="panel-body">
              <div class='table-responsive'>
                <table class='table  table-bordered'>
                  <thead>
                    <th>State</th>
                    <th>INR</th>
                    <th>20minWBCT</th>
                    <th>WBC</th>
                    <th>Hct</th>
                    <th>Platelet</th>
                    <th>blood</th>
                    <th>RBC</th>
                    <th>Cretinine</th>
                    <th>DateTime</th>
                  </thead>
                  <tbody>
                    @foreach($bloodtestdata as $blood )
                      <tr>
                        <td>
                          @if($blood->state==1)
                            CBC,PT,INR, 20 min WBCT,BUN, Creatinine , UA
                          @endif
                          @if($blood->state==5)
                          Repeat CBC,PT,INR,20 min WBCT q 4 hr for 3 time
                          @endif
                          @if($blood->state==2)
                          CBC,PT,INR,20 min WBCT q 6 hr for 2 time (6,12)
                          @endif
                          @if($blood->state==3)
                          D/C CBC,PT,INR,20 min WBCT,Creatinine Once daily for 3 days(24-36,48-60,72-84)
                          @endif

                        </td>
                        <td {{ ($blood->INR >= 1.20 ? 'class="text-danger"': 'class="text-success"') }}>
                          {{ $blood->INR ==0 ? '' : $blood->INR }}
                        </td>
                        <td {{ ($blood->WBCT == 0 ? 'class="text-danger"': 'class="text-success"') }}>
                          {{ $blood->WBCT == '1' ? 'Clotted' : 'Unclotted' }}
                        </td>
                        <td>
                          {{ $blood->WBC == 0 ? '' : $blood->WBC }}
                        </td>
                        <td>
                          {{ $blood->Hct == 0 ? '' : $blood->Hct }}
                        </td>
                        <td {{ ($blood->Platelet < 50000 ? 'class="text-danger"': 'class="text-success"') }}>
                          {{ $blood->Platelet == 0 ? '' : $blood->Platelet }}
                        </td>
                        <td>
                          {{ $blood->Blood == 0 ? '' : $blood->Blood}}
                        </td>
                        <td>
                          {{ $blood->RBC == 0 ? '' : $blood->RBC}}
                        </td>
                        <td>
                          {{ $blood->Cretinine  == 0 ? '' : $blood->Cretinine}}
                        </td>
                        <td>
                          {{ $blood->created_at }}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>


            </div>

          </div>

          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>Motor weakness Check Record</strong></h3>
            </div>
            <div class="panel-body">
              <div class='table-responsive'>
                <table class='table  table-bordered'>
                  <thead>
                    <th>State</th>
                    <th>Muscle weakness</th>
                    <th>Ptosis</th>
                    <th>Dysarthria</th>
                    <th>DateTime</th>
                  </thead>
                  <tbody>
                    @foreach ($observedata as $ob)
                      <tr>
                        <td>
                          ({{$ob->state}})
                        @if($ob->state == 1)
                          Observe motor weakness q 1 hr for 24 hr
                        @endif
                        @if($ob->state == 4)
                          Observe motor weakness q 1 hr for 12 hr
                        @endif
                        @if($ob->state == 8)
                          At 12 hr, any motor weakness
                        @endif
                        </td>
                        <td {{ $ob->Muscle_weakness == 1 ? 'class="text-danger"' : 'class="text-success"' }} >{{ $ob->Muscle_weakness == 1 ? 'Yes' : 'No' }}</td>
                        <td {{ $ob->Ptosis == 1 ? 'class="text-danger"' : 'class="text-success"' }}>{{ $ob->Ptosis == 1 ? 'Yes' : 'No' }}</td>
                        <td {{ $ob->Dysarthria == 1 ? 'class="text-danger"' : 'class="text-success"' }}>{{ $ob->Dysarthria == 1 ? 'Yes' : 'No' }}</td>
                        <td >{{ $ob->created_at }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
        <div class="col-sm-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>Treatment Record</strong></h3>
            </div>
            <div class="panel-body">
              <div class='table-responsive'>
                <table class='table table-striped table-bordered table-hover table-condensed'>
                  <thead>
                    <tr>
                      <th>Treatments log</th>
                      <th>Snake</th>
                      <th>systemic bleeding</th>
                      <th>respiratory failure</th>
                      <th>motor weakness</th>
                      <th>DateTime</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($treatmentlog as $log)
                        <tr>
                          <td>
                            {{ $log->log_text }}
                          </td>
                          <td>
                            @if ($log->snake_type==1)
                              งูแมวเซา
                            @endif
                            @if ($log->snake_type==2)
                              งูเขียวหางไหม้
                            @endif
                            @if ($log->snake_type==3)
                              งูกะปะ
                            @endif
                            @if ($log->snake_type==4)
                              งูเห่า
                            @endif
                            @if ($log->snake_type==5)
                              งูจงอาง
                            @endif
                            @if ($log->snake_type==6)
                              งูสามเหลี่ยม
                            @endif
                            @if ($log->snake_type==7)
                              งูทับสมิงคลา
                            @endif
                            @if ($log->snake_type==8)
                              งูไม่ทราบชนิด
                            @endif

                          </td>
                          <td>
                            {{ $log->systemic_bleeding == 1 ? 'Yes' : 'No' }}
                          </td>
                          <td>
                            {{ $log->respiratory_failure == 1 ? 'Yes' : 'No' }}
                          </td>
                          <td>
                            {{ $log->motor_weakness == 1 ? 'Yes' : 'No' }}
                          </td>
                          <td>
                            {{ $log->created_at }}
                          </td>
                        </tr>
                        @endforeach
                  </tbody>
                </table>
              </div>
              <hr>
              @if(!empty($patientdata->consult_case))
                <h3 class="text-danger"> Consult case : {{ $patientdata->consult_case }}</h3>
              @endif
            </div>
          </div>
        </div>
      </div><!-- /.box-body -->
      <div class="box-footer">
        <div class="col-sm-12">
          <a href="{{ url('page/patienttable') }}"><button type='button' class='btn btn-lg btn-primary btn-flat'>Back to PatientTable</button></a>
        </div>


      </div>
    </div><!-- /.box -->

  </section><!-- /.content -->
@endsection
@section('customjs')

  @endsection
