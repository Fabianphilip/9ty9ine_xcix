 <?php if(!empty($email)){ ?>
 </div>
 <script>
    function showLoader() {
      document.getElementById('loader').style.display = 'flex';
    }
    
    function hideLoader() {
      document.getElementById('loader').style.display = 'none';
    }

 </script>
 <script>
  function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("show");
  }
</script>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>