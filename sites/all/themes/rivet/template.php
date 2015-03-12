<?php

/**
 * Implements template_preprocess_html().
 *
 */
/*function rivet_preprocess_html(&$variables) {
	if ( isset($variables['page']['content']['system_main']['nodes']) ) {
		$nodes = $variables['page']['content']['system_main']['nodes'];
		foreach( $nodes as &$node ) {
			$node = $node['#node'];
			if ( isset( $node ) && $node->type == "article" ) {
				if ( $node->field_type['und'][0]['value'] == "press" ) {
					$variables['classes_array'][] = 'node-article-type-press';
				}
			}
		}
	}
}*/

/**
 * Implements template_preprocess_page
 *
 */
function rivet_preprocess_page(&$variables) {

    // Convenience variables
    if (!empty($variables['page']['sidebar_first'])){
    	$left = $variables['page']['sidebar_first'];
    }

    if (!empty($variables['page']['sidebar_second'])) {
    	$right = $variables['page']['sidebar_second'];
    }	

    // Dynamic sidebars	
    if (!empty($left) && !empty($right)) {
    	$variables['main_grid_class'] = 'large-6 large-push-3';
    	$variables['sidebar_first_grid_class'] = 'large-3 large-pull-9';
    	$variables['sidebar_sec_grid_class'] = 'large-3';
    } elseif (empty($left) && !empty($right)) {
    	$variables['main_grid_class'] = ( drupal_is_front_page() ? 'large-8' : 'large-9' );
    	$variables['sidebar_first_grid_class'] = '';
    	$variables['sidebar_sec_grid_class'] = ( drupal_is_front_page() ? 'large-4' : 'large-3' );
    } elseif (!empty($left) && empty($right)) {
    	$variables['main_grid_class'] = ( drupal_is_front_page() ? 'large-8 large-push-4' : 'large-8 large-push-4' );
    	$variables['sidebar_first_grid_class'] = ( drupal_is_front_page() ? 'large-4 large-pull-8' : 'large-4 large-pull-8' );
    	$variables['sidebar_sec_grid_class'] = '';
    } else {
    	$variables['main_grid_class'] = 'large-12';
    	$variables['sidebar_first_grid_class'] = '';
    	$variables['sidebar_sec_grid_class'] = '';
    } 
    
    if ( arg(0) == "node" && is_numeric(arg(1)) ) {
	    $node = node_load( arg(1) );
	    if ( $node->type == "article" ) {
		    $right_bar = $variables['page']['sidebar_second'];
		    unset( $variables['page']['sidebar_second'] );
		    $variables['page']['content']['system_main']['nodes'][arg(1)]['sidebar_second'] = $right_bar;
		    $variables['page']['is_article_page'] = TRUE;
	    }
    }
    

    /*if ( isset($variables['page']['content']['system_main']['nodes']) ) {
	    $nodes = $variables['page']['content']['system_main']['nodes'];
	    foreach ( $nodes as &$node ) {
		    $node = $node['#node'];
		    if ( isset($node) && $node->type == "article" && strtolower($node->field_type['und'][0]['value']) == "info" ) {
			    if ( !isset($_COOKIE["accessarticles"]) || $_COOKIE["accessarticles"] != 1 ) {
				    print 'r' . $_COOKIE["accessarticles"] . 'r';
				    //drupal_goto('articles-infographics');
			    }
			    //drupal_add_js(array('infoArticlePage' => true), 'setting');  
		    }
	    }
    }*/
}

/**
 * Implements template_preprocess_node
 *
 */
function rivet_preprocess_node(&$variables) {  
	if ( $variables['nid'] == 38 ) {
		$variables['attributes_array']["data-shortname"] = "careers";
	} 
	
	/*if ( $variables['type'] == "article" && !isset($_COOKIE['accessarticles']) ) {
		print_r($_COOKIE);
		//drupal_goto('articles-infographics');
	}*/
}

/**
 * Implements hook_preprocess_block()
 */
/*function rivet_preprocess_block(&$variables) {

}*/
//function rivet_preprocess_views_view(&$variables) {
//}

/**
 * Implements template_preprocess_panels_pane().
 *
 */
//function rivet_preprocess_panels_pane(&$variables) {
//}

/**
 * Implements template_preprocess_views_views_fields().
 *
 */
//function rivet_preprocess_views_view_fields(&$variables) {
//}

/**
 * Implements theme_form_element_label()
 * Use foundation tooltips
 */
//function rivet_form_element_label($variables) {
//  if (!empty($variables['element']['#title'])) {
//	$variables['element']['#title'] = '<span class="secondary label">' . $variables['element']['#title'] . '</span>';
//  }
//  if (!empty($variables['element']['#description'])) {
//	$variables['element']['#description'] = ' <span data-tooltip="top" class="has-tip tip-top" data-width="250" title="' . $variables['element']['#description'] . '">' . t('More information?') . '</span>';
//  }
//  return theme_form_element_label($variables);
//}

/**
 * Implements hook_preprocess_button().
 */
//function rivet_preprocess_button(&$variables) {
//  $variables['element']['#attributes']['class'][] = 'button';
//  if (isset($variables['element']['#parents'][0]) && $variables['element']['#parents'][0] == 'submit') {
//	$variables['element']['#attributes']['class'][] = 'secondary';
//  }
//}

/**
 * Implements hook_form_alter()
 * Example of using foundation sexy buttons
 */
/*function rivet_form_alter(&$form, &$form_state, $form_id) {
  // Sexy submit buttons

  if ( isset($form['actions']['submit']['#attributes']) ) {
	  if ( $key = array_search ('radius', $form['actions']['submit']['#attributes']['class'] ) ) {
		  unset( $form['actions']['submit']['#attributes']['class'][$key] );
	  }
  }
  
  //if (!empty($form['actions']) && !empty($form['actions']['submit'])) {
//	$classes = (is_array($form['actions']['submit']['#attributes']['class'])) ? $form['actions']['submit']['#attributes']['class'] : array();
//	$classes = array_merge($classes, array('secondary', 'button'));
//	$form['actions']['submit']['#attributes']['class'] = $classes;
  }
}

/**
 * Implements hook_form_FORM_ID_alter()
 * Example of using foundation sexy buttons on comment form
 */
//function rivet_form_comment_form_alter(&$form, &$form_state) {
  // Sexy preview buttons
//  $classes = (is_array($form['actions']['preview']['#attributes']['class']))
//	? $form['actions']['preview']['#attributes']['class']
//	: array();
//  $classes = array_merge($classes, array('secondary', 'button', 'radius'));
//  $form['actions']['preview']['#attributes']['class'] = $classes;
//}


/**
 * Implements template_preprocess_panels_pane().
 */
// function zurb_foundation_preprocess_panels_pane(&$variables) {
// }

/**
* Implements template_preprocess_views_views_fields().
*/
/* Delete me to enable
function rivet_preprocess_views_view_fields(&$variables) {
 if ($variables['view']->name == 'nodequeue_1') {

   // Check if we have both an image and a summary
   if (isset($variables['fields']['field_image'])) {

	 // If a combined field has been created, unset it and just show image
	 if (isset($variables['fields']['nothing'])) {
	   unset($variables['fields']['nothing']);
	 }

   } elseif (isset($variables['fields']['title'])) {
	 unset ($variables['fields']['title']);
   }

   // Always unset the separate summary if set
   if (isset($variables['fields']['field_summary'])) {
	 unset($variables['fields']['field_summary']);
   }
 }
}

// */

/**
 * Implements hook_css_alter().
 */
//function rivet_css_alter(&$css) {
//  // Always remove base theme CSS.
//  $theme_path = drupal_get_path('theme', 'zurb_foundation');
//
//  foreach($css as $path => $values) {
//	if(strpos($path, $theme_path) === 0) {
//	  unset($css[$path]);
//	}
//  }
//}

/**
 * Implements hook_js_alter().
 */
//function rivet_js_alter(&$js) {
//  // Always remove base theme JS.
//  $theme_path = drupal_get_path('theme', 'zurb_foundation');
//
//  foreach($js as $path => $values) {
//	if(strpos($path, $theme_path) === 0) {
//	  unset($js[$path]);
//	}
//  }
//}



/**
 * Implements theme_breadcrumb().
 */
function rivet_breadcrumb(&$variables) {
	if ( !theme_get_setting('toggle_breadcrumbs', 'rivet') ) { 
		unset($variables);
	}
}


function rivet_textfield($variables) {
	$element = $variables['element'];
	$element['#attributes']['type'] = 'text';
	if ( isset($element['#title']) ) { $element['#attributes']['placeholder'] = $element['#title']; }
	element_set_attributes($element, array('id', 'name', 'value', 'size', 'maxlength'));
	_form_set_class($element, array('form-text'));
	
	$extra = '';
	if ($element['#autocomplete_path'] && drupal_valid_path($element['#autocomplete_path'])) {
	  drupal_add_library('system', 'drupal.autocomplete');
	  $element['#attributes']['class'][] = 'form-autocomplete';
	
	  $attributes = array();
	  $attributes['type'] = 'hidden';
	  $attributes['id'] = $element['#attributes']['id'] . '-autocomplete';
	  $attributes['value'] = url($element['#autocomplete_path'], array('absolute' => TRUE));
	  $attributes['disabled'] = 'disabled';
	  $attributes['class'][] = 'autocomplete';
	  $extra = '<input' . drupal_attributes($attributes) . ' />';
	}
	
	$output = '<input' . drupal_attributes($element['#attributes']) . ' />';
	
	return $output . $extra;
}




function rivet_textarea($variables) {
	$element = $variables['element'];
	element_set_attributes($element, array('id', 'name', 'cols', 'rows'));
	_form_set_class($element, array('form-textarea'));
	
	$wrapper_attributes = array(
	  'class' => array('form-textarea-wrapper'),
	);
	
	
	if ( isset($element['#title']) ) { $element['#attributes']['placeholder'] = $element['#title']; }	
	  
	// Add resizable behavior.
	if (!empty($element['#resizable'])) {
	  drupal_add_library('system', 'drupal.textarea');
	  $wrapper_attributes['class'][] = 'resizable';
	}
	
	$output = '<div' . drupal_attributes($wrapper_attributes) . '>';
	$output .= '<textarea' . drupal_attributes($element['#attributes']) . '>' . check_plain($element['#value']) . '</textarea>';
	$output .= '</div>';
	return $output;	
}

function rivet_webform_email($variables) {
	$element = $variables['element'];
	
	// This IF statement is mostly in place to allow our tests to set type="text"
	// because SimpleTest does not support type="email".
	if (!isset($element['#attributes']['type'])) {
	  $element['#attributes']['type'] = 'email';
	}
	
	if ( isset($element['#title']) ) { $element['#attributes']['placeholder'] = $element['#title']; }
	
	
	// Convert properties to attributes on the element if set.
	foreach (array('id', 'name', 'value', 'size') as $property) {
	  if (isset($element['#' . $property]) && $element['#' . $property] !== '') {
	    $element['#attributes'][$property] = $element['#' . $property];
	  }
	}
	_form_set_class($element, array('form-text', 'form-email'));
	
	return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

/*function rivet_file($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'file';
  element_set_attributes($element, array('id', 'name', 'size'));
  _form_set_class($element, array('form-file'));

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}*/

function rivet_form_element_label($variables) { 
	$element = $variables['element'];
	// This is also used in the installer, pre-database setup.
	$t = get_t();
	
	// If title and required marker are both empty, output no label.
	if ((!isset($element['#title']) || $element['#title'] === '') && empty($element['#required'])) {
	  return '';
	}
	
	// If the element is required, a required marker is appended to the label.
	$required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';
	
	$title = filter_xss_admin($element['#title']);
	
	$attributes = array();
	$class = array();
	
	// Style the label as class option to display inline with the element.
	if ($element['#title_display'] == 'after') {
	  $class[] = 'option';
	}
	// Show label only to screen readers to avoid disruption in visual flows.
	elseif ($element['#title_display'] == 'invisible') {
	  $class[] = 'element-invisible';
	}
	
	if (!empty($element['#id'])) {
	  $attributes['for'] = $element['#id'];
	}
	
	if ( $element['#type'] == "managed_file" ) {
		$class[] = "button";
		$class[] = "secondary";
	}
	
	if ( count($class) ) {
		$attributes['class'] = implode(" ", $class);
	}
	
	// The leading whitespace helps visually separate fields from inline labels.
	return ' <label' . drupal_attributes($attributes) . '>' . $t('!title !required', array('!title' => $title, '!required' => $required)) . "</label>\n";
}

function rivet_file($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'file';
  element_set_attributes($element, array('id', 'name', 'size'));
  _form_set_class($element, array('form-file'));

  if ( strpos( $element['#id'], 'cover-letter' ) || strpos( $element['#id'], 'resume' ) ) {
  	_form_set_class($element, array('required'));
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}