<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */

 $count = count($rows);
?>
<?php print rivet_build_filter('article_type'); ?>
<div class="grid">
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
<?php if (($id + 1) == $count) { $classes_array[$id] .= " end"; } ?>
<?php  

	if ( isset( $view->result[$id]->taxonomy_term_data_node_tid ) ) {
		$term = taxonomy_term_load( $view->result[$id]->taxonomy_term_data_node_tid );
		$classes_array[$id] .= " category-" . strtolower( str_replace( " " , "-", $term->name ) );
	}

	$article_type = $view->result[$id]->{'_field_data'}['nid']['entity']->field_type['und'][0]['value'];
	$classes_array[$id] .= " article-type-" . $article_type;
	$sfdcCampaignId = isset($view->result[$id]->{'_field_data'}['nid']['entity']->field_sfdccampaignid['und'][0]['value']) ? $view->result[$id]->{'_field_data'}['nid']['entity']->field_sfdccampaignid['und'][0]['value'] : null;
?>
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?> data-category="<?php print $article_type; ?>" data-sfdcCampaignId="<?php print $sfdcCampaignId; ?>">
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
</div>