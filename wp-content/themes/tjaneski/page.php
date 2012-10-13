<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="main">
	<?php if (is_page()) {?>
	<?php $aboutID = 131; ?>
	<?php $cvID = 129; ?>
	<?php $featuredID = 133; ?>
		<?php if (have_posts()){?>
			<?php while (have_posts()){?>
			 	<?php the_post(); ?>
			 	<?php $custom_fields = get_post_custom();?>
			 	<?php if (get_the_ID() != $cvID){ ?> 
					<h2><?php the_title(); ?></h2>
				<?php } ?>
				<?php if (get_the_ID() == $aboutID){ ?> 
					<?php the_content(); ?>
				<?php } ?>
				<?php if (get_the_ID() == $featuredID){ ?> 
					<div id="featuredgallery">
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
     						<li>
     					<?php }?>
     					<img src="<?=$attachments[$i]['location']?>" alt="<?php the_title(); ?> <?php bloginfo('name'); ?>" title="<?php the_title(); ?> <?php bloginfo('name'); ?>"/></li>
      					<?php }?>
    				</ul>
  					<?php } ?>
				</div>
				<?php } ?>
				<?php if (get_the_ID() == $featuredID){ ?> 
					<div id="col1" class="pagecol">
						<?php
						$fieldname = $custom_fields['col1-title'];
						foreach ( $fieldname as $key => $value ){
							echo "<h3 class='featuredpage'>".$value."</h3>";
						}?>
						<?php
						$fieldname = $custom_fields['col1-content'];
						foreach ( $fieldname as $key => $value ){
							echo $value;
						}?>
					</div>
					<div id="col2" class="pagecol">
						<?php
						$fieldname = $custom_fields['col2-title'];
						foreach ( $fieldname as $key => $value ){
							echo "<h3 class='featuredpage'>".$value."</h3>";
						}?>
						<?php
						$fieldname = $custom_fields['col2-content'];
						foreach ( $fieldname as $key => $value ){
							echo $value;
						}?>
					</div>
					<div id="col3" class="pagecol">
						<?php
						$fieldname = $custom_fields['col3-title'];
						foreach ( $fieldname as $key => $value ){
							echo "<h3 class='featuredpage'>".$value."</h3>";
						}?>
						<?php
						$fieldname = $custom_fields['col3-content'];
						foreach ( $fieldname as $key => $value ){
							echo $value;
						}?>
					</div>			
				<?php }?>
				<?php if (get_the_ID() == $cvID){ ?> 
					<div id="col1" class="pagecol">
						<?php
						$fieldname = $custom_fields['col1-title'];
						foreach ( $fieldname as $key => $value ){
							echo "<h3>".$value."</h3>";
						}?>
						<?php
						$fieldname = $custom_fields['col1-content'];
						foreach ( $fieldname as $key => $value ){
							echo $value;
						}?>
					</div>
					<div id="col2" class="pagecol">
						<?php
						$fieldname = $custom_fields['col2-title'];
						foreach ( $fieldname as $key => $value ){
							echo "<h3>".$value."</h3>";
						}?>
						<?php
						$fieldname = $custom_fields['col2-content'];
						foreach ( $fieldname as $key => $value ){
							echo $value;
						}?>
					</div>
					<div id="col3" class="pagecol">
						<?php
						$fieldname = $custom_fields['col3-title'];
						foreach ( $fieldname as $key => $value ){
							echo "<h3>".$value."</h3>";
						}?>
						<?php
						$fieldname = $custom_fields['col3-content'];
						foreach ( $fieldname as $key => $value ){
							echo $value;
						}?>
					</div>			
				<?php }?>
			<?php }?>
		<?php }?>
	<?php }?>
	</div>

<?php get_footer(); ?>
