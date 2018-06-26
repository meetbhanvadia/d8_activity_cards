<?php

namespace Drupal\page_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\page_example\Event\DemoEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\d8cards\Utility\DescriptionTemplateTrait;

/**
 * Controller routines for page example routes.
 */
class PageExampleController extends ControllerBase {

  use DescriptionTemplateTrait;

  /**
   * The Event dispatcher service
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * The Event dispatcher service
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;
  /**
   * PageExampleController constructor.
   *
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   */
  public function __construct(EventDispatcherInterface $eventDispatcher,LoggerChannelFactoryInterface $loggerFactory) {
    $this->eventDispatcher = $eventDispatcher;
    $this->loggerFactory = $loggerFactory;
  }

  public static function create(ContainerInterface $container) {
    $eventDispatcher = $container->get('event_dispatcher');
    $loggerFactory = $container->get('logger.factory');
    return new static(
      $eventDispatcher,
      $loggerFactory);
  }

  /**
   * {@inheritdoc}
   */
  protected function getModuleName() {
    return 'page_example';
  }

  /**
   * Constructs a simple page.
   *
   * The router _controller callback, maps the path
   * 'examples/page-example/simple' to this method.
   *
   * _controller callbacks return a renderable array for the content area of the
   * page. The theme system will later render and surround the content with the
   * appropriate blocks, navigation, and styling.
   */
  public function simple() {
    $this->loggerFactory->get('page_example_module')->notice('Simple page was displayed from logger factory service');

    $event = new Event();
    $this->eventDispatcher->dispatch(DemoEvent::NEW_REPORT,$event);
    return [
      '#markup' => '<p>' . $this->t('Simple page: The quick brown fox jumps over the lazy dog.') . '</p>',
    ];
  }

  /**
   * A more complex _controller callback that takes arguments.
   *
   * This callback is mapped to the path
   * 'examples/page-example/arguments/{first}/{second}'.
   *
   * The arguments in brackets are passed to this callback from the page URL.
   * The placeholder names "first" and "second" can have any value but should
   * match the callback method variable names; i.e. $first and $second.
   *
   * This function also demonstrates a more complex render array in the returned
   * values. Instead of rendering the HTML with theme('item_list'), content is
   * left un-rendered, and the theme function name is set using #theme. This
   * content will now be rendered as late as possible, giving more parts of the
   * system a chance to change it if necessary.
   *
   * Consult @link http://drupal.org/node/930760 Render Arrays documentation
   * @endlink for details.
   *
   * @param string $first
   *   A string to use, should be a number.
   * @param string $second
   *   Another string to use, should be a number.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
   *   If the parameters are invalid.
   */
  public function arguments($first, $second) {
    // Make sure you don't trust the URL to be safe! Always check for exploits.
    if (!is_numeric($first) || !is_numeric($second)) {
      // We will just show a standard "access denied" page in this case.
      throw new AccessDeniedHttpException();
    }

    $list[] = $this->t("First number was @number.", ['@number' => $first]);
    $list[] = $this->t("Second number was @number.", ['@number' => $second]);
    $list[] = $this->t('The total was @number.', ['@number' => $first + $second]);

    $render_array['page_example_arguments'] = [
      // The theme function to apply to the #items.
      '#theme' => 'item_list',
      // The list itself.
      '#items' => $list,
      '#title' => $this->t('Argument Information'),
    ];
    return $render_array;
  }

}
