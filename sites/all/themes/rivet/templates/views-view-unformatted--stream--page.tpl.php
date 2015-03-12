<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
 
 $count = count($rows);
?>

<?php print rivet_build_filter('stream_type'); ?>
<div class="grid">
<?php 	
	$block = module_invoke('webform', 'block_view', 'client-block-103');
	print render($block['content']);
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
<?php if (($id + 1) == $count) { $classes_array[$id] .= " end"; } ?>
<?php 
	//print_r( $view->result[$id] );
	if ( isset( $view->result[$id]->{'_field_data'}['nid']['entity']->field_stream_category['und'][0]['tid'] ) ) {
		$term = taxonomy_term_load( $view->result[$id]->{'_field_data'}['nid']['entity']->field_stream_category['und'][0]['tid'] );
		$classes_array[$id] .= " category-" . strtolower( str_replace( " " , "-", $term->name ) );
	}
?>
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
</div><!-- .grid -->