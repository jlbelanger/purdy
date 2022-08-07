<?php

namespace Jlbelanger;

class Purdy
{
	/**
	 * @param  string $s
	 * @return string
	 */
	public static function convert(string $s) : string
	{
		// Replace HTML tags with temporary tokens so we don't add entities inside attributes.
		$output = static::replaceTagsWithTokens($s);
		$s = $output['value'];

		$s = static::ampersands($s);
		$s = static::sizes($s);
		$s = static::singleQuotes($s);
		$s = static::ellipses($s);
		$s = static::fractions($s);
		$s = static::dashes($s);
		$s = static::quotes($s);

		// Replace temporary tokens with the original HTML tags.
		$s = static::replaceTokensWithTags($output['tokens'], $s);

		return $s;
	}

	/**
	 * @param  string $s
	 * @return array
	 */
	public static function replaceTagsWithTokens(string $s) : array
	{
		$tokens = [];
		if (preg_match_all('/<([^ >]+) [^>]+>/', $s, $matches)) {
			$i = 0;
			foreach ($matches[0] as $i => $tag) {
				$element = $matches[1][$i];
				$token = '<' . $element . ' %token_' . $i . '%>';
				$tokens[$token] = $tag;
				$s = str_replace($tag, $token, $s);
			}
		}
		return [
			'tokens' => $tokens,
			'value' => $s,
		];
	}

	/**
	 * @param  array  $tokens
	 * @param  string $s
	 * @return string
	 */
	public static function replaceTokensWithTags(array $tokens, string $s) : string
	{
		foreach ($tokens as $token => $tag) {
			$s = str_replace($token, $tag, $s);
		}
		return $s;
	}

	/**
	 * @param  string $s
	 * @return string
	 */
	public static function ampersands(string $s) : string
	{
		$s = str_replace(' & ', ' &amp; ', $s);

		// Convert ampersands that aren't part of entities or URLs.
		preg_match_all('/\?[^"]+&[^"]+/', $s, $matches);
		if (!empty($matches[0])) {
			foreach ($matches[0] as $i => $match) {
				$s = str_replace($match, '%ampersand_token_' . $i . '%', $s);
			}
		}
		$s = preg_replace('/&(?![A-Za-z0-9]+;)/', '&amp;', $s);
		if (!empty($matches[0])) {
			foreach ($matches[0] as $i => $match) {
				$s = str_replace('%ampersand_token_' . $i . '%', $match, $s);
			}
		}

		return $s;
	}

	/**
	 * @param  string $s
	 * @return string
	 */
	public static function sizes(string $s) : string
	{
		$s = preg_replace('/(\d+)" x (\d+)"/', '$1&quot; &times; $2&quot;', $s);
		$s = preg_replace('/(\d+)&quot; x (\d+)&quot;/', '$1&quot; &times; $2&quot;', $s);
		$s = preg_replace('/(\d) x (\d)/', '$1 &times; $2', $s);
		$s = preg_replace('/([0-9]+)\'([0-9]+)( [0-9]+\/[0-9]+)?"/', '$1&apos;$2$3&quot;', $s);
		return $s;
	}

	/**
	 * @param  string $s
	 * @return string
	 */
	public static function singleQuotes(string $s) : string
	{
		$s = preg_replace('/--\'([A-Z])/', '--&lsquo;$1', $s);
		$s = preg_replace(
			"/'([0-9]{2}'?s?|bout|cause|cept|cos|cuz|ello|em|im|lil|neath|round|scuse|til|till|tis|twas|tween)([ \"&<;,!\?\.\)\n-]|$)/i",
			'&rsquo;$1$2',
			$s
		);
		$s = preg_replace("/'n([ ';,!\?\.\)\n-]|$)/i", '&rsquo;n$1$2', $s);
		$s = preg_replace("/(^|<p[^>]*>|\"| )'([^ ])/", '$1&lsquo;$2', $s);
		$s = str_replace("('", '(&lsquo;', $s);
		$s = preg_replace('/<(a|b|cite|em|figcaption|h[1-6]|i|li|mark|span|strong|td)( [^>]+)?>\'/', '<$1$2>&lsquo;', $s);
		$s = str_replace("'", '&rsquo;', $s);
		return $s;
	}

	/**
	 * @param  string $s
	 * @return string
	 */
	public static function ellipses(string $s) : string
	{
		$s = str_replace('. . .', '.&nbsp;.&nbsp;.', $s);
		$s = str_replace('...', '&hellip;', $s);
		return $s;
	}

	/**
	 * @param  string $s
	 * @return string
	 */
	public static function fractions(string $s) : string
	{
		$s = preg_replace('/([^0-9\/])([0-9])\/([0-9])([^0-9\/])/', '$1&frac$2$3;$4', $s);
		return $s;
	}

	/**
	 * @param  string $s
	 * @return string
	 */
	public static function dashes(string $s) : string
	{
		$s = str_replace('- -', '-&nbsp;-', $s);
		$s = preg_replace('/([^|-])--([^|-]|$)/', '$1&mdash;$2', $s);
		$s = str_replace('&mdash;".', '&mdash;&rdquo;.', $s);
		$s = str_replace('&mdash;" ', '&mdash;&rdquo; ', $s);
		$s = str_replace('&mdash;"]', '&mdash;&rdquo;]', $s);
		$s = str_replace('&mdash;"' . "\n", '&mdash;&rdquo;' . "\n", $s);
		$s = str_replace('&mdash;"</p>', '&mdash;&rdquo;</p>', $s);
		$s = preg_replace('/&mdash;"$/', '&mdash;&rdquo;', $s);
		$s = str_replace('&mdash;"', '&mdash;&ldquo;', $s);
		$s = preg_replace('/(\d)-(\d+[^-])/', '$1&ndash;$2', $s);
		return $s;
	}

	/**
	 * @param  string $s
	 * @return string
	 */
	public static function quotes(string $s) : string
	{
		$s = str_replace(' -"', ' -&ldquo;', $s);
		$s = str_replace('/"', '/&ldquo;', $s);
		$s = preg_replace('/([ \n\(\[])"/', '$1&ldquo;', $s);
		$s = preg_replace('/(^|<p[^>]*>|<a [^>]+>|<h[1-6][^>]*>|<br>|\|)"/', '$1&ldquo;', $s);
		$s = preg_replace('/<(a|b|cite|em|figcaption|h[1-6]|i|li|mark|span|strong|td)( [^>]+)?>"/', '<$1$2>&ldquo;', $s);
		$s = str_replace('"', '&rdquo;', $s);
		return $s;
	}
}
