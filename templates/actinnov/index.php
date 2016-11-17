<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );
$self = $_SERVER['PHP_SELF'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  	<jdoc:include type="head" />
  	<link href='https://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'>
  	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/bootstrap.css" type="text/css" />
  	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css"/>
  	<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/js/sss.js"></script>
	<script>
    jQuery(function($) {
    	$('.slider').sss();
    });
    </script>
</head>
<body>
	<header>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-3">
					<jdoc:include type="modules" name="header-left" />
				</div>
				<div class="col-xs-12 col-md-9">
					<nav class="navbar navbar-default">
			            <div class="navbar-header">
			                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
			                    <span class="sr-only">Toggle navigation</span>
			                    <span class="icon-bar"></span>
			                    <span class="icon-bar"></span>
			                    <span class="icon-bar"></span>
			                </button>
			            </div>
			            <div class="collapse navbar-collapse" id="navbar-collapse-1">
			               <jdoc:include type="modules" name="navigation" />
			            </div>
				    </nav>
			    </div>
		    </div>
	    </div>
    </header>

	<section class="banner">
		<div class="container-fluid">
			<div class="row">
				<jdoc:include type="modules" name="banners" />
			</div>
		</div>
	</section>   

	<section class="quick-links">
		<div class="container">
			<div class="row">
				<jdoc:include type="modules" name="quick-links" />
			</div>
		</div>
	</section>

	<main class="articleBody">
		<div class="container">
			<div class="row">
				<jdoc:include type="component" />
			</div>
		</div> 
	</main>

	<!--     FOOTER     -->

	<footer>
		<div class="footer-cols">
		    <div class="container">
    			<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
					   	<div class="footer-logo">&nbsp;</div>
						<jdoc:include type="modules" name="social" />
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">	
						<div class="footer-right">				
							<jdoc:include type="modules" name="address" />
						</div>
					</div>
			    </div>
		    </div>
	    </div>
	</footer>

</body>
</html>