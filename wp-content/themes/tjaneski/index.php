<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="main">
	<?php if (have_posts()){?>
		<?php $postlist = get_posts('numberposts=-1&order=DESC&orderby=date'); ?>
		<?php $biggest_ycord = 0; ?>
		<?php $biggest_ycord_thumb_height = 0; ?>
		<?php foreach ($postlist as $post){ ?>
			<?php setup_postdata($post); ?> 
			<?php if(has_post_thumbnail()) { ?>
				<?php $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), "full");?>
				<?php $custom_fields = get_post_custom();?>
				<?php
				$ycordfield = $custom_fields['ycord'];
				foreach ( $ycordfield as $key => $value ){
					if($value > $biggest_ycord) {
						$biggest_ycord = $value;
						$biggest_ycord_thumb_height = $thumbnail[2];
					}
				}?>
			<?php }?>
		<?php } ?>
		<?php $yoffset = 136; ?>
		<?php $posts_div_height = $biggest_ycord + $biggest_ycord_thumb_height - $yoffset?>
		<div id="posts" style="height: <?php echo $posts_div_height;?>px">
		<?php $postlist = get_posts('numberposts=-1&order=ASC&orderby=date'); ?>
		<?php foreach ($postlist as $post){ ?>
			<?php setup_postdata($post); ?> 
			<?php if(has_post_thumbnail()) { ?>
				<?php $custom_fields = get_post_custom();?>
				<?php
				$xcordfield = $custom_fields['xcord'];
				foreach ( $xcordfield as $key => $value ){
					$xcord = $value;
				}
				$ycordfield = $custom_fields['ycord'];
				foreach ( $ycordfield as $key => $value ){
					$ycord = $value;
				}
				?>
				<?php $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), "full");?>
				<div id="thumbnail" <?php position($xcord, $ycord); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" ><img width=<?php echo $thumbnail[1]; ?> height=<?php echo $thumbnail[2]; ?> src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title(); ?>"></a></img></div>
			<?php }?>
		<?php } ?>
		</div>
	<?php } else {?>
		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>
	<?php }?>
	</div>
<?php get_footer(); ?>


