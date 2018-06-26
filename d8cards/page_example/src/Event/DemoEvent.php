<?php

namespace Drupal\page_example\Event;
/**
 * Defines events for this module.
 */
final class DemoEvent {

  /**
   * Name of the event fired when a new incident is reported.
   *
   * This event allows modules to perform an action whenever a new incident is
   * reported via the incident report form. The event listener method receives a
   * \Drupal\events_example\Event\IncidentReportEvent instance.
   *
   * @Event
   *
   *
   * @var string
   */
  const NEW_REPORT = 'simple_page_load';

}
