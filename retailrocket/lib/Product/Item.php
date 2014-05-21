<?php
namespace RetailRocket\Product;


use Bitrix\Main\Loader;
use Bitrix\Sale\ProductTable;
use Bitrix\Sale\StoreProductTable;

class Item implements ItemInterface {
	private $id;
	private $quantity;
	private $price;
	private $name;
	private $previewPicture;
	private $detailPicture;
	private $url;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = (int)$id;
	}

	/**
	 * @return int
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}

	/**
	 * @param int $quantity
	 */
	public function setQuantity($quantity)
	{
		$this->quantity = (int)$quantity;
	}

	/**
	 * @return float
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @param float $price
	 */
	public function setPrice($price)
	{
		$this->price = (float)$price;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = (string)$name;
	}

	/**
	 * @return string
	 */
	public function getPreviewPicture()
	{
		return $this->previewPicture;
	}

	/**
	 * @param string $path
	 */
	public function setPreviewPicture($path)
	{
		$this->previewPicture = (string)$path;
	}

	/**
	 * @return string
	 */
	public function getDetailPicture()
	{
		return $this->detailPicture;
	}

	/**
	 * @param string $path
	 */
	public function setDetailPicture($path)
	{
		$this->detailPicture = (string)$path;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}

	/**
	 * Получает информацию о товаре из Битрикса
	 */
	public function loadItemInfo()
	{
		if (!$this->id) return;

		$elementManager = new \CIBlockElement;
		if ($info = $elementManager->GetByID($this->id)->GetNext(true, false)) {
			$this->setName($info['NAME']);
			$this->setPreviewPicture($info['PREVIEW_PICTURE']);
			$this->setDetailPicture($info['DETAIL_PICTURE']);
			$this->setUrl($info['DETAIL_PAGE_URL']);
		}

		if (Loader::includeModule('sale')) {
			$priceManager = new \CPrice;
			$price = $priceManager->GetBasePrice($this->id);
			$this->setPrice($price['PRICE']);
		}

		if (Loader::includeModule('catalog') && !$this->quantity) {
			$parameters = [
				'filter' => ['ID' => $this->id],
				'select' => ['ID', 'QUANTITY'],
			];
			$storeDb = ProductTable::getList($parameters);
			while ($arData = $storeDb->fetch()) {
				$this->quantity += (int)$arData['QUANTITY'];
			}
		}

		if ($this->quantity < 0) $this->quantity = 0;
	}
}