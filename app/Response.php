<?php

	namespace App;

	abstract class Response
	{
		const OK						= 200;
		const ERROR_REQUEST				= 400;
		const ERROR_NOT_FOUND			= 404;
		const ERROR_VALIDATION			= 422;

		static public function send(string $code, array $description): never
		{
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Headers: *');
			header('Access-Control-Allow-Methods: true');
			header('Content-Type: application/json');

			http_response_code($code);
			echo json_encode($description);
			die;
		}

		static public function sendError(string $code, string $message): void
		{
			self::send($code, ['error' => $message]);
		}

		static public function sendOK(array $data): void
		{
			self::send(self::OK, $data);
		}
	}
