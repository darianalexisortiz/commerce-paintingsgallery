<?php

namespace Drupal\Tests\commerce_ajax_cart_message\Kernel;

use Drupal\commerce_ajax_cart_message\EventSubscriber\CommerceAjaxCartMessageSubscriber;
use Drupal\KernelTests\KernelTestBase;

/**
 * Test.
 *
 * @group commerce_ajax_cart_message
 */
class SubscriberReplacedTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'commerce_ajax_cart_message',
    'commerce_cart',
    'commerce_store',
  ];

  /**
   * Test that the subscriber is swapped.
   */
  public function testSubscriberSwapped() {
    $subscriber = $this->container->get('commerce_cart.cart_subscriber');
    $this->assertInstanceOf(CommerceAjaxCartMessageSubscriber::class, $subscriber);
  }

}
