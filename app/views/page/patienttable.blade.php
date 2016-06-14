@extends('layout.main')
@section('customcss')
<!-- DataTables -->
<link rel="stylesheet" href="{{ url('assets/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection
@section('pageheader')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Mahidol Snake Envenomation Support System #6
    </h1>

  </section>
@endsection
@section('maincontent')
  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h2 class="box-title "><strong>Patient Table</strong></h2>
      </div>
      <div class="box-body">
        <div class='table-responsive'>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>National id </th>
                <th >Name</th>
                <th >Snake</th>
                <th>Now State</th>
                <th>Next</th>
                <th>Status</th>
                <th>
                  Create At
                </th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
             @foreach($patientdata as $pdata)
               <tr>
                 <td>{{ $pdata->patient_national_id }}</td>
                 <td width="10%">{{ $pdata->patient_name }}</td>
                 <td >
                   @if ($pdata->snake_type==1)
                     งูแมวเซา
                   @endif
                   @if ($pdata->snake_type==2)
                     งูเขียวหางไหม้
                   @endif
                   @if ($pdata->snake_type==3)
                     งูกะปะ
                   @endif
                   @if ($pdata->snake_type==4)
                     งูเห่า
                   @endif
                   @if ($pdata->snake_type==5)
                     งูจงอาง
                   @endif
                   @if ($pdata->snake_type==6)
                     งูสามเหลี่ยม
                   @endif
                   @if ($pdata->snake_type==7)
                     งูทับสมิงคลา
                   @endif
                   @if ($pdata->snake_type==8)
                     งูไม่ทราบชนิด
                   @endif
                 </td>
                 <td>
                   @if ($pdata->snake_type == 1 or $pdata->snake_type == 2 or $pdata->snake_type == 3)
                     @if($pdata->state == 1)
                      <strong>CBC,PT,INR, 20min WBCT,BUN,Creatinine,UA</strong>
                     @endif
                     @if($pdata->state == 2)
                      <strong>CBC,PT,INR,20 min WBCT q 6 hr for 2 times (6,12) </strong>
                     @endif
                     @if($pdata->state == 3)
                      <strong>D/C CBC,PT,INR, 20 min WBCT, Creatinine
                        <br>Once daily for 3 days(24-36,48-60,72-84)</strong>
                     @endif
                     @if($pdata->state == 4)
                      <strong>Antivenom</strong>
                     @endif
                     @if($pdata->state == 5)
                      <strong>Repeat CBC,PT,INR, 20 min WBCT q 4 hr for 3 time</strong>
                     @endif
                     @if($pdata->state == 6)
                      <strong>Systemic bleeding</strong>
                     @endif
                     @if($pdata->state == 7)
                      <strong>Discordance of data</strong>
                     @endif
                     @if($pdata->state == 8)
                      <strong>Chang Snake type</strong>
                     @endif
                     @if($pdata->state == 9)
                      <strong>Abnormal state</strong>
                     @endif
                     @if($pdata->state == 10)
                      <strong>Done</strong>
                     @endif

                   @endif
                   @if ($pdata->snake_type == 4 or $pdata->snake_type == 5 or $pdata->snake_type == 6 or $pdata->snake_type == 7 )

                     @if($pdata->state == 1)
                      <strong>Observe motor weakness q 1 hr for 24 hr</strong>
                     @endif
                     @if($pdata->state == 4)
                       <strong>Observe motor weakness q 1 hr for 12 hr</strong>
                     @endif
                     @if($pdata->state == 5)
                      <strong>Done</strong>
                     @endif
                     @if($pdata->state == 6)
                      <strong>Consult PC</strong>
                     @endif
                     @if($pdata->state == 7)
                      <strong>Wrong snake type</strong>
                     @endif
                     @if($pdata->state == 8)
                      <strong>At 12 hr,any motor weakness</strong>
                     @endif
                     @if($pdata->state == 0)
                      <strong>Consult PC</strong>
                     @endif


                   @endif
                   ({{ $pdata->state }})
                 </td>
                 <td width="4%">
                   @if ($pdata->nextbloodtest == 0)
                      None
                     @else
                      <div data-countdown="{{ $pdata->nextbloodtest}}"></div>
                   @endif
                 </td>
                 <td>
                   @if($pdata->status == 1)
                     <span class="label label-danger">Consult PC</span>
                   @elseif($pdata->status == 2)
                     <span class="label label-warning">Repeat Bloodtest</span>
                   @elseif($pdata->status == 3)
                     <span class="label label-success">Done</span>
                   @elseif($pdata->status == 4)
                     <span class="label label-info">Repeat Observe</span>
                   @endif
                 </td>
                 <td>
                   {{ $pdata->created_at }}
                 </td>
                 <td ><a href="{{ url("page/overview/$pdata->record_id/$pdata->state") }}" data-toggle="tooltip" data-placement="bottom" title="Overview">
                   <button type="button" class="btn btn-sm btn-info btn-flat">
                     <i class="fa fa-file-text-o"></i>
                   </button></a>
                   <a href="{{ url("page/flowchart/$pdata->record_id") }}" data-toggle="tooltip" data-placement="bottom" title="View flowchart">
                     <button type="button" class="btn btn-sm  btn-default btn-flat">
                       <i class="fa fa-sitemap"></i>
                     </button></a>
                   @if($pdata->status == 2 )
                     <a href="{{ url("page/symptom/$pdata->record_id") }}" data-toggle="tooltip" data-placement="bottom" title="Repeat Bloodtest">
                       <button type="button" class="btn btn-sm btn-warning btn-flat">
                        <i class="fa fa-eyedropper"></i>
                       </button></a>
                   @endif
                   @if($pdata->status == 4 )
                     <a href="{{ url("page/symptom/$pdata->record_id") }}" data-toggle="tooltip" data-placement="bottom" title="Repeat Observe">
                       <button type="button" class="btn btn-sm btn-warning btn-flat">
                         <i class="fa fa-stethoscope"></i>
                       </button></a>
                   @endif
                </td>
               </tr>
             @endforeach

            </tbody>
          </table>

        </div>
        <div class="row">
          <div class="col-sm-12">
            <span class="label label-info"><i class="fa fa-file-text-o"></i> : View Overview</span>
            <span class="label label-default"><i class="fa fa-sitemap"></i> : View FlowChart</span>
            <span class="label label-warning"><i class="fa fa-eyedropper"></i> : Repeat Bloodtest</span>
            <span class="label label-warning"><i class="fa fa-stethoscope"></i> : Repeat Observe</span>
          </div>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->

  </section><!-- /.content -->
@endsection
@section('customjs')



 <script src="{{ url('assets/plugins/countdown/jquery.countdown.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ url('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
  <script>
    $(function () {
      $("#example2").DataTable();
      $('#example1').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true
      });
    });
  </script>

  <script type="text/javascript">
  $('[data-countdown]').each(function() {
   var $this = $(this), finalDate = $(this).data('countdown');
   $this.countdown(finalDate, function(event) {
     $this.html(event.strftime('%D days %H:%M:%S'));
   });
 });
   </script>


@endsection
