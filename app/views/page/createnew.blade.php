<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mahidol Snake Envenomation
Support System| Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }} ">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('assets/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('assets/dist/css/skins/_all-skins.min.css') }} ">
    <link rel="stylesheet" href="{{ url('assets/plugins/animate/animate.css') }} ">
    <link href="{{ url('assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page" >
    <div class="login-box" >
      <div class="login-logo">
        <img src="{{ url('image/system/logo.png') }}" width="100" height="100" alt="" /><br>
        Mahidol Snake Envenomation
Support System
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Create new treatment</p>
        <form action="{{ url('function/createnew') }}" method="post">
          <div class="form-group has-feedback">
            <div class="input-group">
              <span class="input-group-addon">เลข ว.</span>
              <input type="text" class="form-control" name="physician_id" placeholder="Physician ID" required>
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

          </div>
          <div class="form-group has-feedback">
            <div class="input-group">
            <span class="input-group-addon">เลขบัตรประชาชน</span>
            <input type="text" class="form-control" name="patient_national_id" placeholder="Patient national ID" minlength="13"  maxlength="13"  required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-facebook btn-block btn-flat">Check</button>
            </div><!-- /.col -->
          </div>
          <div class="row">
            <div class="col-xs-12">
              <hr>
              <a href="{{ url('page/patienttable') }}">
              <button type="button" class="btn btn-info btn-block btn-flat">Go to Patient Table </button></a>
            </div><!-- /.col -->
          </div>
        </form>



      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
    <!-- jQuery 2.1.4 -->
    <script src="{{ url('assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ url('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ url('assets/plugins/fastclick/fastclick.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('assets/dist/js/app.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('assets/dist/js/demo.js') }}"></script>
    <script src="{{ url('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>




    @if(Session::has('alertAut'))
        <script>
          $(document).ready(function() {

              $(window).load(function(){
                         swal({
                 title: "Alert!",
                 text: '{{ Session::get('alertAut') }}',
                 type: "warning",
                 confirmButtonText: "ลองอีกใหม่"
             });
                       });

            });
        </script>
      @endif

    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>


  </body>
</html>
