<head>
	<meta charset="utf-8">
	<title>LiteWall</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="/css/animate.min.css">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/css/templatemo-style.css">
	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery.singlePageNav.min.js"></script>
	<script src="/js/typed.js"></script>
	<script src="/js/wow.min.js"></script>
	<script src="/js/custom.js"></script>
  <script src="/js/owatracker.js"></script>
</head>

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

<style>
.dropdown-submenu {
  position: relative;
}

.dropdown-submenu a::after {
  transform: rotate(-90deg);
  position: absolute;
  right: 6px;
  top: .8em;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-left: .1rem;
  margin-right: .1rem;
}
</style>
<?php
  $path = 'routes';
  $files = array_diff(scandir($path), array('.', '..'));
?>
<header>
<nav class="navbar navbar-light bg-light templatemo-nav navbar-expand-md" role="navigation">
  <div class="container">
    <button class="navbar-toggler" data-toggle="collapse" data-target=".navbar-collapse">&#x2630;</button>
    <a href="/" class="navbar-brand"><img width="90"src="/images/litewall.png" alt="LiteWall"></a>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown"> 
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ROUTE SAVED</a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <!-- <li><a class="dropdown-item" href="/rules/">Code of conduct</a></li> -->
<?php
          foreach($files as $file){
             echo "<li><a class=\"dropdown-item\" href=\"?filename=$file\">" . $file . "</a></li>";
          }
?>
          </ul>
        </li>
        <li class="nav-item"><a href="/" class="nav-link">HOME</a></li>
       <!-- <li class="nav-item"><a href="/contact/" class="nav-link">CONTACT</a></li> -->
      </ul>
    </div>
  </div>
</nav>
</header>

