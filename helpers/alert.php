<?php
      if(isset($response) && @$response['response'] == "negative") { ?>
        <script>
        	swal('Error', '<?php echo $response['alert'] ?>', 'error');
        </script>
<?php }else if(isset($response) && @$response['response'] == "positive"){ ?>
        <!-- <script>
            swal({
            title: "success",
            text: "",
            type: "success",
            showCancelButton: false,
            confirmButtonText: "Yes",
            closeOnConfirm: false,
            closeOnCancel: true
          }, function(isConfirm) {
            if (isConfirm) {
              window.location.href= "<?php echo $response['redirect'] ?>";
            }
          });
        </script> -->
        <script>
            swal({
            title: "Berhasil",
            text: "",
            type: "success",
            timer: 1500,
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "Yes",
            // closeOnConfirm: false,
            // closeOnCancel: true,
          }, function(isConfirm) {
            if (isConfirm) {
              window.location.href= "<?php echo $response['redirect'] ?>";
            }
          });
        </script>
<?php } ?>

		