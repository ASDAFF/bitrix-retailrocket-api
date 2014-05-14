<?php
namespace RetailRocket\Js;

use RetailRocket\Config;
use RetailRocket\Product\ItemInterface;
use RetailRocket\Product\ItemListInterface;
use RetailRocket\Widget\WidgetInterface;

final class TrackingCode
{
	/**
	 * Основной код трекинг системы
	 * На всех страницах сайта должен быть установлен трекинг код системы
	 * @return string
	 */
	public static function showGeneralCode()
	{
		return sprintf(
			"<script type='text/javascript'>
				var rrPartnerId = '%s';
				var rrApi = {};
				var rrApiOnReady = rrApiOnReady || [];
				rrApi.addToBasket = rrApi.order = rrApi.categoryView = rrApi.view =
			   		rrApi.recomMouseDown = rrApi.recomAddToCart = function() {};
				(function(d) {
					var ref = d.getElementsByTagName('script')[0];
					var apiJs, apiJsId = 'rrApi-jssdk';
					if (d.getElementById(apiJsId)) return;
					apiJs = d.createElement('script');
					apiJs.id = apiJsId;
					apiJs.async = true;
					apiJs.src = '//cdn.retailrocket.ru/content/javascript/api.js';
					ref.parentNode.insertBefore(apiJs, ref);
				}(document));
			</script>",
			Config::getPartnerId()
		);
	}

	/**
	 * Код обработчика просмотра карточек товаров
	 * На всех страницах карточек товаров необходимо установить товарный трекинг код
	 * @param int $productId
	 * @return string
	 */
	public static function showProductCode($productId)
	{
		return sprintf(
			"<script type='text/javascript'>
				function rrAsyncInit() {
					try{ rrApi.view(%d); } catch(e) {}
				}
			</script>",
			$productId
		);
	}

	/**
	 * Код обработчика просмотра страницы товарной категории
	 * На всех страницах товарных категорий необходимо установить следующий код
	 * @param int $categoryId
	 * @return string
	 */
	public static function showCategoryCode($categoryId)
	{
		return sprintf(
			"<script type='text/javascript'>
				function rrAsyncInit() {
					try { rrApi.categoryView(%d); } catch(e) {}
				}
			</script>",
			$categoryId
		);
	}

	/**
	 * Код обработчика добавления товаров в корзину
	 * На кнопках, нажатие которых приводит к добавлению товара в корзину, необходимо установить обработчик событий
	 * @param int $productId
	 * @return string
	 * @example <div class="buy" onmousedown="<?php echo \RetailRocket\Js\TrackingCode::showToBasketActionCode(<product_id>) ?>"></div>
	 */
	public static function showToBasketActionCode($productId)
	{
		return sprintf('try { rrApi.addToBasket(%d) } catch(e) {}', $productId);
	}

	/**
	 * Добавление товара в корзину из блока с рекомендациями
	 * Если пользователь добавляет в корзину рекомендованный системой товар
	 * @param ItemInterface $product
	 * @param WidgetInterface $widget
	 * @return string
	 * @example <a href="#" onclick="<?php echo \RetailRocket\Js\TrackingCode::showWidgetToBasketActionCode(<product>, <widget>) ?>"></a>
	 */
	public static function showWidgetToBasketActionCode(ItemInterface $product, WidgetInterface $widget)
	{
		return sprintf(
			"try { rrApi.recomAddToCart(%d, {methodName: '%s'}) } catch (e) {}",
			$product->getId(),
			$widget->getType()
		);
	}

	/**
	 * Клик по гиперссылке с товарной рекомендацией
	 * Все гиперссылки, относящиеся к рекомендуемому товару в блоках с товарными рекомендациями,
	 * сформированные системой и указывающие на карточку товара
	 * @param ItemInterface $product
	 * @param WidgetInterface $widget
	 * @return string
	 * @example <a href="#" onclick="<?php echo \RetailRocket\Js\TrackingCode::showWidgetToBasketActionCode(<product>, <widget>) ?>"></a>
	 */
	public static function showWidgetClickToDetailPageCode(ItemInterface $product, WidgetInterface $widget)
	{
		return sprintf(
			"try { rrApi.recomMouseDown(%d, {methodName: '%s'}) } catch (e) {}",
			$product->getId(),
			$widget->getType()
		);
	}

	/**
	 * Код обработчика совершения транзакции
	 * На финальной странице оформления заказа необходимо установить обработчик совершения транзакции
	 * @param int $orderId
	 * @param ItemListInterface $products
	 * @return string
	 */
	public static function showOrderConfirmCode($orderId, ItemListInterface $products)
	{
		$items = [];

		if ($products) {
			foreach ($products->getList() as $product) {
				$items[] = sprintf(
					'{ id: %d, qnt: %d,  price: %g }',
					$product->getId(),
					$product->getQuantity(),
					$product->getPrice()
				);
			}
		}

		return sprintf(
			"<script type='text/javascript'>
				function rrAsyncInit() {
					try {
						rrApi.order({
							transaction: %d,
							items: [%s]
						});
					} catch(e) {}
				}
			</script>",
			$orderId,
			implode(',', $items)
		);
	}

	/**
	 * Показ товарных рекомендаций
	 * Для повышения качества рекомендаций в систему Retail Rocket необходимо
	 * передавать данные о показе рекомендаций с помощью метода recomTrack
	 * @param WidgetInterface $widget
	 * @param ItemListInterface $items
	 * @return string
	 */
	public static function showRecommendedTrackCode(WidgetInterface $widget, ItemListInterface $items = null) {
		return sprintf(
			"<script type='text/javascript'>
				try {
					rrApi.recomTrack('%s', %s, [%s]);
				} catch(e) {}
			</script>",
			$widget->getType(),
			$widget->getUser(),
			$items ? implode(',', $items->getIdAll()) : ''
		);
	}

	/**
	 * Вывод объекта как строку
	 * @return string
	 * @example echo new \RetailRocket\Js\TrackingCode;
	 */
	public function __toString()
	{
		return self::showGeneralCode();
	}
}