<?php

namespace c7v\dadata\helpers;

/**
 * @author Артём Соколовский <dev.sokolovsky@gmail.com>
 */
class StyleData
{
    /**
     * @param string $string Название компании.
     * @return string
     */
	public static function normalQuotes(string $string): string
	{
		return preg_replace([
			"/\s\"/",
			"/\"$/",
		], [
			' «',
			'»',
		], $string);
	}

    /**
     * @param int $time Метка времени.
     * @return string
     */
	public static function normalDate(int $time): string
	{
		return date('d.m.Y', substr($time,0,-3));
	}

    /**
     * @param string $post Должность
     * @param string $charset Кодировка строки
     * @return string
     */
	public static function normalManagementPost(string $post, string $charset = "utf-8"): string
	{
		$post = mb_strtolower($post, 'utf-8');
		return mb_strtoupper(mb_substr($post, 0, 1, $charset), $charset).mb_substr($post, 1, mb_strlen($post, $charset)-1, $charset);
	}

    /**
     * @param string $name ФИО строкой.
     * @return array
     */
	public static function explodeName(string $name): array
	{
		$array = explode(' ', $name);
		return [
			'last_name' => $array[0],
			'first_name' => $array[1],
			'nick_name' => $array[2] ?? null,
		];
	}
}