<?php

	namespace App\Models;

	use App\DB;
	use mysqli;

	class Products
	{
		private mysqli $db;

		public function __construct()
		{
			$this->db = DB::get();
		}

		public function getAll(): array
		{
			$result = mysqli_query($this->db, "SELECT * FROM `products`");

			if (!$result) return [false, []];

			$products = [];
			while ($product = mysqli_fetch_assoc($result)) {
				$products[] = $product;
			}

			return [true, ['count' => count($products), 'products' => $products]];
		}

		public function get(int $id): array
		{
			$result = mysqli_query($this->db, "SELECT * FROM `products` WHERE `id` = '$id'");

			if (!$result || mysqli_num_rows($result) === 0) return [false, []];

			return [true, ['product' => mysqli_fetch_assoc($result)]];
		}

		public function add(array $product): array
		{
			$result = mysqli_query($this->db, "INSERT INTO `products` (`id`, `name`, `description`, `price`, `img`, `stock`) VALUES (NULL, '{$product['name']}', '{$product['description']}', {$product['price']}, '{$product['img']}', {$product['stock']})");

			if (!$result) return [false, []];

			return [true, ['id' => mysqli_insert_id($this->db)]];
		}

		public function update(int $id, array $product): array
		{
			$result = mysqli_query($this->db, "SELECT * FROM `products` WHERE `id` = '$id'");
			if (mysqli_num_rows($result) === 0) return [false, []];

			$result = mysqli_query($this->db, "UPDATE `products` SET `name` = '{$product['name']}', `description` = '{$product['description']}', `price` = {$product['price']}, `img` = '{$product['img']}', `stock` = {$product['stock']} WHERE `id` = '$id'");

			if (!$result) return [false, []];

			return [true, ['id' => $id]];
		}

		public function delete(int $id): array
		{
			$result = mysqli_query($this->db, "SELECT * FROM `products` WHERE `id` = '$id'");
			if (mysqli_num_rows($result) === 0) return [false, []];

			$result = mysqli_query($this->db, "DELETE FROM `products` WHERE `id` = '$id'");
			if (!$result) return [false, []];

			return [true, ['id' => $id]];
		}
	}
