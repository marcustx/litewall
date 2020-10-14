    <footer id="copyright">

        <div class="container">
            <div class="row">
    <!--
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <p><i class="fa fa-envelope-o"></i><span> Email</span><a href="mailto:1701studioatx@gmail.com">1701studioatx@gmail.com</a></p>
                </div>
    -->
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <p>LiteWall - Copyright &copy; <?php echo date('Y'); ?></p>
                </div>
    <!--            <div class="col-md-4 col-sm-4 col-xs-12">
                    <ul class="social-icon">
                        <li><span>Meet us on</span></li>
                        <li><a href="#" class="fa fa-facebook"></a></li>
                        <li><a href="#" class="fa fa-twitter"></a></li>
                        <li><a href="#" class="fa fa-apple"></a></li>
                        <li><a href="https://instagram.com/1701studioatx" class="fa fa-instagram"></a></li>
                    </ul>
                </div>
    -->        </div>
        </div>


    </footer>
    <script src="/js/jquery.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.singlePageNav.min.js"></script>
    <script src="/js/typed.js"></script>
    <script src="/js/wow.min.js"></script>
    <script src="/js/custom.js"></script>
    <script src="/js/main.js"></script>
    <script>
    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
      if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
      }
      var $subMenu = $(this).next(".dropdown-menu");
      $subMenu.toggleClass('show');
      $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $('.dropdown-submenu .show').removeClass("show");
      });
      return false;
    });
    </script>
  </body>
</html>
