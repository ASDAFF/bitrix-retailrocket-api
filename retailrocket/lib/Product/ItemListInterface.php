<?php

namespace RetailRocket\Product;


interface ItemListInterface
{
	/**
	 * @return ItemInterface[]
	 */
	public function getList();

	/**
	 * @return int[]
	 */
	public function getIdAll();

	public function add(ItemInterface $item);
} 