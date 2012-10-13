<?php

	error_reporting(0);
	require_once(dirname(__FILE__) . '/../../../wp-admin/admin.php');
	require( dirname(__FILE__) . '/../../../wp-config.php' );

	global $wpdb;
	global $userdata;

	// set the user info in case we need to limit to the current author
	get_currentuserinfo();

	if( get_option('attachments_limit_to_user') == 'true' )
	{
		$attachments_sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' AND post_author = " . $userdata->ID . " ORDER BY post_modified DESC";
	}
	else
	{
		$attachments_sql = "SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' ORDER BY post_modified DESC";
	}

	$attachment_files = $wpdb->get_results( $attachments_sql );

?>

	<div id="attachments-file-list">
		
		<p id="attachments-instructions"><?php _e("Available attachments are listed from your <strong>Media Library</strong>. If you need to upload a new attachment, please close this dialog and use the available <strong>Add to Media Library</strong> button.", "attachments"); ?> <?php _e("Select/deselect an attachment by clicking its thumbnail. When you're done managing your attachments, click <strong>Attach</strong>.", "attachments")?></p>

		<?php
		
			$attachments_attachment_types = array(

					array(
						'name' => 'Images',
						'mime' => 'image',
					),
					array(
						'name' => 'Videos',
						'mime' => 'video'
					),
					array(
						'name' => 'Documents',
						'mime' => 'application'
					),
					array(
						'name' => 'Audio',
						'mime' => 'audio'
					),
				
				);
		
		?>


		<div id="attachments-tabs">
			
			<ul class="subsubsub">
				<?php $attachments_total_types = count( $attachments_attachment_types ); ?>
				<?php for( $attachments_index=0; $attachments_index < $attachments_total_types; $attachments_index++ ) : ?>
					<li>
						<a<?php if( $attachments_index == 0 ) : ?> class="current" <?php endif ?> href="#attachments-<?php echo $attachments_attachment_types[$attachments_index]['mime']; ?>">
							<?php echo $attachments_attachment_types[$attachments_index]['name']; ?>
						</a>
					</li>
				<?php endfor ?>
			</ul>
			
			<p class="attachments-actions"><a href="#" class="attachments-apply button button-highlighted"><?php _e("Attach", "attachments"); ?></a></p>
			
			<p class="clear" id="attachments-live-filter"><input type="text" value="" /></p>
			
			<div id="attachments-file-details">
				
				<?php foreach ( $attachments_attachment_types as $attachments_attachment_type ) : ?>
					<div class="attachments attachments-file-section attachments-<?php echo $attachments_attachment_type['mime']; ?>" id="attachments-<?php echo $attachments_attachment_type['mime']; ?>">

						<!-- <h2><?php echo __($attachments_attachment_type['name'], "attachments"); ?></h2> -->

						<table class="widefat fixed" cellpadding="0">
							<thead>
								<tr>
									<th scope="col" id="icon" class="manage-column column-icon">Icon</th>
									<th scope="col" id="media" class="manage-column column-media">File</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th scope="col" id="icon" class="manage-column column-icon">Icon</th>
									<th scope="col" id="media" class="manage-column column-media">File</th>
								</tr>
							</tfoot>
							<tbody>
								<?php foreach ($attachment_files as $post) : if ( strpos($post->post_mime_type, $attachments_attachment_type['mime']) !== false ) : ?>
									<tr class="author-other status-inherit" valign="top">
										<td class="column-icon media-icon">
											<a href="#">
												<span class="attachments-thumbnail">
													<?php echo wp_get_attachment_image( $post->ID, array(80, 60), true ); ?>
												</span>
												<span class="attachments-data">
													<span class="attachment-file-name">
														<?php echo $post->post_name; ?>
													</span>
													<span class="attachment-file-id">
														<?php echo $post->ID; ?>
													</span>
												</span>
											</a>
										</td>
										<td class="media column-media attachment-title">
											<?php echo $post->post_name; ?>
										</td>
									</tr>
								<?php endif; endforeach; ?>
							</tbody>
						</table>
						
					</div>
					<!-- /attachments-<?php echo $attachments_attachment_type['name']; ?> -->
				<?php endforeach ?>
		
			</div>
			<!-- /attachments-file-details -->
			
		</div>
		<!-- /attachments-tabs -->

	</div>
	<!-- /attachments-file-list -->
	
	<script type="text/javascript" charset="utf-8">
		jQuery('#attachments-tabs').tabs({
			selected: 0,
			select: function(event, ui){
				jQuery('#attachments-tabs .current').removeClass('current');
				jQuery('#attachments-tabs li:eq(' + ui.index + ') a').addClass('current');
			}
		});
	</script>
	
	<script type="text/javascript" charset="utf-8">
		jQuery('#attachments-live-filter input').liveUpdate('.attachments table tbody tr td.attachment-title')
	</script>
