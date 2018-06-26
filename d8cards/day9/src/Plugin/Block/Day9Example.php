<?php

namespace Drupal\day9\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\node\NodeStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Day9 Example' block.
 *
 * @Block(
 *  id = "day9_example",
 *  admin_label = @Translation("Day9 Example"),
 * )
 */
class Day9Example extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Node storage.
   *
   * @var NodeStorageInterface
   */
  protected $nodeStorage;

  /**
   * Renderer.
   *
   * @var RendererInterface
   */
  protected $renderer;

  /**
   * Current user.
   *
   * @var AccountProxy
   */
  protected $accountProxy;

  /**
   * Construct.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    NodeStorageInterface $node_storage,
    RendererInterface $renderer,
    AccountProxy $accountProxy
  ) {
    $this->nodeStorage = $node_storage;
    $this->renderer = $renderer;
    $this->accountProxy = $accountProxy;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('entity.manager')->getStorage('node'),
      $container->get('renderer'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $ids = $this->nodeStorage->getQuery()
      ->condition('status', 1)
      ->condition('uid', $this->accountProxy->id())
      ->sort('changed', 'DESC')
      ->range(0, 5)
      ->execute();
    $nodes = $this->nodeStorage->loadMultiple($ids);
    $build['#markup'] = '';
    foreach ($nodes as $node) {
      $build['#markup'] .= '- ' . $node->label();
    }
    $build['#attached']['library'][] = 'day9/block_library';
    return $build;
  }

}
