<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ url('image/system/logo.png') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>System is Runing</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">NAVIGATION</li>
      <li {{ ( Request::segment(2) == 'patienttable' ? 'class="active"' : '') }}><a href="{{ url('page/patienttable') }}"><i class="fa fa-male"></i> <span>Patient table</span></a></li>
    </ul>
    <ul class="sidebar-menu">
      <li class="header">NOW YOUR STANDING</li>
      <li {{ ( Request::segment(2) == 'confirmation' ? 'class="active animated infinite flash"' : '') }}><a href="#"><i {{ ( Request::segment(2) == 'confirmation' ? 'class="fa fa-circle-o text-aqua"' : 'class="fa fa-circle-o text-red"') }}></i> <span>Confirmation of data</span></a></li>
      <li {{ ( Request::segment(2) == 'symptom' ? 'class="active animated infinite flash"' : '') }}><a href="#"><i {{ ( Request::segment(2) == 'symptom' ? 'class="fa fa-circle-o text-aqua"' : 'class="fa fa-circle-o text-red"') }} ></i> <span>Symptom Check</span></a></li>
      <li {{ ( Request::segment(2) == 'bloodtest' ? 'class="active animated infinite flash"' : '') }}><a href="#"><i {{ ( Request::segment(2) == 'bloodtest' ? 'class="fa fa-circle-o text-aqua"' : 'class="fa fa-circle-o text-red"') }} ></i> <span>BloodTest</span></a></li>
      <li {{ ( Request::segment(2) == 'management' || Request::segment(2) == 'managementneurotoxic'   ? 'class="active animated infinite flash"' : '') }}><a href="#"><i {{ ( Request::segment(2) == 'management' || Request::segment(2) == 'managementneurotoxic'  ? 'class="fa fa-circle-o text-aqua"' : 'class="fa fa-circle-o text-red"') }} ></i> <span>Management</span></a></li>
      <li {{ ( Request::segment(2) == 'consult' || Request::segment(2) == 'consultweakness' || Request::segment(2) == 'consultpc' ? 'class="active animated infinite flash"' : '') }}><a href="#"><i {{ ( Request::segment(2) == 'consult' || Request::segment(2) == 'consultweakness' || Request::segment(2) =='consultpc' ? 'class="fa fa-circle-o text-aqua"' : 'class="fa fa-circle-o text-red"') }} ></i> <span>Consult PC</span></a></li>
      <li {{ ( Request::segment(2) == 'overview' ? 'class="active animated infinite flash"' : '') }}><a href="#"><i {{ ( Request::segment(2) == 'overview' ? 'class="fa fa-circle-o text-aqua"' : 'class="fa fa-circle-o text-red"') }} ></i> <span>Overview</span></a></li>
      <li {{ ( Request::segment(2) == 'flowchart' ? 'class="active animated infinite flash"' : '') }}><a href="#"><i {{ ( Request::segment(2) == 'flowchart' ? 'class="fa fa-circle-o text-aqua"' : 'class="fa fa-circle-o text-red"') }} ></i> <span>Flowchart</span></a></li>
        <!--
      <li class="header">Infomation</li>

      <li class="active"><a href="#"><span class="text-primary">Physician Info</span>
        <br> ID :  {{ Session::get('physicianID'); }}
        <br> Name : {{ Session::get('physicianName'); }}

      </a></li>
      <li class="active"><a href="#"><span class="text-warning">Patient Info</span>
        <br> ID : {{ Session::get('patient_cardID'); }}
        <br> Name : {{ Session::get('patient_name'); }}
        <br> Status :  Treatment
      </a></li>
    -->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
