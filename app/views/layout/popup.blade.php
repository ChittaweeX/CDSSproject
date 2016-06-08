@if(Session::has('complate'))
    <script>
      $(document).ready(function() {

          $(window).load(function(){
                     swal({
             title: "LoginComplate!",
             text: "Confirmation of data",
             type: "success",
             confirmButtonText: "OK"
         });
                   });

        });
    </script>
  @endif

  @if(Session::has('complatesavepatient'))
      <script>
        $(document).ready(function() {

            $(window).load(function(){
                       swal({
               title: "Save Complate",
               text: "Next Symptom Check",
               type: "success",
               confirmButtonText: "OK"
           });
                     });

          });
      </script>
    @endif
