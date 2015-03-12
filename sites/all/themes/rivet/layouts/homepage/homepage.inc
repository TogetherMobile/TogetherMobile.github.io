<?php

/**
 * Implements hook_panels_layouts()
 */
function rivet_homepage_panels_layouts() {
  $items['homepage'] = array(
    'title' => t('Rivet Homepage'),
    'category' => t('Homepage'),
    'icon' => 'foundation_1col.png',
    'theme' => 'homepage',
    //'admin css' => '../foundation_panels_admin.css',
    'regions' => array('middle' => t('Main column')),
  );
  return $items;
}

