<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>Attachments Options</h2>
	<form action="options.php" method="post">
		<?php wp_nonce_field('update-options'); ?>

		<?php if( function_exists( 'get_post_types' ) ) : ?>
			
			<?php 
				$args = array(
					'public'   => true,
					'_builtin' => false
					); 
				$output = 'objects';
				$operator = 'and';
				$post_types = get_post_types( $args, $output, $operator );
			?>
			
			<?php if( count( $post_types ) ) : ?>
			
				<h3><?php _e("Custom Post Type Settings", "attachments"); ?></h3>
				<p><?php _e("Include Attachments in the following Custom Post Types:", "attachments"); ?></p>
				<?php foreach($post_types as $post_type) : ?>

					<div class="attachments_checkbox">
						<input type="checkbox" name="attachments_cpt_<?php echo $post_type->name; ?>" id="attachments_cpt_<?php echo $post_type->name; ?>" value="true"<?php if (get_option('attachments_cpt_' . $post_type->name)=='true') : ?> checked="checked"<?php endif ?> />
						<label for="attachments_cpt_<?php echo $post_type->name; ?>"><?php echo $post_type->labels->name; ?></label>
					</div>

				<?php endforeach ?>
			
			<?php endif ?>
			
		<?php endif ?>

		<h3><?php _e("Privacy Settings", "attachments"); ?></h3>
		<div class="attachments_checkbox">
			<input type="checkbox" name="attachments_limit_to_user" id="attachments_limit_to_user" value="true"<?php if (get_option('attachments_limit_to_user')=='true') : ?> checked="checked"<?php endif ?> />
			<label for="attachments_limit_to_user"><?php _e("Users can only see their own attachments", "attachments");?></label>
		</div>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="attachments_limit_to_user,<?php if( !empty( $post_types ) ) : foreach( $post_types as $post_type ) : ?>attachments_cpt_<?php echo $post_type->name; ?>,<?php endforeach; endif; ?>" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e("Save", "attachments");?>" />
		</p>
	</form>
</div>