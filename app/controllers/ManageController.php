<?php
  /**
   *
   */
   class ManageController extends Controller
  {
    /* Action form page/createnew  and return to page/confirmation
    */
    public function postCreatenew()
    {
      $inputs = Input::all();
      $checkphysician = Physician::where('physician_id','=',$inputs['physician_id'])->first();
      $checkpatient = Patient::where('patient_national_id','=',$inputs['patient_national_id'])->first();
      $patid = $inputs['patient_national_id'];
      if (is_numeric($patid)) {
        if (is_object($checkphysician)) {
          Session::put('physician_id', $checkphysician->user_id);
        }else {
          $create = new Physician();
          $create->physician_id = $inputs['physician_id'];
          $create->save();
          $insert_id = $create->user_id;
          Session::put('physician_id', $create->user_id);
        }
        if (is_object($checkpatient)) {
          Session::put('patient_national_id',$checkpatient->patient_national_id);
        }else {
          $createpat = new Patient();
          $createpat->patient_national_id = $inputs['patient_national_id'];
          $createpat->save();
          $insert_idpat = $createpat->patient_national_id;
          Session::put('patient_national_id',$insert_idpat);
        }
        return Redirect::to('page/confirmation');
      }else{
        return Redirect::to('page/createnew')->with('alertAut', 'รหัสบัตรประชาชนไม่ถูกต้อง กรอกเฉพาะตัวเลขเท่านั้น');
      }

    }
    /* Action form page/confirmation  and return next to page/symptomCheck
    */
    public function postConfirmdata()
    {
      Session::flush();
      $inputs = Input::all();

      $physiciandata = Physician::where('physician_id','=',$inputs['physicianID'])->first();
      if (is_object($physiciandata)) {
        $physiciandata->physician_id = $inputs['physicianID'];
        $physiciandata->physician_name = $inputs['physicianname'];
        $physiciandata->save();
        $physician_id = $physiciandata->user_id;

      }else {
        $physiciannew = new Physician();
        $physiciannew->physician_id = $inputs['physicianID'];
        $physiciannew->physician_name = $inputs['physicianname'];
        $physiciannew->save();
        $physician_id = $physiciandata->user_id;

      }

      $patientdata = Patient::where('patient_national_id','=',$inputs['patient_national_id'])->first();
      if (is_object($patientdata)) {
        $patientdata->patient_national_id = $inputs['patient_national_id'];
        $patientdata->patient_name = $inputs['patient_name'];
        $patientdata->patient_gender = $inputs['patientGender'];
        $patientdata->patient_ageY = $inputs['PatientAgeY'];
        $patientdata->patient_ageM = $inputs['PatientAgeM'];
        $patientdata->patient_ageD = $inputs['PatientAgeD'];
        $patientdata->save();
        $patient_id = $patientdata->patient_id ;

      }else {
        $patientnew = new Patient();
        $patientnew->patient_national_id = $inputs['patient_national_id'];
        $patientnew->patient_name = $inputs['patient_name'];
        $patientnew->patient_gender = $inputs['patientGender'];
        $patientnew->patient_ageY = $inputs['PatientAgeY'];
        $patientnew->patient_ageM = $inputs['PatientAgeM'];
        $patientnew->patient_ageD = $inputs['PatientAgeD'];
        $patientnew->save();
        $patient_id = $patientdata->patient_id ;
      }


      $treatment = new Treatment();
      $treatment->patient_id = $patientdata->patient_id;
      $treatment->physician_id = $physiciandata->user_id;
      $treatment->incident_date = $inputs['incident_date'];
      $treatment->incident_time = $inputs['incident_time'];
      $treatment->incident_district = $inputs['incident_district'];
      $treatment->incident_province = $inputs['incident_province'];
      $treatment->save();
      $treatmentid = $treatment->record_id;


      return Redirect::to("page/symptom/$treatmentid/0");
    }

    /* Action form page/symptom and return next to function  stateCheck($treatmentid,$case)
      "Record data and update State for Snake_type=8(UnknownSnake)"

      Send Symtom to Check State .
    */
    public function postSymptom()
    {
      $observe = new Observe();
      $inputs = Input::all();
      $case  = $inputs['case'];
      $id  = $inputs['treatmentid'];
      $treatments = Treatment::where('record_id','=',$id)->first();
      if (is_object($treatments)) {
        $treatments->systemic_bleeding = $inputs['systemicB'];
        $treatments->respiratory_failure = $inputs['respiratoryF'];
        if($inputs['progressionweakness'] == 1) {
          $treatments->motor_weakness = 1;
          $treatments->progression_weakness = $inputs['progressionweakness'];
        }elseif($inputs['motorweakness'] == 0) {
          $treatments->motor_weakness = $inputs['motorweakness'];
          $treatments->progression_weakness = 0;
        }else{
          $treatments->motor_weakness = $inputs['motorweakness'];
          $treatments->progression_weakness = $inputs['progressionweakness'];
        }
        $treatments->snake_type = $inputs['snaketype'];
        $treatments->save();
        $treatmentid = $id;
        if($inputs['snaketype']==8){
          $treatments->staterepeat = 1 ;
          $treatments->save();
          $observe->record_id = $id;
          $observe->Muscle_weakness = $inputs['motorweakness'];
          $observe->state = 1;
          $observe->save();
        }
        return $this->stateCheck($treatmentid,$case);
      }
    }
    public function postSymptom2()
    {
      $inputs = Input::all();
      $case = 0;
      $id  = $inputs['treatmentid'];
      $treatments = Treatment::where('record_id','=',$id)->first();
      if (is_object($treatments)) {
        if($inputs['Localedema'] == 1 and $inputs['locked_jaw'] == 1) {
          $treatments->localedema = 1;
          $treatments->locked_jaw = 1;
          $treatments->indoor = 0 ;
          $treatments->snake_type = 5;
          $treatments->save();
          $treatmentid = $id;
          return $this->stateCheck($treatmentid,$case);
        }elseif($inputs['Localedema'] == 1 and $inputs['locked_jaw'] == 0) {
          $treatments->localedema = 1;
          $treatments->locked_jaw = 1;
          $treatments->indoor = 0 ;
          $treatments->snake_type = 4;
          $treatments->save();
          $treatmentid = $id;
          return $this->stateCheck($treatmentid,$case);
        }elseif($inputs['Localedema'] == 0 and $inputs['indoor'] == 1) {
          $treatments->localedema = 1;
          $treatments->locked_jaw = 1;
          $treatments->indoor = 0 ;
          $treatments->snake_type = 7;
          $treatments->save();
          $treatmentid = $id;
          return $this->stateCheck($treatmentid,$case);
        }elseif($inputs['Localedema'] == 0 and $inputs['indoor'] == 0) {
          $treatments->localedema = 1;
          $treatments->locked_jaw = 1;
          $treatments->indoor = 0 ;
          $treatments->snake_type = 8;
          $treatments->state = 4;
          $treatments->save();
          $treatmentid = $id;
          return Redirect::to("page/consult/$treatmentid");
        }
      }
    }

    public function postSymptom3()
    {
      $inputs = Input::all();
      $case = 0;
      $id  = $inputs['treatmentid'];
      $treatments = Treatment::where('record_id','=',$id)->first();
      if (is_object($treatments)) {
        if($inputs['Acute_renal'] == 1) {
          $treatments->acute_renal = 1;
          $treatments->snake_type = 1;
          $treatments->save();
          $treatmentid = $id;
          return $this->stateCheck($treatmentid,$case);
        }elseif($inputs['Acute_renal'] == 0 and $inputs['Localedema'] == 0) {
          $treatments->snake_type = 1;
          $treatments->save();
          $treatmentid = $id;
          return $this->stateCheck($treatmentid,$case);
        }elseif($inputs['Acute_renal'] == 0 and $inputs['Localedema'] == 1) {
          $treatments->localedema = 1;
          $treatments->snake_type = 8;
          $treatments->state = 6;
          $treatments->save();
          $treatmentid = $id;
          return Redirect::to("page/consult/$treatmentid");
          return $this->stateCheck($treatmentid,$case);
        }
      }
    }
    /* Check current State And Check symtom
    */
    public function stateCheck($treatmentid,$case)
    {
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('treatmentRecord.record_id','=',$treatmentid)->first();
      $treatmentid = $treatments->record_id;
      $log = Treatmentlog::where('record_id','=',$treatmentid)->first();
      //// SNAKE GROUP 1 Hematotoxic /////////////
      if ($treatments->snake_group == 1) {
        if (is_object($log) and $log->snake_type != 8) {
          if ($log->snake_type != $treatments->snake_type) {
            $treatments->state = 8;
            $treatments->status = 1;
            $treatments->save();
            return Redirect::to("page/consult/$treatmentid");
          }
        }
        if ($treatments->systemic_bleeding == 1 ){
            $treatments->state = 6;
            $treatments->status = 1;
            $treatments->save();
            return Redirect::to("page/consult/$treatmentid");
          }elseif ($treatments->respiratory_failure == 1 ) {
            $treatments->state = 7;
            $treatments->status = 1;
            $treatments->save();
            return Redirect::to("page/consult/$treatmentid");
          }elseif ($treatments->motor_weakness == 1 ) {
            $treatments->state = 7;
            $treatments->status = 1;
            $treatments->save();
            return Redirect::to("page/consult/$treatmentid");
          }else{
            if (!is_object($log)) {
              $treatments->state = 1;
            }
            $treatments->status = 2;
            $treatments->save();
            return Redirect::to("page/bloodtest/$treatmentid");
          }
        }

        //// SNAKE GROUP 2 nuro /////////////
        if ($treatments->snake_group == 2) {
          if (is_object($log)){
            if ($log->snake_type != $treatments->snake_type) {
              $treatments->state = 8;
              $treatments->status = 1;
              $treatments->save();
              return Redirect::to("page/consult/$treatmentid");
            }
          }
          if ($treatments->systemic_bleeding == 1 ){
              $treatments->state = 9;
              $treatments->status = 1;
              $treatments->save();
              return Redirect::to("page/consult/$treatmentid");
            }elseif ($treatments->respiratory_failure == 1 ) {
              if ($treatments->state == 4) {
                $treatments->state = 10;
                $treatments->status = 1;
                $treatments->save();
                return Redirect::to("page/consult/$treatmentid");
              }else{
                $treatments->state = 7;
                $treatments->status = 1;
                $treatments->save();
                return Redirect::to("page/consult/$treatmentid");
              }
            }else{
              if (!is_object($log)) {
                if ($treatments->snake_type == 4 or $treatments->snake_type == 5) {
                    $treatments->state = 1;
                }else{ // snake 6 - 7
                    $treatments->state = 3;
                }

              }
              $treatments->status = 4;
              $treatments->save();
              $motorweakness = $treatments->motor_weakness;
              $progressionweakness = $treatments->progression_weakness;
              $state = $treatments->state;
              return $this->observeRecord($treatmentid,$motorweakness,$progressionweakness,$state);
            }
          }
          //// SNAKE GROUP 3 nuro /////////////
          if ($treatments->snake_group == 3) {
            if ($treatments->systemic_bleeding == 1 ){
                $treatments->state = 1;
                $treatments->status = 1;
                $treatments->save();
                return Redirect::to("page/consult/$treatmentid");
              }elseif ($treatments->respiratory_failure == 1 ){
                $treatments->state = 5;
                $treatments->status = 1;
                $treatments->save();
                return Redirect::to("page/consult/$treatmentid");
              }elseif ($treatments->motor_weakness == 1 ) {
                return Redirect::to("page/symptom2/$treatmentid");
              }else{
                if (!is_object($log)){
                  $treatments->state = 2;
                  $treatments->state2 = 3;
                  $treatments->status = 5;
                  $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
                  $treatments->statetime2 = date("Y/m/d H:i:s", mktime(date("H")+6, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
                  $treatments->save();
                  return Redirect::to("page/bloodtest/$treatmentid");
                }else{
                  if ($case==1) {
                    return Redirect::to("page/bloodtest/$treatmentid");
                  }
                  if ($case==2) {
                    $motorweakness = $treatments->motor_weakness;
                    $progressionweakness = $treatments->progression_weakness;
                    $state = $treatments->state;
                    return $this->observeRecord($treatmentid,$motorweakness,$progressionweakness,$state);
                  }
                }
              }
            }

    }


    public function postBloodrecord()
    {
      $inputs =  Input::all();
      $id = $inputs['treatmentid'];
      $bloodtest = new Bloodtest();
      $bloodtest->record_id = $id;
      $bloodtest->INR = $inputs['INR'];
      $bloodtest->WBCT = $inputs['WBCT'];
      $bloodtest->WBC = $inputs['WBC'];
      $bloodtest->Hct = $inputs['Hct'];
      $bloodtest->Platelet = $inputs['Platelet'];
      $bloodtest->save();
      $bloodid = $bloodtest->test_id;
      $treatmentid = $bloodtest->record_id;
      return $this->bloodCheck($bloodid,$treatmentid);
    }


    public function bloodCheck($bloodid,$treatmentid)
    {

      $bloodtest = Bloodtest::where('test_id','=',$bloodid)->first();
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('record_id','=',$treatmentid)->first();
      if ($treatments->snake_type==8) {
        $repeattime = $treatments->staterepeat2;
      }else {
        $repeattime = $treatments->staterepeat;
      }
      if ($bloodtest->Platelet == 0) {
        $Platelet = 150000;
      }else {
        $Platelet = $bloodtest->Platelet;
      }
      if ($bloodtest->INR == 0) {
        $INR = 1.1;
      }else {
        $INR = $bloodtest->INR;
      }

      if ($treatments->snake_group == 1) {
        if ($treatments->state == 1){
          if ($Platelet < 100000 or $INR >= 1.2 or $bloodtest->WBCT == 0) {
            $treatments->state = 4;
            $treatments->staterepeat = 0 ;
            $treatments->save();
            $bloodtest->state = 1;
            $bloodtest->save();
            return Redirect::to("page/management/$treatmentid");
          }else{
            $treatments->state = 2;
            $treatments->status = 2;
            $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+6, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
            $treatments->save();
            $bloodtest->state = 1;
            $bloodtest->save();
            return Redirect::to("page/management/$treatmentid");
          }
        }

        if ($treatments->state == 2){
          if ($Platelet < 100000 or $INR >= 1.2 or $bloodtest->WBCT == 0) {
            $treatments->state = 4;
            $treatments->status = 2;
            $treatments->staterepeat = 0 ;
            $treatments->save();
            $bloodtest->state = 2;
            $bloodtest->save();
            return Redirect::to("page/management/$treatmentid");
          }else{
            if ($repeattime == 1) {
              $treatments->state = 3;
              $treatments->staterepeat = 0 ;
              $treatments->statetime = 0;
              $treatments->save();
              $bloodtest->state = 2;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }else {
              $treatments->staterepeat = $repeattime+1 ;
              $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+6, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
              $treatments->save();
              $bloodtest->state = 2;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }
          }
        }

        if ($treatments->state == 3){
          if ($Platelet < 100000 or $INR >= 1.2 or $bloodtest->WBCT == 0) {
            $treatmentlog = Treatmentlog::where('record_id','=',$treatmentid)
            ->where('state','=','4')
            ->first();
            if(!empty($treatmentlog)){
                 $treatments->state = 9;
                 $treatments->status = 1;
                 $treatments->staterepeat = 0 ;
                 $treatments->statetime = 0;
                 $treatments->save();
                 $bloodtest->state = 3;
                 $bloodtest->save();
                 return Redirect::to("page/consult/$treatmentid");
               }else{
                 $treatments->state = 4;
                 $treatments->staterepeat = 0 ;
                 $treatments->status = 2;
                 $treatments->save();
                 $bloodtest->state = 3;
                 $bloodtest->save();
                 return Redirect::to("page/management/$treatmentid");
               }
          }else{
            if ($repeattime == 2) {
              $treatments->state = 10;
              $treatments->staterepeat = 0 ;
              $treatments->statetime = 0 ;
              $treatments->status = 3;
              $treatments->save();
              $bloodtest->state = 3;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }else {
              $treatments->staterepeat = $repeattime+1 ;
              $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+0, date("i")+0, date("s")+0, date("m")+0  , date("d")+1, date("Y")+0));
              $treatments->save();
              $bloodtest->state = 3;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }
          }
        }

        if ($treatments->state == 5){
          if ($Platelet < 100000 or $INR >= 1.2 or $bloodtest->WBCT == 0) {
            $treatments->state = 11;
            $treatments->status = 1;
            $treatments->staterepeat = 0 ;
            $treatments->save();
            $bloodtest->state = 5;
            $bloodtest->save();
            return Redirect::to("page/consult/$treatmentid");
          }else{
            if ($repeattime == 2) {
              $treatments->state = 3;
              $treatments->staterepeat = 0 ;
              $treatments->statetime = 0;
              $treatments->save();
              $bloodtest->state = 5;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }else {
              $treatments->staterepeat = $repeattime+1 ;
              $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+4, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
              $treatments->save();
              $bloodtest->state = 5;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }
          }
        }

      }
      if ($treatments->snake_group == 3) {
        if ($treatments->state2 == 3){
          if ($Platelet < 100000 or $INR >= 1.2 or $bloodtest->WBCT == 0){
            $treatments->staterepeat = 0 ;
            $treatments->statetime = 0 ;
            $treatments->state = 1;
            $treatments->save();
            $bloodtest->state = 3;
            $bloodtest->save();
            return Redirect::to("page/symptom3/$treatmentid");
          }else{
            if ($repeattime == 4) {
              $treatments->state = 7;
              $treatments->state2 = 7;
              $treatments->staterepeat2 = 0;
              $treatments->statetime2 = date("Y/m/d H:i:s", mktime(date("H")+0, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
              $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+0, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
              $treatments->status = 2;
              $treatments->save();
              $bloodtest->state = 3;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }else {
              $treatments->staterepeat2 = $repeattime+1;
              $treatments->statetime2 = date("Y/m/d H:i:s", mktime(date("H")+6, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
              $treatments->save();
              $bloodtest->state = 3;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }
          }
        }
        if ($treatments->state == 7){
          if ($Platelet < 100000 or $INR >= 1.2 or $bloodtest->WBCT == 0){
            $treatments->staterepeat = 0 ;
            $treatments->statetime = 0 ;
            $treatments->state = 1;
            $treatments->save();
            $bloodtest->state = 3;
            $bloodtest->save();
            return Redirect::to("page/symptom3/$treatmentid");
          }else{
            if ($repeattime == 1) {
              $treatments->state = 8;
              $treatments->staterepeat2 = 0;
              $treatments->staterepeat = 0;
              $treatments->statetime2 = date("Y/m/d H:i:s", mktime(date("H")+0, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
              $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+0, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
              $treatments->status = 3;
              $treatments->save();
              $bloodtest->state = 7;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }else{
              $treatments->staterepeat2 = $repeattime+1;
              $treatments->statetime2 = date("Y/m/d H:i:s", mktime(date("H")+48, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
              $treatments->save();
              $bloodtest->state = 7;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }
          }
        }
      }

    }

    public function observeRecord($treatmentid,$motorweakness,$progressionweakness,$state)
    {
      $log = Treatmentlog::where('record_id','=',$treatmentid)->first();
      $observe = new Observe();
      $observe->record_id = $treatmentid;
      if (!is_object($log)) {
        $observe->state = 0;
      }else{
        $observe->state = $state;
      }
      $observe->Muscle_weakness = $motorweakness;
      $observe->progression_weakness = $progressionweakness;
      $observe->save();
      $observeid = $observe->ob_id;
      $treatmentid = $observe->record_id;
     return $this->observeCheck($observeid,$treatmentid);
    }


    public function observeCheck($observeid,$treatmentid)
    {
      $log = Treatmentlog::where('record_id','=',$treatmentid)->first();
      $observe = Observe::where('ob_id','=',$observeid)->first();
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('record_id','=',$treatmentid)->first();
      $repeattime = $treatments->staterepeat;
      if ($treatments->snake_group == 2){
        if ($treatments->state == 1){
          if ($observe->Muscle_weakness == 1 or $observe->progression_weakness == 1){
              $treatments->state = 3;
              $treatments->status = 4;
              $treatments->staterepeat = 0 ;
              $treatments->save();
              return Redirect::to("page/management/$treatmentid");
            }else {
              if ($repeattime == 23){
                $treatments->state = 6;
                $treatments->status = 3;
                $treatments->staterepeat = 0 ;
                $treatments->statetime = 0;
                $treatments->save();
                $observe->state = 1;
                $observe->save();
                return Redirect::to("page/management/$treatmentid");
              }else {
                if (!is_object($log)) {
                  $treatments->staterepeat = 0 ;
                }else{
                  $treatments->staterepeat = $repeattime+1 ;
                }
                $treatments->status = 4;
                $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
                $treatments->save();
                $observe->state = 1;
                $observe->save();
                return Redirect::to("page/management/$treatmentid");
              }
            }
          }
          if ($treatments->state == 4){
            if ($observe->Muscle_weakness == 1 and $observe->progression_weakness == 1){
                $treatments->state = 5;
                $treatments->status = 1;
                $treatments->staterepeat = 0 ;
                $treatments->statetime = 0 ;
                $treatments->save();
                return Redirect::to("page/consult/$treatmentid");
              }elseif ($observe->Muscle_weakness == 1 and $observe->progression_weakness == 0) {
                if ($repeattime == 11){
                  if ($observe->Muscle_weakness == 1) {
                    $treatments->state = 5;
                    $treatments->status = 1;
                    $treatments->staterepeat = 0 ;
                    $treatments->statetime = 0 ;
                    $treatments->save();
                    return Redirect::to("page/consult/$treatmentid");
                  }else{
                    $treatments->state = 6;
                    $treatments->status = 3;
                    $treatments->staterepeat = 0 ;
                    $treatments->statetime = 0;
                    $treatments->save();
                    $observe->state = 1;
                    $observe->save();
                    return Redirect::to("page/management/$treatmentid");
                  }
                }else{
                  if (!is_object($log)) {
                    $treatments->staterepeat = 0 ;
                  }else{
                    $treatments->staterepeat = $repeattime+1 ;
                  }
                  $treatments->status = 4;
                  $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
                  $treatments->save();
                  $observe->state = 4;
                  $observe->save();
                  return Redirect::to("page/management/$treatmentid");
                }
              }else{
                if ($repeattime == 11){
                  if ($observe->Muscle_weakness == 1) {
                    $treatments->state = 5;
                    $treatments->status = 1;
                    $treatments->staterepeat = 0 ;
                    $treatments->statetime = 0 ;
                    $treatments->save();
                    return Redirect::to("page/consult/$treatmentid");
                  }else{
                    $treatments->state = 6;
                    $treatments->status = 3;
                    $treatments->staterepeat = 0 ;
                    $treatments->statetime = 0;
                    $treatments->save();
                    $observe->state = 1;
                    $observe->save();
                    return Redirect::to("page/management/$treatmentid");
                  }
                }else {
                  if (!is_object($log)) {
                    $treatments->staterepeat = 0 ;
                  }else{
                    $treatments->staterepeat = $repeattime+1 ;
                  }
                  $treatments->status = 4;
                  $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
                  $treatments->save();
                  $observe->state = 4;
                  $observe->save();
                  return Redirect::to("page/management/$treatmentid");
                }
              }
            }
          if ($treatments->state == 3){
                  $treatments->status = 4;
                  $treatments->staterepeat = 0 ;
                  $treatments->statetime = 0;
                  $treatments->save();
                  $observe->state = 3;
                  $observe->save();
                  return Redirect::to("page/management/$treatmentid");
          }
        }if ($treatments->snake_group == 3){
          if ($treatments->state == 2){
            if ($observe->Muscle_weakness == 1 and $observe->progression_weakness == 0){
                return Redirect::to("page/symptom2/$treatmentid");
              }else {
                if ($repeattime == 24){
                  $treatments->state = 8;
                  $treatments->status = 3;
                  $treatments->staterepeat = 0 ;
                  $treatments->statetime = 0;
                  $treatments->save();
                  $observe->state = 3;
                  $observe->save();
                  return Redirect::to("page/management/$treatmentid");
                }else {
                  if (!is_object($log)) {
                    $treatments->staterepeat = 0 ;
                  }else{
                    $treatments->staterepeat = $repeattime+1;
                  }
                  $treatments->status = 5;
                  $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
                  $treatments->save();
                  $observe->state = 1;
                  $observe->save();
                  return Redirect::to("page/management/$treatmentid");
                }
              }
            }
        }
      }



    //// Confirm //////////////////////
    public function postConfirmconsult()
    {
      $inputs = Input::all();
      $id = $inputs['treatmentid'];
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('record_id','=',$id)->first();
      if ($treatments->snake_group == 1) {
        $treatments->consult_case = $inputs['consult'];
        $treatments->statetime = 0;
        $treatments->status = 1;
        $treatments->save();

        $treatmentslog = new Treatmentlog();
        $treatmentslog->record_id = $id;
        $treatmentslog->state = $inputs['state'];
        $treatmentslog->log_text = $inputs['logtext'];
        $treatmentslog->snake_type = $inputs['snaketype'];
        $treatmentslog->systemic_bleeding = $inputs['systemic_bleeding'];
        $treatmentslog->respiratory_failure = $inputs['respiratory_failure'];
        $treatmentslog->motor_weakness = $inputs['motor_weakness'];
        $treatmentslog->save();
        return Redirect::to('page/patienttable');
      }

      if ($treatments->snake_group == 2) {
        if ($treatments->state == 7 or $treatments->state == 2) {
          $treatments->state = 4;
          $treatments->respiratory_failure = 0;
          $treatments->staterepeat = 0;
          $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
          $treatments->status = 4;
          $treatments->save();
        }else{
          $treatments->consult_case = $inputs['consult'];
          $treatments->statetime = 0;
          $treatments->status = 1;
          $treatments->save();
        }
        $treatmentslog = new Treatmentlog();
        $treatmentslog->record_id = $id;
        $treatmentslog->state = $inputs['state'];
        $treatmentslog->log_text = $inputs['logtext'];
        $treatmentslog->snake_type = $inputs['snaketype'];
        $treatmentslog->systemic_bleeding = $inputs['systemic_bleeding'];
        $treatmentslog->respiratory_failure = $inputs['respiratory_failure'];
        $treatmentslog->motor_weakness = $inputs['motor_weakness'];
        $treatmentslog->save();
        return Redirect::to('page/patienttable');
      }

      if ($treatments->snake_group == 3) {
        $treatments->consult_case = $inputs['consult'];
        $treatments->statetime = 0;
        $treatments->status = 1;
        $treatments->save();

        $treatmentslog = new Treatmentlog();
        $treatmentslog->record_id = $id;
        $treatmentslog->state = $inputs['state'];
        $treatmentslog->log_text = $inputs['logtext'];
        $treatmentslog->snake_type = $inputs['snaketype'];
        $treatmentslog->systemic_bleeding = $inputs['systemic_bleeding'];
        $treatmentslog->respiratory_failure = $inputs['respiratory_failure'];
        $treatmentslog->motor_weakness = $inputs['motor_weakness'];
        $treatmentslog->save();
        return Redirect::to('page/patienttable');
      }


    }
    public function postConfirmmanagement()
    {
      $inputs = Input::all();
      $id = $inputs['treatmentid'];
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('record_id','=',$id)->first();
      if ($treatments->snake_group == 1) {
        if ($treatments->state == 4) {
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->state = $inputs['state'];
          $treatmentslog->log_text = $inputs['logtext'];
          $treatmentslog->snake_type = $inputs['snaketype'];
          $treatmentslog->systemic_bleeding = $inputs['systemic_bleeding'];
          $treatmentslog->respiratory_failure = $inputs['respiratory_failure'];
          $treatmentslog->motor_weakness = $inputs['motor_weakness'];
          $treatmentslog->save();

          $treatments->state = 5;
          $treatments->status = 2;
          $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+4, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
          $treatments->save();
          return Redirect::to("page/management/$id");

        }elseif($treatments->state == 5 and $treatments->staterepeat== 0) {
          return Redirect::to('page/patienttable');
        }else {
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->state = $inputs['state'];
          $treatmentslog->log_text = $inputs['logtext'];
          $treatmentslog->snake_type = $inputs['snaketype'];
          $treatmentslog->systemic_bleeding = $inputs['systemic_bleeding'];
          $treatmentslog->respiratory_failure = $inputs['respiratory_failure'];
          $treatmentslog->motor_weakness = $inputs['motor_weakness'];
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
        }
      }

      if ($treatments->snake_group == 2){
        if ($treatments->state == 3) {
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->state = $inputs['state'];
          $treatmentslog->log_text = $inputs['logtext'];
          $treatmentslog->snake_type = $inputs['snaketype'];
          $treatmentslog->systemic_bleeding = $inputs['systemic_bleeding'];
          $treatmentslog->respiratory_failure = $inputs['respiratory_failure'];
          $treatmentslog->motor_weakness = $inputs['motor_weakness'];
          $treatmentslog->save();

          $treatments->state = 4;
          $treatments->status = 4;
          $treatments->statetime = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
          $treatments->save();
          return Redirect::to("page/management/$id");
        }elseif($treatments->state == 4 and $treatments->staterepeat== 0) {
          return Redirect::to('page/patienttable');
        }else {
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->state = $inputs['state'];
          $treatmentslog->log_text = $inputs['logtext'];
          $treatmentslog->snake_type = $inputs['snaketype'];
          $treatmentslog->systemic_bleeding = $inputs['systemic_bleeding'];
          $treatmentslog->respiratory_failure = $inputs['respiratory_failure'];
          $treatmentslog->motor_weakness = $inputs['motor_weakness'];
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
        }
      }

      if ($treatments->snake_group == 3) {
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->state = $inputs['state'];
          $treatmentslog->log_text = $inputs['logtext'];
          $treatmentslog->snake_type = $inputs['snaketype'];
          $treatmentslog->systemic_bleeding = $inputs['systemic_bleeding'];
          $treatmentslog->respiratory_failure = $inputs['respiratory_failure'];
          $treatmentslog->motor_weakness = $inputs['motor_weakness'];
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
      }




    }


  }

 ?>
