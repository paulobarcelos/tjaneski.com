<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="main">
	<?php if (is_single()) {?>
		<?php if (have_posts()){?>
			<?php while (have_posts()){?>
			 	<?php the_post(); ?>
				<div id="postgallery">
					<?php
					$videos = get_post_custom_values('Video');
					$totalVideos = count($videos);
					$last_video = $totalVideos;
					$allVideosEmpty = 1;
					foreach ( $videos as $key => $value ) {
						if($value != ""){
							$allVideosEmpty = 0;
						}
					}	
					?>
  					<?php if( $totalVideos > 0 || $allVideosEmpty == 0) {?>
  					<ul>
  						<?php $vi = 0;?>
     					<?php foreach ( $videos as $key => $value )  { ?>
     						<?php $vi++;?>
     						<?php if ($value != "") {?>
     							<li>
	     							<?php echo "$value";?>
	     						</li>
      						<?php }?>
      					<?php } ?>
    				</ul>
    				<?php } ?>
					<?php
    				$attachments = attachments_get_attachments();
    				$total_attachments = count($attachments);
    				$last_attachement = $total_attachments -1;
 					?>
  					<?php if( $total_attachments > 0 ) {?>
    				<ul>
     					<?php for ($i=0; $i < $total_attachments; $i++) { ?>
     					<?php if ($i != $last_attachement) {?>
     						<li>
     					<?php } else {?>
     						<li class="last-item">
     					<?php }?>
     					<img src="<?=$attachments[$i]['location']?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/></li>
      					<?php }?>
    				</ul>
  					<?php } ?>
				</div>
			<?php }?>
		<?php }?>
	<?php }?>
	</div>

<?php get_footer(); ?>
