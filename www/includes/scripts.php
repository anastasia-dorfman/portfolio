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

<script>
  window.addEventListener('load', function() {
    if (window.matchMedia('(max-width: 37.5em)').matches) {
      const selects = document.querySelectorAll('.select-width');
      let maxWidth = 0;

      selects.forEach(function(select) {
        maxWidth = Math.max(maxWidth, select.offsetWidth);
      });

      selects.forEach(function(select) {
        select.style.width = maxWidth + 'px';
      });
    }
  });
</script>

<script>
  const form = document.querySelector(".contact__form");
  const textareaId = document.getElementById("overview") ? "overview" : "content";

  form.addEventListener("submit", function(event) {
    const textarea = tinymce.get(textareaId);
    const content = textarea.getContent();

    if (content.trim().length < 250) {
      event.preventDefault();
      Swal.fire({
        title: 'Error',
        text: textareaId === 'overview' ? 'Overview must be at least 250 characters long.' : 'Content must be at least 250 characters long.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });

  const addImageButton = document.getElementById("addImage");
  let imageIndex = <?php echo $imagesCount ?>;
  let shift = imageIndex == 0 ? 2 : 1;

  addImageButton.addEventListener("click", function() {
    const container = document.getElementById("image-container");
    const div = document.createElement("div");
    const label = document.createElement("label");
    let imageNumber = container.children.length + imageIndex + shift;
    label.className = "contact__form-label";
    label.innerHTML = `Image ${imageNumber}`;
    const input = document.createElement("input");
    input.required = textareaId == "content" ? false : imageNumber > 2 ? true : false;
    // input.required = imageNumber > 2 ? true : false;
    // input.required = false;
    input.type = "file";
    input.className = "contact__form-input";
    input.name = "image[]";
    input.accept = "image/*";
    div.appendChild(label);
    div.appendChild(input);
    container.appendChild(div);
  });
</script>

<script>
  const maxFileSize = <?php echo $maxFileSize ?>;

  document.getElementById('avatar').addEventListener('change', function(event) {
    const size = event.target.files[0].size;

    if (size > maxFileSize) {
      event.preventDefault();
      Swal.fire({
        title: 'Avatar image must be less than 2MB.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
      this.value = ''; // Clear the file input
    }
  });

  document.getElementById('image').addEventListener('change', function(event) {
    const size = event.target.files[0].size;

    if (size > maxFileSize) {
      event.preventDefault();
      Swal.fire({
        title: 'Image must be less than 2MB.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
      this.value = ''; // Clear the file input
    }
  });
</script>