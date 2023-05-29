<script src="includes/js/jquery.min.js"></script>
<!-- SweetAlert library -->
<script src="includes/swal/sweetalert2.all.js"></script>
<script src="includes/magnific-popup/jquery.magnific-popup.js"></script>
<link rel="stylesheet" href="includes/swal/sweetalert2.css">
<link rel="stylesheet" href="includes/magnific-popup/magnific-popup.css">

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
<?php if (isset($_SESSION['STATUS']) && $_SESSION['STATUS'] != '') { ?>
  <script type="text/javascript">
    $(document).ready(function() {
      Swal.fire({
        title: "<?php echo $_SESSION['STATUS']; ?>",
        // text: "Success message sent!!",
        icon: "<?php echo $_SESSION['STATUS_CODE']; ?>",
        button: "Ok",
        timer: 2000
      });
    });
  </script>
<?php
  // <!--  Destroying SweetAlert message -->
  unset($_SESSION['STATUS']);
  unset($_SESSION['STATUS_CODE']);
}
?>

<script>
  function showDeleteConfirmation(event) {
    event.preventDefault(); // Prevent the default behavior of the anchor tag

    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Delete',
      cancelButtonText: 'Cancel',
    }).then((result) => {
      if (result.isConfirmed) {
        // If the user confirms the deletion, proceed with the delete action
        window.location.href = event.target.href;
      }
    });
  }
</script>
