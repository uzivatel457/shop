<?php

declare(strict_types=1);

namespace App\Model\Product;

use Nette;

final class ProductFacade
{
	use Nette\SmartObject;

	private Nette\Database\Explorer $database;


	public function __construct(Nette\Database\Explorer $database)
	{
		$this->database = $database;
	}


	public function getProducts()
	{
		return $this->database
			->table('product');
	}


	public function getProductById(int $productId)
	{
		return $this->database
			->table('product')
			->where('id', $productId);
	}
}