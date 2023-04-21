<!-- <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script> -->
<script src="includes/js/jquery.js"></script>
<script src="includes/js/sweetalert.min.js"></script> <!-- SweetAlert library -->

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