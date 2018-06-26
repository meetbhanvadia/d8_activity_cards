<?php
/**
 * Event subscriber.
 */

// Declare the namespace that our event subscriber is in. This should follow the
// PSR-4 standard, and use the EventSubscriber sub-namespace.
namespace Drupal\page_example\EventSubscriber;

// This is the interface we are going to implement.
use Drupal\page_example\Event\DemoEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscribe to DemoEvent::NEW_REPORT events and redirect if site is currently
 * in maintenance mode.
 */
class DemoSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events['simple_page_load'] = ['logMessage'];
    return $events;
  }

  /**
   * This method is called whenever the DemoEvent::NEW_REPORT event is
   * dispatched.
   */
  public function logMessage() {
    $loggerFactory = \Drupal::service('logger.factory');
    $loggerFactory->get('Simple Page')->notice('Simple Page Loaded');
  }
}
