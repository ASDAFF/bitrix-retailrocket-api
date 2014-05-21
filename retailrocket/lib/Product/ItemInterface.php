<?php
namespace RetailRocket\Product;


interface ItemInterface
{
	/**
	 * @return int
	 */
	public function getId();

	/**
	 * @param int $id
	 */
	public function setId($id);

	/**
	 * @return int
	 */
	public function getQuantity();

	/**
	 * @param int $quantity
	 */
	public function setQuantity($quantity);

	/**
	 * @return float
	 */
	public function getPrice();

	/**
	 * @param float $price
	 */
	public function setPrice($price);

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @param string $name
	 */
	public function setName($name);

	/**
	 * @return string
	 */
	public function getPreviewPicture();

	/**
	 * @param string $path
	 */
	public function setPreviewPicture($path);

	/**
	 * @return string
	 */
	public function getDetailPicture();

	/**
	 * @param string $path
	 */
	public function setDetailPicture($path);

	/**
	 * @return string
	 */
	public function getUrl();

	/**
	 * @param string $url
	 */
	public function setUrl($url);

	/**
	 * Получает информацию о товаре из Битрикса
	 */
	public function loadItemInfo();
}