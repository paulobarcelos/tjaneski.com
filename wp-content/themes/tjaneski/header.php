<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<link rel="icon" href="<?php bloginfo('stylesheet_directory');?>/img/favicon.ico" />
		<?php if (is_home()) {?>		
			<meta name="description" content ="<?php echo(get_userdata(1)->description);?>"/>
		<?php }elseif (is_single() || is_page()) { ?>
			<?php if (have_posts()){?>
				<?php while (have_posts()){?>
				 	<?php the_post(); ?>
				 	<meta name="description" content="<?php echo htmlentities(get_the_excerpt()); ?>" />
				 <?php }?>
			<?php } ?>
		<?php } ?>
		
		
		<?php if (is_home()) {?>		
		<title>Selected work of <?php bloginfo('name'); ?></title>
		<?php } else{ ?>
		<title><?php wp_title('-', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<?php } ?>
		
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<?php wp_head(); ?>
		
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-6603360-6']);
		  _gaq.push(['_trackPageview']);		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
	</head>

	<body>
	<div id="wrap">
	
		<div id ="header">
			<div id ="logo">
				<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><h1 alt="<?php bloginfo('name'); ?>"><img src="<?php bloginfo('stylesheet_directory');?>/img/magdalena-czarnecki.gif"/></h1></a>
			</div>
			<div id="nav">
				<div id="col" class="site-name"><p><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></p></div>
				<div id="col"><p><?php the_author_meta('aim',1); ?></p></div>
				<div id="col"><p><?php the_author_meta('user_email',1); ?></p></div>
			</div>
		</div>

