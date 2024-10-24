<?php

	namespace App\Controllers;

	require ROOT_DIR . 'App/Models/Articles.php';

	use App\Models;
	use App\Response;

	class Articles
	{
		public function __construct(string $method, int $id)
		{
			$modelArticle = new Models\Articles();
			switch ($method) {
				case 'GET':
					[$state, $result] = ($id) ? $modelArticle->get($id) : $modelArticle->getAll();
					$state ? Response::sendOK($result) : Response::sendError(Response::ERROR_NOT_FOUND, 'Not found');
					break;
				case 'POST':
//					$data = $this->prepareData($_POST);
					header('content-type: application/json');
					$data = $this->prepareData(json_decode(file_get_contents('php://input')));
					if (!$this->validation($data)) Response::sendError(Response::ERROR_VALIDATION, 'Unprocessable Entity');

					[$state, $result] = ($id) ? $modelArticle->update($id, $data) : $modelArticle->add($data);
					$state ? Response::sendOK($result) : Response::sendError(Response::ERROR_REQUEST, 'Bad Request');
					break;
				case 'DELETE':
					[$state, $result] = $modelArticle->delete($id);
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

		private function prepareData(array $article): array
		{
			$out = [];

			$out['name'] = $article['name'] ?? '';
			$out['description'] = $article['description'] ?? '';
			$out['img'] = $article['img'] ?? '';

			return $out;
		}
	}
