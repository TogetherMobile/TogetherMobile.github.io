<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
 $count = count($rows);
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>


<div class="slide">
<?php foreach ($rows as $id => $row): ?>
<?php if (($id + 1) == $count) { $classes_array[$id] .= " end"; } ?>
<?php if ( (($id % 6) == 0) && $id != 0) { print '</div><div class="slide">'; } ?>

  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
</div>