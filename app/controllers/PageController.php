<?php

  /**
   *
   */
  class PageController extends Controller
  {

    // Create New treatment  1
    public function getCreatenew()
    {
      return View::make('page.createnew');
    }

    // Confirmation 2
    public function getConfirmation()
    {

      $user_id  =  Session::get('physician_id');
      $patient_national_id  = Session::get('patient_national_id');
      $data = array(
        'physicianData' => Physician::where('user_id','=',$user_id)->first(),
        'patientData' => Patient::where('patient_national_id','=',$patient_national_id)->first()
      );
      return View::make('page.confirmation',$data);
    }

    public function getSymptom($treatmentid)
    {
      $data = array(
        'treatmentdata' => Treatment::where('record_id','=',$treatmentid)->first()
      );
      return View::make('page.symptom',$data);
    }


    public function getConsult($treatmentid)
    {
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('record_id','=',$treatmentid)->first();
      $snakegroup = $treatments->snake_group;
      $state = $treatments->state;

      $data = array(
        'patientdata' => Treatment::join('patient', 'treatmentRecord.patient_id', '=', 'patient.patient_id')
        ->join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
        ->join('state', 'snake.snake_group', '=', 'state.state_snakegroup')
        ->where('treatmentRecord.record_id','=',$treatmentid)
        ->where('state.state_snakegroup','=',$snakegroup)
        ->where('state.state_number','=',$state)->first(),
      );
      return View::make('page.consult',$data);
    }
    public function getManagement($treatmentid)
    {
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('record_id','=',$treatmentid)->first();
      $snakegroup = $treatments->snake_group;
      $state = $treatments->state;

      $data = array(
        'patientdata' => Treatment::join('patient', 'treatmentRecord.patient_id', '=', 'patient.patient_id')
        ->join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
        ->join('state', 'snake.snake_group', '=', 'state.state_snakegroup')
        ->where('treatmentRecord.record_id','=',$treatmentid)
        ->where('state.state_snakegroup','=',$snakegroup)
        ->where('state.state_number','=',$state)->first(),
      );
      return View::make('page.management',$data);
    }

    public function getOverview($treatmentid)
    {
      $data = array(
        'patientdata' => Treatment::join('patient', 'treatmentRecord.patient_id', '=', 'patient.patient_id')
        ->join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
        ->where('treatmentRecord.record_id','=',$treatmentid)->first(),
        'bloodtestdata' => Bloodtest::where('record_id','=',$treatmentid)->get(),
        'observedata' => Observe::where('record_id','=',$treatmentid)->get(),
        'treatmentlog' => Treatmentlog::where('record_id','=',$treatmentid)->get()
      );
      return View::make('page.overview',$data);
    }

    public function getBloodtest($treatmentid)
    {
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('record_id','=',$treatmentid)->first();
      $snakegroup = $treatments->snake_group;
      $state = $treatments->state;

      $data = array(
        'patientdata' => Treatment::join('patient', 'treatmentRecord.patient_id', '=', 'patient.patient_id')
        ->join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
        ->join('state', 'snake.snake_group', '=', 'state.state_snakegroup')
        ->where('treatmentRecord.record_id','=',$treatmentid)
        ->where('state.state_snakegroup','=',$snakegroup)
        ->where('state.state_number','=',$state)->first(),
      );
      return View::make('page.bloodtest',$data);
    }

    public function getObserve($treatmentid)
    {
      $data = array(
        'patientdata' => Treatment::join('patient', 'treatmentRecord.patient_id', '=', 'patient.patient_id')
        ->where('treatmentRecord.record_id','=',$treatmentid)
        ->join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')->first(),
      );
      return View::make('page.motorweaknesstest',$data);
    }

    ///   Patient Table
    public function getPatienttable()
    {
      $data = array(
        'patientdata' => Treatment::join('patient', 'treatmentRecord.patient_id', '=', 'patient.patient_id')
        ->orderBy('treatmentRecord.created_at','desc')->get(),
        'datenow' => date('Y/m/d')
      );
       return View::make('page.patienttable',$data);
    }

    public function getFlowchart($treatmentid)
    {
      $data = array(
        'patientdata' => Treatment::join('patient', 'treatmentRecord.patient_id', '=', 'patient.patient_id')
        ->join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
        ->where('treatmentRecord.record_id','=',$treatmentid)->first(),
      );
      return View::make('page.flowchart',$data);

    }

    public function getFlowchart2($treatmentid)
    {
      $data = array(
        'patientdata' => Treatment::join('patient', 'treatmentRecord.patient_id', '=', 'patient.patient_id')
        ->join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
        ->where('treatmentRecord.record_id','=',$treatmentid)->first(),
      );
      return View::make('page.flowchart2',$data);

    }

  }



 ?>
