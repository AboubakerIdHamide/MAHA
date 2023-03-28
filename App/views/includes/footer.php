<!-- Footer -->
<footer class="mt-5" id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 footer-contact">
          <h1 class="logo"><a href="#">M<span>A</span>H<span>A</span></a></h1>
          <p>
            Boulevard de Mohammedia <br>
            QI Azli 40150<br>
            Maroc <br><br>
            <strong>Phone:</strong> (+212) 524 34 50 57<br>
            <strong>Email:</strong> info@maha.com<br>
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="container d-md-flex py-4">
    <div class="me-md-auto text-center text-md-start">
      <div class="copyright">
        © Copyright <strong><span>MAHA</span></strong>. All Rights Reserved (2023)
      </div>
    </div>
  </div>
</footer>
<!-- Fin Footer -->
<!-- To-up Button -->
<span class="to-top" href="#"><i class="fa fa-chevron-up"></i></span>
<!-- To-up Button -->

<script src="<?php echo URLROOT; ?>/public/jQuery/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous"></script>

<script src="<?= URLROOT ?>/public/WOW/dist/wow.min.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/main.js"></script>

<script>
  // WOW JS
  new WOW().init();

  // preloader
  $(window).on('load', function () {
    $('.preloader').fadeOut('slow');
  });
</script>
</body>

</html>