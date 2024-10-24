<?php

	namespace App\Controllers;

	require ROOT_DIR . 'App/Models/Products.php';

	use App\Models;
	use App\Response;

	class Products
	{
		public function __construct(string $method, int $id)
		{
			$modelProduct = new Models\Products();
			switch ($method) {
				case 'GET':
					[$state, $result] = ($id) ? $modelProduct->get($id) : $modelProduct->getAll();
					$state ? Response::sendOK($result) : Response::sendError(Response::ERROR_NOT_FOUND, 'Not found');
					break;
				case 'POST':
					$data = $this->prepareData($_POST);
//					header('content-type: application/json');
//					$data = $this->prepareData(json_decode(file_get_contents('php://input'), true));
					if (!$this->validation($data)) Response::sendError(Response::ERROR_VALIDATION, 'Unprocessable Entity');

					[$state, $result] = ($id) ? $modelProduct->update($id, $data) : $modelProduct->add($data);
					$state ? Response::sendOK($result) : Response::sendError(Response::ERROR_REQUEST, 'Bad Request');
					break;
				case 'DELETE':
					[$state, $result] = $modelProduct->delete($id);
					$state ? Response::sendOK($result) : Response::sendError(Response::ERROR_REQUEST, 'Bad Request');
					break;
				default: Response::sendError(Response::ERROR_REQUEST, 'Bad Request');
			}
		}

		private function validation(array $data): bool
		{
			if ($data['name'] === '') return false;
			if ($data['description'] === '') return false;

			return true;
		}

		private function prepareData(array $product): array
		{
			$out = [];

			$out['name'] = $product['name'] ?? '';
			$out['description'] = $product['description'] ?? '';
			$out['price'] = $product['price'] ?? null;
			$out['img'] = $product['img'] ?? '';
			$out['stock'] = $product['stock'] ?? null;

			return $out;
		}
	}
