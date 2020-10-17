<!DOCTYPE html>
<html lang="en">
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

	<style>
		.inUse{
			text-align: center;
			width: 50%;
    	border-radius: 100px;
		}

		.L{
			background-color: <?php echo $config["left_hand_color"] ?>
		}

		.R{
			background-color: <?php echo $config["right_hand_color"] ?>
		}

		.M{
			background-color: <?php echo $config["match_color"] ?>
		}

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
</head>
<body>
<header>
<nav class="navbar navbar-light bg-light templatemo-nav navbar-expand-md" role="navigation">
  <div class="container">
    <button class="navbar-toggler" data-toggle="collapse" data-target=".navbar-collapse">&#x2630;</button>
    <a href="/" class="navbar-brand"><img width="90"src="/images/litewall.png" alt="LiteWall"></a>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav ml-auto">
        <li class="nav-item"><a href="/" class="nav-link">HOME</a></li>
       <!-- <li class="nav-item"><a href="/contact/" class="nav-link">CONTACT</a></li> -->
      </ul>
    </div>
  </div>
</nav>
</header>
