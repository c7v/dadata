<?php

namespace c7v\dadata\helpers;

class StyleData
{
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

	public static function normalDate(int $time): string
	{
		return date('d.m.Y', substr($time,0,-3));
	}

	public static function normalManagementPost(string $post, $charset = "utf-8"): string
	{
		$post = mb_strtolower($post, 'utf-8');
		return mb_strtoupper(mb_substr($post, 0, 1, $charset), $charset).mb_substr($post, 1, mb_strlen($post, $charset)-1, $charset);
	}

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