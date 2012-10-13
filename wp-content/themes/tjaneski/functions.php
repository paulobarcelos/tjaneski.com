<?php 
 // Add "Featured image" feature to posts
add_theme_support( 'post-thumbnails', array( 'post' ) );

// Remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

// Generates an absolte positon for the postthumbnails
function getPosition($i, $w, $h)
{
	$xOffset = 260;
	$yOffset = 136;
	$parentWidth = 630;
	$numCol = 3;
	$overlap = 60;
	$colWidth = ($parentWidth + ($numCol-1) * $overlap) / $numCol;
	$rowHeight = $colWidth;
	$curRow = floor ($i / $numCol);
	$curCol = $i - ($curRow * $numCol);
	srand($i);
	$left = $xOffset + $curCol * $colWidth + rand(0,($colWidth-$w));
	if ($curCol != 0 ) $left = $left - ($curCol * $overlap);
	$top = $yOffset + $curRow * $rowHeight + rand(0,($rowHeight-$h));
	if ($curRow != 0 ) $top = $top - ($curRow * $overlap);
	
	$style  = 'style="';
	$style .= 'left:'.$left.'px;';
	$style .= 'top:'.$top.'px;';
	$style .= '"';
	echo $style;
}
// Get Position Style by entering x, and y coordinates
function position($x, $y)
{
	$left = $x;
	$top = $y;
	
	$style  = 'style="';
	$style .= 'left:'.$left.'px;';
	$style .= 'top:'.$top.'px;';
	$style .= '"';
	echo $style;
}

?>