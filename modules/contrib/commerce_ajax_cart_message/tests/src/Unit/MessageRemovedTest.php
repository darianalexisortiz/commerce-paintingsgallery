<?php

namespace Drupal\Tests\commerce_ajax_cart_message\Unit;

use Drupal\commerce\PurchasableEntityInterface;
use Drupal\commerce_ajax_cart_message\EventSubscriber\CommerceAjaxCartMessageSubscriber;
use Drupal\commerce_cart\Event\CartEntityAddEvent;
use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Messenger\Messenger;
use Drupal\Core\Routing\UrlGenerator;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Test.
 *
 * @group commerce_ajax_cart_message
 */
class MessageRemovedTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() : void {
    parent::setUp();
    $container = new ContainerBuilder();
    $container->set('url_generator', $this->createMock(UrlGenerator::class));
    \Drupal::setContainer($container);
  }

  /**
   * Helper.
   */
  protected function getRequestStack($is_ajax = FALSE) {
    $mock_request = $this->createMock(Request::class);
    $mock_request->method('isXmlHttpRequest')
      ->willReturn($is_ajax);
    $mock_request_stack = $this->createMock(RequestStack::class);
    $mock_request_stack->method('getCurrentRequest')
      ->willReturn($mock_request);
    return $mock_request_stack;
  }

  /**
   * Helper.
   */
  protected function getMessenger($is_ajax) {
    $mock_messenger = $this->createMock(Messenger::class);
    $mock_messenger->expects($is_ajax ? $this->never() : $this->once())
      ->method('addMessage');
    return $mock_messenger;
  }

  /**
   * Test that message is displayed and removed based on the ajax.
   *
   * @dataProvider getAjaxVariations
   */
  public function testMessageLogic($is_ajax) {
    $mock_messenger = $this->getMessenger($is_ajax);
    $mock_translation = $this->createMock(TranslationInterface::class);
    $mock_request_stack = $this->getRequestStack($is_ajax);
    $subscriber = new CommerceAjaxCartMessageSubscriber($mock_messenger, $mock_translation, $mock_request_stack);
    $order = $this->createMock(OrderInterface::class);
    $entity = $this->createMock(PurchasableEntityInterface::class);
    $order_item = $this->createMock(OrderItemInterface::class);
    $event = new CartEntityAddEvent($order, $entity, 1, $order_item);
    $subscriber->displayAddToCartMessage($event);
  }

  /**
   * A dataprovider.
   */
  public function getAjaxVariations() {
    return [
      [TRUE],
      [FALSE],
    ];
  }

}
