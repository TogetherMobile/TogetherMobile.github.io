<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
 

$query = db_select('node', 'n');
$query->join('weight_weights', 'weight', 'n.nid = weight.entity_id');
$query->fields('n', array('nid'));
$query->range(0, 3);
$query->condition('n.status', 1);
$query->condition('n.type', 'cta_platform');
$query->orderBy('weight.weight', 'ASC');

$result = $query->execute();
$ctas = '';
foreach ($result as $record) {
	$nid = $record->nid;
	$cta_node = node_load($nid);
//	$node_prep = node_view($cta_node, 'teaser');
//	$ctas .= render( $node_prep );

	$ctas .= '<div class="column small-4' . ( $cta_node->title == $row->node_title ? ' active' : '' ) . '" data-cta="platform">' . 
				theme('image_style', array('style_name' => 'thumbnail', 'path' => $cta_node->field_icon['und'][0]['uri'], 'attributes' => array('class' => 'thumb', ))) . 
				'<div class="views-field-title"><a href="#">' . $cta_node->title . '</a></div>' . 
			 '</div>';
}

$output = str_replace('{{ctas}}', $ctas, $output)	;
?>
<?php print $output; ?>