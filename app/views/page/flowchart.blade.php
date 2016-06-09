@extends('layout.main')
@section('customcss')

      <script src="{{ url('assets/plugins/flowchart/jquery.scrollTo.min.js') }} "></script>
      <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/svg.js/1.0.1/svg.min.js"></script>
      <script src="{{ url('assets/plugins/flowchart/flowsvg.min.js') }}"></script>

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
            <h3 class="box-title"><strong>Flowchart</strong></h3>
          </div>

          <div class="box-body">
            <div class="col-sm-12 text-center">
              <h3 ></h3>
              <div id="drawing"></div>
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
  @if($patientdata->snake_group == 1 and  $patientdata->state !==7 and $patientdata->state !==9 )
    <script>
  ///////////////////// start flow chart ////////////////////////////////////////////////////////////
    flowSVG.draw(SVG('drawing').size(1000, 1500));
    flowSVG.config({
        interactive: false,
        showButtons: false,
        connectorStrokeWidth: 3,
        connectorLength: 90,
        defaultFontSize: 10,


    });
    flowSVG.shapes(
      [
        {
        label: 'checkGreen1',
        type: 'process',
        text: [
                'การดูแลผู้ป่วยถูก',
                '{{$patientdata->snake_thai_name}}กัด',

            ],

        next: 'checkGreen11',

      },
      {
      label: 'checkGreen11',
      type: 'process',
      text: [
              'CBC,PT,INR, 20 min WBCT',
              'BUN,Creatinine,UA',
          ],
            links: [
              {
                  text: '{{ $patientdata->state == 1 ? '****!!!CURRENT!!!****' : '' }}',
                  url: '',
                  target: ''
              }
          ],


      next: 'indication1',
    },
        {
  label: 'indication1',
  type: 'decision',
  text: [
    'Indication for antivenom',
  ],
  yes: 'checkGreen4',
  no: 'checkGreen2',

  },
  {
  label: 'checkGreen2',
  type: 'process',
  text: [
          'CBC,PT,INR, 20 min WBCT',
          'Q 6 hr for 2 times (6,12)',

      ],
      links: [
        {
            text: '{{ $patientdata->state == 2 ? '****!!!CURRENT!!!****' : '' }}',
            url: '',
            target: ''
        }
    ],

  next: 'indication2',
  },
  {
  label: 'indication2',
  type: 'decision',
  text: [
  'Indication for antivenom',
  ],
  yes: '',
  no: 'checkGreen3'
  },
  {
  label: 'checkGreen3',
  type: 'process',
  text: [
          'D/C CBC,PT,INR,20minWBCT',
          'Creatinine Once daily',
          'for 3 day',
          '(24-36,48-60,72-84)',
      ],
      links: [
        {
            text: '{{ $patientdata->state == 3 ? '****!!!CURRENT!!!****' : '' }}',
            url: '',
            target: ''
        }
    ],

  next: 'indication3',
  },
  {
  label: 'indication3',
  type: 'decision',
  text: [
  'Indication for antivenom',
  ],
  yes: '',
  no: 'canComply'
  },
  {
      label: 'canComply',
      type: 'finish',
      text: [
          'Done'

      ],


  },
  {
  label: 'checkGreen4',
  type: 'process',
  text: [
          'Antivenom for Russell Viper 5 vials',
          'BUN,Creatinine,UA',
      ],
  next: 'indication4',
  },
  {
  label: 'indication4',
  type: 'decision',
  text: [
  'Indication for antivenom',
  ],
  yes: 'canComply2',
  no: ''
  },
  {
      label: 'canComply2',
      type: 'finish',
      text: [
          'Antivenom for',
          'Russell Viper 5 vials',
          'Consult PC',

      ],


  }


      ]

        );
  </script>
  @endif
  @if($patientdata->snake_group == 1 and $patientdata->state==7 or $patientdata->state==8 or $patientdata->state==9)
    <script>
  ///////////////////// start flow chart ////////////////////////////////////////////////////////////
    flowSVG.draw(SVG('drawing').size(900, 1200));
    flowSVG.config({
        interactive: false,
        showButtons: false,
        connectorLength: 80,
        scrollto: true
    });
    flowSVG.shapes(
      [
        {
        label: 'checkGreen2',
        type: 'process',
        text: [
                'Consult PC',
            ],
        next: 'knowTypesnake',
        },{
  label: 'knowTypesnake',
  type: 'decision',
  text: [
    'Know type of snake',
  ],
  yes: 'checkGreen',
  no: ''
  },
  {
  label: 'checkGreen',
  type: 'decision',
  text: [
    'Which type?',
  ],
  yes: 'checkGreen2',
  no: ''
  },
  {
  label: 'checkGreen2',
  type: 'process',
  text: [
          '{{ $patientdata->snake_name }}',
          '{{$patientdata->state_give}} {{$patientdata->snake_name}}',
          '{{$patientdata->state_vials}}',
      ],
  next: 'canComply',
  },
  {
      label: 'canComply',
      type: 'finish',
      text: [
          'ปรึกษาศูนย์พิษวิทยา โทร 1367'

      ],


  }


      ]

        );
  </script>
  @endif
@endsection
