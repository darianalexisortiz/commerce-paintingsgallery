/**
 * @file
 * Mavacuadros Theme JS.
 */
(function ($) {

  'use strict';

  /**
   * Filter behaviour.
   */
  Drupal.behaviors.RegionFilters = {
    attach: function (context, settings) {
      $('.btn-filters').click(function () {
        $('.region-filters').addClass('f-open');
      });
      $('.region-filters .btn-close').click(function () {
        $('.region-filters').removeClass('f-open');
      });
    }
  };

  Drupal.behaviors.General = {
    attach: function (context, settings) {
      $('.field--name-price').each(function (index) {
        if ($(this).text() === '$ 0,00') {
          $(this).text('Consultar precio');
        }
      });
      $('.field--name-price .field--item').each(function (index) {
        if ($(this).text() === '$ 0,00') {
          $(this).text('Consultar precio');
        }
      });
      $('.cart-block--offcanvas-cart-table__price').each(function (index) {
        if ($(this).text() === '$ 0,00') {
          $(this).text('Consultar precio');
        }
      });
    }
  };
})(jQuery);
