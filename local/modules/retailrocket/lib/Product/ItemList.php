<?php

namespace RetailRocket\Product;


class ItemList implements ItemListInterface {
	/** @var ItemInterface[] $items */
	private $items = [];

	/**
	 * @return ItemInterface[]
	 */
	public function getList()
	{
		return $this->items;
	}

	/**
	 * @return int[]
	 */
	public function getIdAll()
	{
		$arId = [];
		foreach ($this->items as $item) {
			$arId[] = $item->getId();
		}

		return $arId;
	}

	/**
	 * @param ItemInterface $item
	 */
	public function add(ItemInterface $item)
	{
		$this->items[] = $item;
	}
}