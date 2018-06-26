<?php

namespace Drupal\day1\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\d8cards\Utility\DescriptionTemplateTrait;


/**
 * Controller for description page.
 *
 * This class uses the DescriptionTemplateTrait to display text we put in the
 * templates/description.html.twig file.
 */
class Day1Controller extends ControllerBase {

  use DescriptionTemplateTrait;
  /**
   * {@inheritdoc}
   */
  public function getModuleName() {
    return 'day1';
  }
}
