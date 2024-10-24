<?php

	const ROOT_DIR = __DIR__ . '/';

	require ROOT_DIR . 'setting.php';
	require ROOT_DIR . 'App/DB.php';
	require ROOT_DIR . 'App/Route.php';

	App\DB::connect();
	App\Route::run();
