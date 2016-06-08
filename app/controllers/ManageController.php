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
        $treatments->systemic_bleeding = $inputs['systemicB'];
        $treatments->respiratory_failure = $inputs['respiratoryF'];
        $treatments->motor_weakness = $inputs['motorweakness'];
        $treatments->snake_type = $inputs['snaketype'];
        $treatments->stage = 0;
        $treatments->status = 1;
        $treatments->save();
        $treatmentid = $id;
        return Redirect::to("page/consult/$treatmentid/$treatments->snake_type");
      }else {
        $treatments->systemic_bleeding = $inputs['systemicB'];
        $treatments->respiratory_failure = $inputs['respiratoryF'];
        $treatments->motor_weakness = $inputs['motorweakness'];
        $treatments->snake_type = $inputs['snaketype'];
        $treatments->save();
        $treatmentid = $id;
        return Redirect::to("function/consulthematocheck/$treatmentid");
      }
    }

    //// STEP 4 /////////////////////////////
    public function getConsulthematocheck($treatmentid)
    {
      $treatments = Treatment::where('record_id','=',$treatmentid)->first();
      $treatmentid = $treatments->record_id;
      //// SNAKE GROUP 1 Hematotoxic /////////////
      if ($treatments->snake_type == 1 or $treatments->snake_type == 2 or $treatments->snake_type == 3) {
        if ($treatments->stage == 0) {
          if ($treatments->systemic_bleeding == 1 or $treatments->respiratory_failure== 1 or $treatments->motor_weakness== 1) {
            return Redirect::to("page/consult/$treatmentid/$treatments->snake_type");
          }else{
            return Redirect::to("page/bloodtest/$treatmentid");
          }
        }else{
          if ($treatments->systemic_bleeding == 1 or $treatments->respiratory_failure== 1 or $treatments->motor_weakness== 1) {
            $treatments->stage = 0;
            $treatments->status = 1;
            $treatments->save();
            return Redirect::to("page/consult/$treatmentid/$treatments->snake_type");
          }else {
            return Redirect::to("page/bloodtest/$treatmentid");
          }

        }
      }
      //// SNAKE GROUP 2 neurotoxic /////////////
      if ($treatments->snake_type == 4 or $treatments->snake_type == 5 or $treatments->snake_type == 6 or $treatments->snake_type == 7) {
        if ($treatments->stage == 0) {
          if ($treatments->respiratory_failure== 1 and $treatments->motor_weakness== 1) {
                  $treatments->stage = 6;
                  $treatments->status = 4;
                  $treatments->save();
                return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
              }
          elseif ($treatments->respiratory_failure== 0 and $treatments->motor_weakness== 1) {
                      $treatments->stage = 7;
                      $treatments->status = 4;
                      $treatments->save();
                    return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
                  }else {
                    $treatments->stage = 1;
                    $treatments->status = 4;
                    $treatments->save();
                  return Redirect::to("page/observe/$treatmentid");
                  }
      }else{
        if ($treatments->systemic_bleeding == 1) {
          $treatments->stage = 0;
          $treatments->status = 1;
          $treatments->save();
          return Redirect::to("page/consult/$treatmentid/$treatments->snake_type");
        }else {
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


    public function getBloodcheck($bloodid,$treatmentid)
    {
      $bloodtest = Bloodtest::where('test_id','=',$bloodid)->first();
      $treatments = Treatment::where('record_id','=',$treatmentid)->first();
      $repeattime = $treatments->stagerepeat;

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

      if ($treatments->snake_type == 1 or $treatments->snake_type == 2 or $treatments->snake_type == 3) {
        if ($treatments->stage == 0){
          if ($Platelet < 50000 or $INR > 1.2 or $bloodtest->WBCT == 0) {
            $treatments->stage = 1;
            $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }else{
            $treatments->stage = 3;
            $treatments->status = 2;
            $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }
        }

        if ($treatments->stage == 2){
          if ($Platelet < 50000 or $INR > 1.2 or $bloodtest->WBCT == 0) {
            $treatments->stage = 0;
            $treatments->save();
            $bloodtest->stage = 2;
            $bloodtest->save();
            return Redirect::to("page/consult/$treatmentid/$treatments->snake_type");
          }else{
            if ($repeattime == 2) {
              $treatments->stage = 4;
              $treatments->stagerepeat = 0 ;
              $treatments->save();
              $bloodtest->stage = 2;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
            }else {
              $treatments->stagerepeat = $repeattime+1 ;
              $treatments->save();
              $bloodtest->stage = 2;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
            }
          }
        }

        if ($treatments->stage == 3){
          if ($Platelet < 50000 or $INR > 1.2 or $bloodtest->WBCT == 0) {
            $treatments->stage = 1;
            $treatments->stagerepeat = 0 ;
            $treatments->save();
            $bloodtest->stage = 3;
            $bloodtest->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }else{
            if ($repeattime == 1) {
              $treatments->stage = 4;
              $treatments->stagerepeat = 0 ;
              $treatments->save();
              $bloodtest->stage = 3;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
            }else {
              $treatments->stagerepeat = $repeattime+1 ;
              $treatments->save();
              $bloodtest->stage = 3;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
            }
          }
        }

        if ($treatments->stage == 4){
          if ($Platelet < 50000 or $INR > 1.2 or $bloodtest->WBCT == 0) {
            $treatments->stage = 1;
            $treatments->stagerepeat = 0 ;
            $treatments->save();
            $bloodtest->stage = 4;
            $bloodtest->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }else{
            if ($repeattime == 2) {
              $treatments->stage = 5;
              $treatments->status = 3;
              $treatments->save();
              $bloodtest->stage = 4;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
            }else {
              $treatments->stagerepeat = $repeattime+1 ;
              $treatments->save();
              $bloodtest->stage = 4;
              $bloodtest->save();
              return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
            }
          }
        }
        if ($treatments->stage == 5){
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $treatmentid;
          $treatmentslog->log_text = 'Done';
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
        }
      }




    }

    public function getObservecheck($observeid,$treatmentid)
    {
      $observe = Observe::where('ob_id','=',$observeid)->first();
      $treatments = Treatment::where('record_id','=',$treatmentid)->first();
      $repeattime = $treatments->stagerepeat;

      if ($treatments->stage == 1){
        if ($observe->Muscle_weakness == 1 or $observe->Ptosis == 1 or $observe->Dysarthria== 1) {
          if ($treatments->respiratory_failure== 1) {
            $treatments->stage = 2;
            $treatments->stagerepeat = 0 ;
            $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }else{
            $treatments->stage = 3;
            $treatments->status = 4;
            $treatments->save();
          return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }
        }else{
          if ($treatments->respiratory_failure== 1) {
            $treatments->stage = 2;
            $treatments->stagerepeat = 0 ;
            $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }
          if ($repeattime == 23) {
            $observe->stageid = 1;
            $observe->save();
            $treatments->stage = 8;
            $treatments->status = 3;
            $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }else {
            $observe->stageid = 1;
            $observe->save();
            $treatments->stagerepeat = $repeattime+1 ;
            $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }
        }
      }

      if ($treatments->stage == 4){
        if ($observe->Muscle_weakness == 1 or $observe->Ptosis == 1 or $observe->Dysarthria== 1) {
          if ($treatments->respiratory_failure== 1) {
            $treatments->stage = 9;
            $treatments->status = 1;
            $treatments->stagerepeat = 0 ;
            $treatments->save();
            return Redirect::to("page/consult/$treatmentid/$treatments->snake_type");
          }else{
            $treatments->stage = 9;
            $treatments->status = 1;
            $treatments->save();
          return Redirect::to("page/consult/$treatmentid/$treatments->snake_type");
          }
        }else{
          if ($treatments->respiratory_failure== 1) {
            $treatments->stage = 9;
            $treatments->status = 1;
            $treatments->stagerepeat = 0 ;
            $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }
          if ($repeattime == 11) {
            $observe->stageid = 4;
            $observe->save();
            $treatments->stage = 5;
            $treatments->status = 4;
            $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }else {
            $observe->stageid = 4;
            $observe->save();
            $treatments->stagerepeat = $repeattime+1 ;
            $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }
        }
      }

      if ($treatments->stage == 5){
        if ($observe->Muscle_weakness == 1 or $observe->Ptosis == 1 or $observe->Dysarthria== 1) {
          if ($treatments->respiratory_failure== 1) {
            $treatments->stage = 9;
            $treatments->status = 1;
            $treatments->stagerepeat = 0 ;
            $treatments->save();
            return Redirect::to("page/consult/$treatmentid/$treatments->snake_type");
          }else{
            $treatments->stage = 9;
            $treatments->status = 1;
            $treatments->save();
          return Redirect::to("page/consult/$treatmentid/$treatments->snake_type");
          }
        }else{
          if ($treatments->respiratory_failure== 1) {
            $treatments->stage = 9;
            $treatments->status = 1;
            $treatments->stagerepeat = 0 ;
            $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");
          }

          $treatments->stage = 8;
          $treatments->status = 3;
          $treatments->stagerepeat = 0 ;
          $treatments->save();
            return Redirect::to("page/management/$treatmentid/$treatments->snake_type");

        }
      }

    }


    //// Confirm //////////////////////
    public function postConfirmconsult()
    {
      $inputs = Input::all();
      $id = $inputs['treatmentid'];
      $treatments = Treatment::where('record_id','=',$id)->first();
      $treatments->stage = 0;
      $treatments->nextstage = 0;
      $treatments->consult_case = $inputs['consult'];
      $treatments->status = $inputs['status'];
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


      $treatments = Treatment::where('record_id','=',$id)->first();
      if ($treatments->snake_type == 1 or $treatments->snake_type == 2 or $treatments->snake_type == 3) {
        if ($treatments->stage == 1) {
          $treatments->stage = 2;
          $treatments->status = 2;
          $treatments->save();
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->log_text = 'Blood test';
          $treatmentslog->save();
        }

        if ($treatments->stage == 5){
          $treatmentslog = new Treatmentlog();
          $treatmentslog->record_id = $id;
          $treatmentslog->log_text = 'Done';
          $treatmentslog->save();
          return Redirect::to('page/patienttable');
        }
      }elseif($treatments->snake_type == 4 or $treatments->snake_type == 5) {
        if ($treatments->stage == 2) {
          $treatments->stage = 4;
          $treatments->save();
        }
        if ($treatments->stage == 3) {
          $treatments->stage = 4;
          $treatments->save();
        }
        if ($treatments->stage == 6) {
          $treatments->stage = 1;
          $treatments->save();
        }
        if ($treatments->stage == 7) {
          $treatments->stage = 1;
          $treatments->save();
        }
      }




      $treatmentslog = new Treatmentlog();
      $treatmentslog->record_id = $id;
      $treatmentslog->log_text = $inputs['logtext'];
      $treatmentslog->save();


      return Redirect::to('page/patienttable');
    }



  }

 ?>
