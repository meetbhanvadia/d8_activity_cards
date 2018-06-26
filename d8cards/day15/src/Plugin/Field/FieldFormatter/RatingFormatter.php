<?php
/**
 * @file
 * Contains \Drupal\day15\Plugin\Field\FieldFormatter\RatingFormatter.
 */

namespace Drupal\day15\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
//use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\DecimalFormatter;

/**
 * Plugin implementation of the 'rating_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "rating_formatter",
 *   label = @Translation("Display decimal field as Rating"),
 *   field_types = {
 *     "decimal"
 *   }
 * )
 */
class RatingFormatter extends DecimalFormatter {

  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements =  parent::viewElements($items, $langcode);
    foreach ($elements as &$element) {
      $element['#theme'] = 'rating_formatter';
      $element['#percentage'] = $element['#markup'];

    }

    return $elements;
  }


}
