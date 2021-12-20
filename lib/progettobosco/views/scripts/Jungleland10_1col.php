<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>


<meta charset="UTF-8">
<meta name="author" content="Claudio Fior" />
<?php $this->renderBlock('HEADERS'); ?>
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/one_col.css" />
<link rel="stylesheet" type="text/css" media="screen" href="js/jquery-ui/css/smoothness/jquery-ui-1.10.3.custom.css"  />
<?php echo (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG'] ? '<script type="text/javascript" >var DEBUG=true;</script>' : '') ;?>
</head>

<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55510320-2', 'auto');
  ga('send', 'pageview');

</script>
<div id="ajaxloader" style="display: none;">
    <div>Caricamento in corso...<br/><img src="images/ajax-loader.gif" alt="Caricamento"/></div>
</div>
<!-- wrap -->
<div id="wrap">

	<!-- header -->
	<div id="header">			
	
		<a id="top"></a>
		
		<h1 id="logo-text"><a href="<?php echo $GLOBALS['BASE_URL'];?>" title=""><img src="images/progettobosco.png" alt="progettobosco" width="352" height="77"/></a></h1>		
		<p id="slogan">pianificazione forestale a portata di mouse ... </p>					
		

					
	<!-- /header -->					
	</div>
	
	<!-- content -->
	<div id="content-wrap" class="clear">
	
		<div id="content">		
		<?php $this->renderBlock('CONTENT'); ?>
			
		<!-- /content -->	
		</div>				
	<!-- /content-wrap -->	
	</div>	
<!-- /wrap -->
</div> 
        <script type="text/javascript" src="js/jquery-ui/js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="js/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
        <?php $this->renderBlock('FOOTER'); ?>	

</body>
</html>
