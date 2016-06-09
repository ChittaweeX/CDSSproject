<?php
  /**
   *
   */
  class ManageController extends Controller
  {
    //// STEP 1 /////////////////////////////
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
    //// STEP 2 /////////////////////////////
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


      return Redirect::to("page/symptom/$treatmentid");
    }

    //// STEP 3 Link to 4/////////////////////////////
    public function postSymptomcheck()
    {
      $inputs = Input::all();
      $id  = $inputs['treatmentid'];
      $snaketype = $inputs['snaketype'];
      $treatments = Treatment::where('record_id','=',$id)->first();
      if ($treatments->snake_type != $snaketype and $treatments->snake_type != 0) {
        if ($treatments->snake_group == 1) {
          $treatments->systemic_bleeding = $inputs['systemicB'];
          $treatments->respiratory_failure = $inputs['respiratoryF'];
          $treatments->motor_weakness = $inputs['motorweakness'];
          $treatments->snake_type = $inputs['snaketype'];
          $treatments->state = 8;
          $treatments->status = 1;
          $treatments->save();
          $treatmentid = $id;
          return Redirect::to("page/consult/$treatmentid");
        }elseif($treatments->snake_group == 2) {
          $treatments->systemic_bleeding = $inputs['systemicB'];
          $treatments->respiratory_failure = $inputs['respiratoryF'];
          $treatments->motor_weakness = $inputs['motorweakness'];
          $treatments->snake_type = $inputs['snaketype'];
          $treatments->state = 7;
          $treatments->status = 1;
          $treatments->save();
          $treatmentid = $id;
          return Redirect::to("page/consult/$treatmentid");
        }
      }else {
        $treatments->systemic_bleeding = $inputs['systemicB'];
        $treatments->respiratory_failure = $inputs['respiratoryF'];
        $treatments->motor_weakness = $inputs['motorweakness'];
        $treatments->snake_type = $inputs['snaketype'];
        $treatments->save();
        $treatmentid = $id;
        return Redirect::to("function/consultcheck/$treatmentid");
      }
    }

    //// STEP 4 /////////////////////////////
    public function getConsultcheck($treatmentid)
    {
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('treatmentRecord.record_id','=',$treatmentid)->first();
      $treatmentid = $treatments->record_id;
      //// SNAKE GROUP 1 Hematotoxic /////////////
      if ($treatments->snake_group == 1) {
        if ($treatments->systemic_bleeding == 1 or $treatments->respiratory_failure== 1 or $treatments->motor_weakness== 1) {
            $treatments->state = 7;
            $treatments->status = 1;
            $treatments->save();
            return Redirect::to("page/consult/$treatmentid");
          }else{
            return Redirect::to("page/bloodtest/$treatmentid");
          }
        }

      //// SNAKE GROUP 2 neurotoxic /////////////
      if ($treatments->snake_group == 2) {
          if ($treatments->state == 4 or $treatments->state == 8) {
            if ($treatments->systemic_bleeding == 1 or $treatments->respiratory_failure== 1 or $treatments->motor_weakness== 1) {
              $treatments->state = 6;
              $treatments->status = 1;
              $treatments->save();
              return Redirect::to("page/consult/$treatmentid");
            }
          }

          if ($treatments->systemic_bleeding == 1) {
            $treatments->state = 7;
            $treatments->status = 1;
            $treatments->save();
            return Redirect::to("page/consult/$treatmentid");
          }
          elseif ($treatments->respiratory_failure== 1 and $treatments->motor_weakness== 1) {
                  $treatments->state = 2;
                  $treatments->status = 4;
                  $treatments->save();
                return Redirect::to("page/management/$treatmentid");
              }
              elseif($treatments->respiratory_failure== 0 and $treatments->motor_weakness== 1) {
                      $treatments->state = 3;
                      $treatments->status = 4;
                      $treatments->save();
                    return Redirect::to("page/management/$treatmentid");
                  }
              else{
                if ($treatments->state == 0) {
                  $treatments->state = 1;
                  $treatments->status = 4;
                  $treatments->save();
                return Redirect::to("page/observe/$treatmentid");
              }else{
                return Redirect::to("page/observe/$treatmentid");
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
     return Redirect::to("function/bloodcheck/$bloodid/$treatmentid");
    }


    public function getBloodcheck($bloodid,$treatmentid)
    {

      $bloodtest = Bloodtest::where('test_id','=',$bloodid)->first();
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('record_id','=',$treatmentid)->first();
      $repeattime = $treatments->staterepeat;


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
        if ($treatments->state == 0){
          if ($Platelet < 100000 or $INR > 1.2 or $bloodtest->WBCT == 0) {
            $treatments->state = 4;
            $treatments->status = 2;
            $treatments->staterepeat = 0 ;
            $treatments->save();
            $bloodtest->state = 0;
            $bloodtest->save();
            return Redirect::to("page/management/$treatmentid");
          }else{
            $treatments->state = 2;
            $treatments->status = 2;
            $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+6, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
            $treatments->save();
            $bloodtest->state = 0;
            $bloodtest->save();
            return Redirect::to("page/management/$treatmentid");
          }
        }

        if ($treatments->state == 2){
          if ($Platelet < 100000 or $INR > 1.2 or $bloodtest->WBCT == 0) {
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
              $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+0, date("i")+0, date("s")+0, date("m")+0  , date("d")+1, date("Y")+0));
              $treatments->save();
              $bloodtest->state = 2;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }else {
              $treatments->staterepeat = $repeattime+1 ;
              $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+6, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
              $treatments->save();
              $bloodtest->state = 2;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }
          }
        }

        if ($treatments->state == 3){
          if ($Platelet < 100000 or $INR > 1.2 or $bloodtest->WBCT == 0) {
            $treatments->state = 4;
            $treatments->staterepeat = 0 ;
            $treatments->status = 2;
            $treatments->save();
            $bloodtest->state = 3;
            $bloodtest->save();
            return Redirect::to("page/management/$treatmentid");
          }else{
            if ($repeattime == 2) {
              $treatments->state = 6;
              $treatments->staterepeat = 0 ;
              $treatments->status = 3;
              $treatments->save();
              $bloodtest->state = 3;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }else {
              $treatments->staterepeat = $repeattime+1 ;
              $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+0, date("i")+0, date("s")+0, date("m")+0  , date("d")+1, date("Y")+0));
              $treatments->save();

              $bloodtest->state = 3;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }
          }
        }

        if ($treatments->state == 5){
          if ($Platelet < 100000 or $INR > 1.2 or $bloodtest->WBCT == 0) {
            $treatments->state = 9;
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
              $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+6, date("i")+0, date("s")+0, date("m")+0  , date("d")+1, date("Y")+0));
              $treatments->save();
              $bloodtest->state = 5;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }else {
              $treatments->staterepeat = $repeattime+1 ;
              $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+4, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
              $treatments->save();
              $bloodtest->state = 5;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid");
            }
          }
        }

      }

    }

    public function postObserverecord()
    {
      $inputs =  Input::all();
      $id = $inputs['treatmentid'];
      $observe = new Observe();
      $observe->record_id = $id;
      $observe->Muscle_weakness = $inputs['muscle_weakness'];
      $observe->Ptosis = $inputs['ptosis_weakness'];
      $observe->Dysarthria = $inputs['dysarthria_weakness'];
      $observe->save();
      $observeid = $observe->ob_id;
      $treatmentid = $observe->record_id;
     return Redirect::to("function/observecheck/$observeid/$treatmentid");
    }


    public function getObservecheck($observeid,$treatmentid)
    {
      $observe = Observe::where('ob_id','=',$observeid)->first();
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('record_id','=',$treatmentid)->first();
      $repeattime = $treatments->staterepeat;


      if ($treatments->snake_group == 2) {
        if ($treatments->state == 1){
          if ($treatments->respiratory_failure== 1 and $observe->Muscle_weakness == 1 or $observe->Ptosis == 1 or $observe->Dysarthria== 1) {
              $treatments->state = 2;
              $treatments->status = 4;
              $treatments->staterepeat = 0 ;
              $treatments->save();
              return Redirect::to("page/management/$treatmentid");
            }elseif($observe->Muscle_weakness == 1 or $observe->Ptosis == 1 or $observe->Dysarthria== 1){
              $treatments->state = 3;
              $treatments->status = 4;
              $treatments->staterepeat = 0 ;
              $treatments->save();
              return Redirect::to("page/management/$treatmentid");
            }else {
              if ($repeattime == 23) {
                $treatments->state = 5;
                $treatments->status = 3;
                $treatments->staterepeat = 0 ;
                $treatments->nextbloodtest = 0;
                $treatments->save();
                $observe->state = 1;
                $observe->save();
                return Redirect::to("page/management/$treatmentid");
              }else {
                $treatments->staterepeat = $repeattime+1 ;
                $treatments->status = 4;
                $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
                $treatments->save();
                $observe->state = 1;
                $observe->save();
                return Redirect::to("page/management/$treatmentid");
              }
            }
          }
          if ($treatments->state == 4){
            if ($observe->Muscle_weakness == 1 or $observe->Ptosis == 1 or $observe->Dysarthria== 1) {
              if ($treatments->respiratory_failure== 1) {
                $treatments->state = 6;
              }else {
                  $treatments->state = 6;
              }
              $treatments->status = 1;
              $treatments->save();
              return Redirect::to("page/consult/$treatmentid");
              }else {
                if ($repeattime == 11) {
                  $treatments->state = 8;
                  $treatments->status = 4;
                  $treatments->staterepeat = 0 ;
                  $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+12, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
                  $treatments->save();
                  $observe->state = 4;
                  $observe->save();
                  return Redirect::to("page/management/$treatmentid");
                }else {
                  $treatments->staterepeat = $repeattime+1 ;
                  $treatments->status = 4;
                  $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
                  $treatments->save();
                  $observe->state = 1;
                  $observe->save();
                  return Redirect::to("page/management/$treatmentid");
                }
              }
            }
            if ($treatments->state == 8){
              if ($treatments->respiratory_failure== 1 and $observe->Muscle_weakness == 1 or $observe->Ptosis == 1 or $observe->Dysarthria== 1) {
                $treatments->state = 7;
                $treatments->status = 1;
                $treatments->save();
                return Redirect::to("page/consult/$treatmentid");
                }elseif($observe->Muscle_weakness == 1 or $observe->Ptosis == 1 or $observe->Dysarthria== 1){
                  $treatments->state = 7;
                  $treatments->status = 1;
                  $treatments->save();
                  return Redirect::to("page/consult/$treatmentid");
                }else {
                    $treatments->state = 5;
                    $treatments->status = 3;
                    $treatments->staterepeat = 0 ;
                    $treatments->nextbloodtest = 0;
                    $treatments->save();
                    $observe->state = 8;
                    $observe->save();
                    return Redirect::to("page/management/$treatmentid");
                }
              }
        }
      }



    //// Confirm //////////////////////
    public function postConfirmconsult()
    {
      $inputs = Input::all();
      $id = $inputs['treatmentid'];
      $treatments = Treatment::where('record_id','=',$id)->first();
      $treatments->consult_case = $inputs['consult'];
      $treatments->nextbloodtest = 0;
      $treatments->save();

      $treatmentslog = new Treatmentlog();
      $treatmentslog->record_id = $id;
      $treatmentslog->log_text = $inputs['logtext'];
      $treatmentslog->save();
      return Redirect::to('page/patienttable');
    }
    public function postConfirmmanagement()
    {
      $inputs = Input::all();
      $id = $inputs['treatmentid'];
      $treatments = Treatment::join('snake', 'treatmentRecord.snake_type', '=', 'snake.snake_id')
      ->where('record_id','=',$id)->first();
      if ($treatments->snake_group == 1) {
        if ($treatments->state == 4) {
          $treatments->state = 5;
          $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+4, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
          $treatments->status = 2;
          $treatments->save();
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->log_text = 'Give Antivenom and Waiting Repeat Bloodtest';
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
        }elseif ($treatments->state == 6) {
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->log_text = 'Done';
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
        }else{
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->log_text = $inputs['logtext'];
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
        }
      }
      if ($treatments->snake_group == 2) {
        if ($treatments->state == 2) {
          $treatments->state = 4;
          $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
          $treatments->status = 4;
          $treatments->save();
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->log_text = 'Ventilation Support , Give Antivenom and Waiting Obsereve motor weakness';
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
        }elseif($treatments->state == 3){
          $treatments->state = 4;
          $treatments->nextbloodtest = date("Y/m/d H:i:s", mktime(date("H")+1, date("i")+0, date("s")+0, date("m")+0  , date("d")+0, date("Y")+0));
          $treatments->status = 4;
          $treatments->save();
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->log_text = 'Give Antivenom and Waiting Obsereve motor weakness';
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
        }else {
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->log_text = 'Obsereve motor weakness';
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
        }
      }
    }

  }

 ?>
