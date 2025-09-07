<?php

namespace Tests;

use Jlbelanger\Purdy;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PurdyTest extends TestCase
{
	/**
	 * @return array<string|int, list<array<string, string>>>
	 */
	public static function convertProvider() : array
	{
		return [
			'open quote after mdash' => [[
				'value' => 'Lorem ipsum--"dolor" sit--amet consectetur.',
				'expected' => 'Lorem ipsum&mdash;&ldquo;dolor&rdquo; sit&mdash;amet consectetur.',
			]],
			'link' => [[
				'value' => '<a href="#">"Foo" Bar</a>',
				'expected' => '<a href="#">&ldquo;Foo&rdquo; Bar</a>',
			]],
			[[
				'value' => 'foo <b>"bar"</b> blah',
				'expected' => 'foo <b>&ldquo;bar&rdquo;</b> blah',
			]],
			[[
				'value' => '<tr><td>1</td><td>"Foo"</td><td>BAR</td><td>12,345</td></tr>',
				'expected' => '<tr><td>1</td><td>&ldquo;Foo&rdquo;</td><td>BAR</td><td>12,345</td></tr>',
			]],
			[[
				'value' => 'Blah--".',
				'expected' => 'Blah&mdash;&rdquo;.',
			]],
			[[
				'value' => '"Foo--" Bar',
				'expected' => '&ldquo;Foo&mdash;&rdquo; Bar',
			]],
			[[
				'value' => '<li>"Mary, Mary"</li>',
				'expected' => '<li>&ldquo;Mary, Mary&rdquo;</li>',
			]],
			[[
				'value' => '["Foo, bar--"]',
				'expected' => '[&ldquo;Foo, bar&mdash;&rdquo;]',
			]],
			[[
				'value' => '"Hello, luv--"',
				'expected' => '&ldquo;Hello, luv&mdash;&rdquo;',
			]],
			[[
				'value' => 'foo <cite>"bar"</cite>. Blah',
				'expected' => 'foo <cite>&ldquo;bar&rdquo;</cite>. Blah',
			]],
			[[
				'value' => 'A said, "\'B\' is C."',
				'expected' => 'A said, &ldquo;&lsquo;B&rsquo; is C.&rdquo;',
			]],
			[[
				'value' => "Foo?--'Bar!'",
				'expected' => 'Foo?&mdash;&lsquo;Bar!&rsquo;',
			]],
			[[
				'value' => "'Foo--' said Bar.",
				'expected' => '&lsquo;Foo&mdash;&rsquo; said Bar.',
			]],
			[[
				'value' => "('Foo' bar. - Blah)",
				'expected' => '(&lsquo;Foo&rsquo; bar. - Blah)',
			]],
			[[
				'value' => 'Lorem ipsum dolor/sit/"amet" consectetur.',
				'expected' => 'Lorem ipsum dolor/sit/&ldquo;amet&rdquo; consectetur.',
			]],
			[[
				'value' => "The '60s and '70s",
				'expected' => 'The &rsquo;60s and &rsquo;70s',
			]],
			[[
				'value' => "From '66 to '68",
				'expected' => 'From &rsquo;66 to &rsquo;68',
			]],
			[[
				'value' => "'66&ndash;68",
				'expected' => '&rsquo;66&ndash;68',
			]],
			[[
				'value' => "<b>Christmas Medley '86</b>",
				'expected' => '<b>Christmas Medley &rsquo;86</b>',
			]],
			[[
				'value' => '"Christmas Medley \'86"',
				'expected' => '&ldquo;Christmas Medley &rsquo;86&rdquo;',
			]],
			'bout' => [[
				'value' => "How 'bout the flip side?",
				'expected' => 'How &rsquo;bout the flip side?',
			]],
			'cept' => [[
				'value' => "'Cept the countess has a brand new line",
				'expected' => '&rsquo;Cept the countess has a brand new line',
			]],
			'cause' => [[
				'value' => "It’s 'cause I’m short, I know",
				'expected' => 'It’s &rsquo;cause I’m short, I know',
			]],
			'cos' => [[
				'value' => "It’s 'cos I’m short, I know",
				'expected' => 'It’s &rsquo;cos I’m short, I know',
			]],
			'cuz' => [[
				'value' => "It’s 'cuz I’m short, I know",
				'expected' => 'It’s &rsquo;cuz I’m short, I know',
			]],
			'em' => [[
				'value' => "Shake 'em up",
				'expected' => 'Shake &rsquo;em up',
			]],
			'im' => [[
				'value' => "Get 'im!",
				'expected' => 'Get &rsquo;im!',
			]],
			'lil' => [[
				'value' => "'Lil metal bottle tops",
				'expected' => '&rsquo;Lil metal bottle tops',
			]],
			'tis' => [[
				'value' => "'Tis the season to be jolly",
				'expected' => '&rsquo;Tis the season to be jolly',
			]],
			'til' => [[
				'value' => "'Til the morning brings my train",
				'expected' => '&rsquo;Til the morning brings my train',
			]],
			'till' => [[
				'value' => "'Till the morning brings my train",
				'expected' => '&rsquo;Till the morning brings my train',
			]],
			[[
				'value' => "'Blah' he said",
				'expected' => '&lsquo;Blah&rsquo; he said',
			]],
			[[
				'value' => "He said, 'Blah'",
				'expected' => 'He said, &lsquo;Blah&rsquo;',
			]],
			[[
				'value' => "Rock 'n roll",
				'expected' => 'Rock &rsquo;n roll',
			]],
			[[
				'value' => "Rock 'n' roll",
				'expected' => 'Rock &rsquo;n&rsquo; roll',
			]],
			[[
				'value' => " ' ",
				'expected' => ' &rsquo; ',
			]],
			[[
				'value' => "What Am I Doing Hangin' 'Round?",
				'expected' => 'What Am I Doing Hangin&rsquo; &rsquo;Round?',
			]],
			[[
				'value' => "<b>'Blah'</b>",
				'expected' => '<b>&lsquo;Blah&rsquo;</b>',
			]],
			[[
				'value' => "<p>'Blah,",
				'expected' => '<p>&lsquo;Blah,',
			]],
		];
	}

	/**
	 * @param  array{value: string, expected: string} $args
	 * @return void
	 */
	#[DataProvider('convertProvider')]
	public function testConvert(array $args) : void
	{
		$output = Purdy::convert($args['value']);
		$this->assertSame($args['expected'], $output);
	}

	/**
	 * @return array<string|int, list<array<string, string>>>
	 */
	public static function ampersandsProvider() : array
	{
		return [
			[[
				'value' => 'Dolenz, Jones, Boyce & Hart',
				'expected' => 'Dolenz, Jones, Boyce &amp; Hart',
			]],
			[[
				'value' => 'DD&B',
				'expected' => 'DD&amp;B',
			]],
			[[
				'value' => 'Dolenz, Jones, Boyce &amp; Hart',
				'expected' => 'Dolenz, Jones, Boyce &amp; Hart',
			]],
			[[
				'value' => 'DD&amp;B',
				'expected' => 'DD&amp;B',
			]],
			[[
				'value' => '<a href="https://example.org/?foo&bar">example</a>',
				'expected' => '<a href="https://example.org/?foo&bar">example</a>',
			]],
			[[
				'value' => 'https://example.org/?foo&bar',
				'expected' => 'https://example.org/?foo&bar',
			]],
		];
	}

	/**
	 * @param  array{value: string, expected: string} $args
	 * @return void
	 */
	#[DataProvider('ampersandsProvider')]
	public function testAmpersands(array $args) : void
	{
		$output = Purdy::ampersands($args['value']);
		$this->assertSame($args['expected'], $output);
	}

	/**
	 * @return array<string|int, list<array<string, string>>>
	 */
	public static function sizesProvider() : array
	{
		return [
			[[
				'value' => '8" x 11"',
				'expected' => '8&quot; &times; 11&quot;',
			]],
			[[
				'value' => '8&quot; x 11&quot;',
				'expected' => '8&quot; &times; 11&quot;',
			]],
			[[
				'value' => '8 x 11',
				'expected' => '8 &times; 11',
			]],
			[[
				'value' => '5\'3"',
				'expected' => '5&apos;3&quot;',
			]],
			[[
				'value' => '5\'3 1/2"',
				'expected' => '5&apos;3 1/2&quot;',
			]],
		];
	}

	/**
	 * @param  array{value: string, expected: string} $args
	 * @return void
	 */
	#[DataProvider('sizesProvider')]
	public function testSizes(array $args) : void
	{
		$output = Purdy::sizes($args['value']);
		$this->assertSame($args['expected'], $output);
	}

	/**
	 * @return array<string|int, list<array<string, string>>>
	 */
	public static function singleQuotesProvider() : array
	{
		return [
			'apostrophe at beginning of word' => [[
				'value' => "Let’s dance on 'til the dawn",
				'expected' => 'Let’s dance on &rsquo;til the dawn',
			]],
			'apostrophe at end of word' => [[
				'value' => "Been doin' the Shotgun",
				'expected' => 'Been doin&rsquo; the Shotgun',
			]],
			'apostrophe inside word' => [[
				'value' => "Hey, hey, we're the Monkees",
				'expected' => 'Hey, hey, we&rsquo;re the Monkees',
			]],
			'apostrophe at beginning and end of word' => [[
				'value' => "Rock 'n' roll",
				'expected' => 'Rock &rsquo;n&rsquo; roll',
			]],
			'apostrophe at beginning of string' => [[
				'value' => "'Cause I’ve made your reservation",
				'expected' => '&rsquo;Cause I’ve made your reservation',
			]],
			'apostrophe at end of string' => [[
				'value' => "But we’re too busy singin'",
				'expected' => 'But we’re too busy singin&rsquo;',
			]],
		];
	}

	/**
	 * @param  array{value: string, expected: string} $args
	 * @return void
	 */
	#[DataProvider('singleQuotesProvider')]
	public function testSingleQuotes(array $args) : void
	{
		$output = Purdy::singleQuotes($args['value']);
		$this->assertSame($args['expected'], $output);
	}

	/**
	 * @return array<string|int, list<array<string, string>>>
	 */
	public static function ellipsesProvider() : array
	{
		return [
			[[
				'value' => 'Then & Now... The Best of The Monkees',
				'expected' => 'Then & Now&hellip; The Best of The Monkees',
			]],
		];
	}

	/**
	 * @param  array{value: string, expected: string} $args
	 * @return void
	 */
	#[DataProvider('ellipsesProvider')]
	public function testEllipses(array $args) : void
	{
		$output = Purdy::ellipses($args['value']);
		$this->assertSame($args['expected'], $output);
	}

	/**
	 * @return array<string|int, list<array<string, string>>>
	 */
	public static function fractionsProvider() : array
	{
		return [
			[[
				'value' => '33 1/3 Revolutions Per Monkee',
				'expected' => '33 &frac13; Revolutions Per Monkee',
			]],
			[[
				'value' => '1/3',
				'expected' => '&frac13;',
			]],
			[[
				'value' => '11/3',
				'expected' => '11/3',
			]],
			[[
				'value' => '1/33',
				'expected' => '1/33',
			]],
			[[
				'value' => '3/6',
				'expected' => '3/6',
			]],
			[[
				'value' => '1/2/3',
				'expected' => '1/2/3',
			]],
		];
	}

	/**
	 * @param  array{value: string, expected: string} $args
	 * @return void
	 */
	#[DataProvider('fractionsProvider')]
	public function testFractions(array $args) : void
	{
		$output = Purdy::fractions($args['value']);
		$this->assertSame($args['expected'], $output);
	}

	/**
	 * @return array<string|int, list<array<string, string>>>
	 */
	public static function dashesProvider() : array
	{
		return [
			[[
				'value' => 'Would it--would it be dog?',
				'expected' => 'Would it&mdash;would it be dog?',
			]],
			[[
				'value' => 'It would be springing from my--',
				'expected' => 'It would be springing from my&mdash;',
			]],
			[[
				'value' => '5-10',
				'expected' => '5&ndash;10',
			]],
			[[
				'value' => '5-4-3-2-1',
				'expected' => '5-4-3-2-1',
			]],
			[[
				'value' => '|Apples|Peaches|Bananas|Pears|' . "\n" . '|------|-------|-------|-----|' . "\n" . '|1|2|3|4|',
				'expected' => '|Apples|Peaches|Bananas|Pears|' . "\n" . '|------|-------|-------|-----|' . "\n" . '|1|2|3|4|',
			]],
			[[
				'value' => 'Micky: "Well, one day, Nez comes up to me--"' . "\n" . 'Mike: Says "Hey there, Mick."',
				'expected' => 'Micky: "Well, one day, Nez comes up to me&mdash;&rdquo;' . "\n" . 'Mike: Says "Hey there, Mick."',
			]],
		];
	}

	/**
	 * @param  array{value: string, expected: string} $args
	 * @return void
	 */
	#[DataProvider('dashesProvider')]
	public function testDashes(array $args) : void
	{
		$output = Purdy::dashes($args['value']);
		$this->assertSame($args['expected'], $output);
	}

	/**
	 * @return array<string|int, list<array<string, string>>>
	 */
	public static function quotesProvider() : array
	{
		return [
			'open quote after space' => [[
				'value' => 'Said, "Sorry, stop, cannot attend',
				'expected' => 'Said, &ldquo;Sorry, stop, cannot attend',
			]],
			'open quote after open bracket' => [[
				'value' => '("Circle Sky" riff)',
				'expected' => '(&ldquo;Circle Sky&rdquo; riff)',
			]],
			'open quote after open square bracket' => [[
				'value' => '["Circle Sky" riff]',
				'expected' => '[&ldquo;Circle Sky&rdquo; riff]',
			]],
			'open quote after beginning of string' => [[
				'value' => '"Well, he said he should have known',
				'expected' => '&ldquo;Well, he said he should have known',
			]],
			'open quote after open paragraph' => [[
				'value' => '<p>"Well, he said he should have known',
				'expected' => '<p>&ldquo;Well, he said he should have known',
			]],
			'open quote after open heading' => [[
				'value' => '<h3>"Foo" Bar</h3>',
				'expected' => '<h3>&ldquo;Foo&rdquo; Bar</h3>',
			]],
			'open quote after line break' => [[
				'value' => '<br>"Well, he said he should have known',
				'expected' => '<br>&ldquo;Well, he said he should have known',
			]],
			'open quote after \\n' => [[
				'value' => "\n" . '"Well, he said he should have known',
				'expected' => "\n" . '&ldquo;Well, he said he should have known',
			]],
			'close quote before comma' => [[
				'value' => 'Let\'s "Hey, hey! We are The Monkees", like that.',
				'expected' => 'Let\'s &ldquo;Hey, hey! We are The Monkees&rdquo;, like that.',
			]],
			'close quote before space' => [[
				'value' => 'Foo" bar',
				'expected' => 'Foo&rdquo; bar',
			]],
			'close quote before period' => [[
				'value' => 'Davy: Wait a minute, let\'s not do it "Hey, hey we are".',
				'expected' => 'Davy: Wait a minute, let\'s not do it &ldquo;Hey, hey we are&rdquo;.',
			]],
			'close quote before question mark' => [[
				'value' => 'Jack: "You\'ll like our story"?',
				'expected' => 'Jack: &ldquo;You\'ll like our story&rdquo;?',
			]],
			'close quote before close bracket' => [[
				'value' => 'Blah")',
				'expected' => 'Blah&rdquo;)',
			]],
			'close quote before close square bracket' => [[
				'value' => 'Blah"]',
				'expected' => 'Blah&rdquo;]',
			]],
			'close quote before exclamation mark' => [[
				'value' => 'Blah"!',
				'expected' => 'Blah&rdquo;!',
			]],
			'close quote before \\n' => [[
				'value' => 'And stay here above this stream out of the sun"' . "\n",
				'expected' => 'And stay here above this stream out of the sun&rdquo;' . "\n",
			]],
			'close quote before close paragraph' => [[
				'value' => 'And stay here above this stream out of the sun"</p>',
				'expected' => 'And stay here above this stream out of the sun&rdquo;</p>',
			]],
			'close quote before close heading' => [[
				'value' => '<h3>Foo "Bar"</h3>',
				'expected' => '<h3>Foo &ldquo;Bar&rdquo;</h3>',
			]],
			'close quote before line break' => [[
				'value' => 'And stay here above this stream out of the sun"<br>',
				'expected' => 'And stay here above this stream out of the sun&rdquo;<br>',
			]],
			'close quote before end of string' => [[
				'value' => 'And stay here above this stream out of the sun"',
				'expected' => 'And stay here above this stream out of the sun&rdquo;',
			]],
			'close quote before ellipses' => [[
				'value' => 'Two, three, four, "Hey"&hellip;',
				'expected' => 'Two, three, four, &ldquo;Hey&rdquo;&hellip;',
			]],
			'quote at beginning and end of line' => [[
				'value' => '"Play, Magic Fingers!"',
				'expected' => '&ldquo;Play, Magic Fingers!&rdquo;',
			]],
			'search query' => [[
				'value' => 'foo -"bar"',
				'expected' => 'foo -&ldquo;bar&rdquo;',
			]],
			'in table' => [[
				'value' => '|Foo|"Bar" Blah|',
				'expected' => '|Foo|&ldquo;Bar&rdquo; Blah|',
			]],
		];
	}

	/**
	 * @param  array{value: string, expected: string} $args
	 * @return void
	 */
	#[DataProvider('quotesProvider')]
	public function testQuotes(array $args) : void
	{
		$output = Purdy::quotes($args['value']);
		$this->assertSame($args['expected'], $output);
	}
}
