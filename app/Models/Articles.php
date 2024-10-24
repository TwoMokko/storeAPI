<?php

	namespace App\Models;

	use App\DB;
	use mysqli;

	class Articles
	{
		private mysqli $db;

		public function __construct()
		{
			$this->db = DB::get();
		}

		public function getAll(): array
		{
			$result = mysqli_query($this->db, "SELECT * FROM `articles`");

			if (!$result) return [false, []];

			$articles = [];
			while ($article = mysqli_fetch_assoc($result)) {
				$articles[] = $article;
			}

			return [true, ['count' => count($articles), 'articles' => $articles]];
		}

		public function get(int $id): array
		{
			$result = mysqli_query($this->db, "SELECT * FROM `articles` WHERE `id` = '$id'");

			if (!$result || mysqli_num_rows($result) === 0) return [false, []];

			return [true, ['article' => mysqli_fetch_assoc($result)]];
		}

		public function add(array $article): array
		{
			$result = mysqli_query($this->db, "INSERT INTO `articles` (`id`, `name`, `description`, `price`, `img`, `stock`) VALUES (NULL, '{$article['name']}', '{$article['description']}', '{$article['img']}')");

			if (!$result) return [false, []];

			return [true, ['id' => mysqli_insert_id($this->db)]];
		}

		public function update(int $id, array $article): array
		{
			$result = mysqli_query($this->db, "SELECT * FROM `articles` WHERE `id` = '$id'");
			if (mysqli_num_rows($result) === 0) return [false, []];

			$result = mysqli_query($this->db, "UPDATE `articles` SET `name` = '{$article['name']}', `description` = '{$article['description']}', `img` = '{$article['img']}' WHERE `id` = '$id'");

			if (!$result) return [false, []];

			return [true, ['id' => $id]];
		}

		public function delete(int $id): array
		{
			$result = mysqli_query($this->db, "SELECT * FROM `articles` WHERE `id` = '$id'");
			if (mysqli_num_rows($result) === 0) return [false, []];

			$result = mysqli_query($this->db, "DELETE FROM `articles` WHERE `id` = '$id'");
			if (!$result) return [false, []];

			return [true, ['id' => $id]];
		}
	}
