<?php

	namespace App;
	use mysqli;

	abstract class DB
	{
		public static mysqli $connect;

		static public function connect(): void
		{
			self::$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		}

		static public function get(): mysqli
		{
			return self::$connect;
		}
	}
