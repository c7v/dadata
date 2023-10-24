<?php

namespace c7v\dadata;

use GuzzleHttp\Client;

abstract class BaseRequester
{
	/**
	 * @var Client Http client.
	 */
	protected static Client $_httpClient;

	/**
	 * @var array Http options.
	 */
	protected static array $_httpOptions;

	/**
	 * @param Client $client
	 * @return void
	 */
	public static function setHttpClient(Client $client): void
	{
		self::$_httpClient = $client;
	}

	/**
	 * @param array $options
	 * @return void
	 */
	public static function setHttpOptions(array $options): void
	{
		self::$_httpOptions = $options;
	}
}