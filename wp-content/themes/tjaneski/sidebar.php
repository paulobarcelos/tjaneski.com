<div id="sidebar">
	<?php
		global $wp_query;
		$thePostID = $wp_query->post->ID;
	?>
	<div id="nav">
		<ul id="posts">
			<?php $postlist = get_posts('numberposts=-1&order=DESC&orderby=date'); ?>
			<?php foreach ($postlist as $post){ ?>
				<?php setup_postdata($post); ?> 
				<?php if($thePostID == get_the_ID() && is_single()){ ?>
  					<li class="current">
  				<?php } else { ?>
  					<li>
  				<?php } ?>
				<a href="<?php the_permalink() ?>" title="View details of <?php the_title(); ?>"><?php the_title(); ?></a></li>
	 		<?php } ?>
		</ul>
		<ul id="pages">
			<?php 
  			$pages = get_pages('sort_column=post_date&sort_order=desc'); 
  			foreach ($pages as $pagg) {
  				if($thePostID == $pagg->ID){
  					$pagelink = '<li class="current">';
  				} else {
  					$pagelink = '<li>';
  				}
  				$pagelink .= '<a href="'.get_page_link($pagg->ID).'" ';
				$pagelink .= 'title="'.$pagg->post_title;
				$pagelink .= '">';
				$pagelink .= $pagg->post_title;
				$pagelink .= '</a></li>';
				echo $pagelink;
 	 		}?>
		</ul>
	</div>
	
	<?php if (is_single()) {?>
		<?php if (have_posts()){?>
			<?php while (have_posts()){?>
			 	<?php the_post(); ?>
			 	<?php $custom_fields = get_post_custom();?>
				<div id="postinfo">
					<div id="title"><h2><?php the_title(); ?></h2></div>
					<?php
					$Type = $custom_fields['Type'];
					foreach ( $Type as $key => $value ){
						echo "<div id='type'>".$value."</div>";
					}?>
					<div id="description"><?php the_content(); ?></div>
					<?php
					$Credits = $custom_fields['Credits'];
					foreach ( $Credits as $key => $value ){
						echo "<div id='credits'><p>".$value."</p></div>";
					}?>
				</div>
			<?php }?>
		<?php }?>
	<?php }?>
</div>