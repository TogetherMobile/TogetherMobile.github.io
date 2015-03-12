<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $display_submitted: whether submission information should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */

// We hide the comments and links now so that we can render them later.
hide($content['comments']);
hide($content['links']);

$hide_title = isset( $node->field_hide_title['und'] ) && ( $node->field_hide_title['und'][0]['value'] == 1 );

$prev_post = null;
$next_post = null;
if ( $view_mode == "full" ) {
	$prev = rivet_get_prev($node);
		
	if ( $prev ) {
		$prev_post = l(t('Prev stream post'), drupal_get_path_alias('node/' . $prev->nid ), array(
			"attributes" => array( 
				"class" => "prev"
			)
		));
	}
	
	$next = rivet_get_next($node);
	
	if ( $next ) {
		$next_post = l(t('Next stream post'), drupal_get_path_alias('node/' . $next->nid ), array(
			"attributes" => array( 
				"class" => "next"
			)
		));
	}
	
}

if ( $node->field_contains_video['und'][0]['value'] == 1 ) {
	
	$height = $node->field_video_embed_height['und'][0]['value'];
	$width = $node->field_video_embed_width['und'][0]['value'];
	
	$url = $node->field_video_embed_url['und'][0]['value'];
	$content['field_video_embed_url'] = array( "#markup" => '<div class="responsive-video"><iframe src="' . $url. '" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen width="' . $width .'" height="' . $height .'"></iframe></div>');
	
	hide( $content['field_graphic'] );
} else {
	
	hide( $content['group_video'] );
}

$title_tag = ( $view_mode == "full" ) ? 'h2' : 'h3';

?>

<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

<?php if ( $view_mode == "full" ) : ?><div class="row"><div class="column"><div class="info-head"><?php endif; ?>

<?php if ( $view_mode == "full" && arg(0) == "node" ) : ?>
	<p class="breadcrumb"><a href="/stream">Back to Stream</a></p>
<?php endif; ?>


<?php print render($title_prefix); ?>
<?php if (!$hide_title): ?>
	<<?php print $title_tag; ?><?php print $title_attributes; ?>><?php print $title; ?></<?php print $title_tag; ?>>
<?php endif; ?>

<?php if ( $view_mode == "full" ) : ?>
	
		<div class="byline">
			<span class="author"><?php print rivet_get_formatted_name((int) $node->uid); ?></span>
			<span class="date"><?php print date('F j, Y', $node->created); ?></span>
		</div>
	</div>
	 <div class="social-share active">
        <div class="social-wrapper addthis_sharing_toolbox"></div>
    </div>   
<?php endif; ?>

<?php print render($title_suffix); ?>
<?php print render($content); ?>


<?php if ( $view_mode == "full" ) : ?></div></div><?php endif; ?>

<div class="stream-footer">
	<div class="social-share active">
	    <div class="social-wrapper addthis_sharing_toolbox"></div>
	</div>
</div>

</article>

<?php if ( $prev_post || $next_post ) : ?>
<div class="stream-timeline">
	<?php print $prev_post; ?>
	<?php print $next_post; ?>
	<?php 	
		$block = module_invoke('webform', 'block_view', 'client-block-103');
		print render($block['content']);
	?>
</div>
<?php endif; ?>
