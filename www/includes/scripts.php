<!-- <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script> -->
<!-- <script src="includes/js/jquery.js"></script> -->
<script src="includes/js/sweetalert.min.js"></script> <!-- SweetAlert library -->
  <link rel="stylesheet" href="includes/magnific-popup/magnific-popup.css">
  <script src="includes/js/jquery.min.js"></script>
  <script src="includes/magnific-popup/jquery.magnific-popup.js"></script>

  <script>
    $(document).ready(function() {
      $('.lightbox-link').magnificPopup({
        type: 'image',
        gallery: {
          enabled: true
        }
      });
    });
  </script>

<!-- // Showing SweetAlert
       // Checking message and icon for the SweetAlert -->
<?php
if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] != '') {
?>
    <script type="text/javascript">
        $(document).ready(function() {
            swal({
                title: "<?php echo $_SESSION['STATUS']; ?>",
                // text: "Suceess message sent!!",
                icon: "<?php echo $_SESSION['STATUS_CODE']; ?>",
                // button: "Ok",
                timer: 2000
            });
        });
    </script>
<?php
    // <!--  Destroying SweetAlert message -->
    unset($_SESSION['STATUS']);
}
?>