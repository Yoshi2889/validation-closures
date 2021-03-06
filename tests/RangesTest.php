<?php
/**
 * Copyright 2017 NanoSector
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

use ValidationClosures\Ranges;
use PHPUnit\Framework\TestCase;

class RangesTest extends TestCase
{
	public function testStringWithLengthBetween()
	{
		$closure = Ranges::stringWithLengthBetween(0, 10);
		self::assertFalse($closure(5));
		self::assertTrue($closure('test'));
		self::assertFalse($closure(1.2));
		self::assertFalse($closure(false));
		self::assertFalse($closure([ ]));
		self::assertTrue($closure('in_array'));
		self::assertFalse($closure(new stdClass()));

		$closure = Ranges::stringWithLengthBetween(0, 1);
		self::assertTrue($closure(''));
		self::assertTrue($closure('a'));
		self::assertFalse($closure('aaa'));
		self::assertFalse($closure('aaaaa'));

		$closure = Ranges::stringWithLengthBetween(0, 5);
		self::assertFalse($closure(5));
		self::assertTrue($closure(''));
		self::assertTrue($closure('a'));
		self::assertTrue($closure('aaa'));
		self::assertTrue($closure('aaaaa'));

		$closure = Ranges::stringWithLengthBetween(2, 4);
		self::assertFalse($closure(5));
		self::assertFalse($closure(''));
		self::assertFalse($closure('a'));
		self::assertTrue($closure('aa'));
		self::assertTrue($closure('aaa'));
		self::assertFalse($closure('aaaaa'));
	}

	public function testStringWithLengthBetween_InvalidParams()
	{
		$this->expectException(InvalidArgumentException::class);
		Ranges::stringWithLengthBetween(-1, 0);

		$this->expectException(InvalidArgumentException::class);
		Ranges::stringWithLengthBetween(0, 0);
	}

	public function testIntBetween()
	{
		$closure = Ranges::intBetween(0, 3);
		self::assertTrue($closure(2));
		self::assertFalse($closure('test'));
		self::assertFalse($closure(1.2));
		self::assertFalse($closure(false));
		self::assertFalse($closure([ ]));
		self::assertFalse($closure('in_array'));
		self::assertFalse($closure(new stdClass()));

		self::assertFalse($closure(-3));
		self::assertFalse($closure(-2));
		self::assertFalse($closure(-1));
		self::assertTrue($closure(0));
		self::assertTrue($closure(1));
		self::assertTrue($closure(2));
		self::assertTrue($closure(3));
		self::assertFalse($closure(4));
		self::assertFalse($closure(5));

		$closure = Ranges::intBetween(-2, 2);
		self::assertFalse($closure(-3));
		self::assertTrue($closure(-2));
		self::assertTrue($closure(-1));
		self::assertTrue($closure(0));
		self::assertTrue($closure(1));
		self::assertTrue($closure(2));
		self::assertFalse($closure(3));
		self::assertFalse($closure(4));
		self::assertFalse($closure(5));
		
		self::expectException(\InvalidArgumentException::class);
		Ranges::intBetween(5, 3);
	}

    public function testIntBetweenExclusive()
    {
        $closure = Ranges::intBetweenExclusive(0, 3);
        self::assertTrue($closure(2));
        self::assertFalse($closure('test'));
        self::assertFalse($closure(1.2));
        self::assertFalse($closure(false));
        self::assertFalse($closure([ ]));
        self::assertFalse($closure('in_array'));
        self::assertFalse($closure(new stdClass()));

        self::assertFalse($closure(-3));
        self::assertFalse($closure(-2));
        self::assertFalse($closure(-1));
        self::assertFalse($closure(0));
        self::assertTrue($closure(1));
        self::assertTrue($closure(2));
        self::assertFalse($closure(3));
        self::assertFalse($closure(4));
        self::assertFalse($closure(5));

        $closure = Ranges::intBetweenExclusive(-2, 2);
        self::assertFalse($closure(-3));
        self::assertFalse($closure(-2));
        self::assertTrue($closure(-1));
        self::assertTrue($closure(0));
        self::assertTrue($closure(1));
        self::assertFalse($closure(2));
        self::assertFalse($closure(3));
        self::assertFalse($closure(4));
        self::assertFalse($closure(5));

        self::expectException(\InvalidArgumentException::class);
        Ranges::intBetweenExclusive(5, 3);
    }

	public function testFloatBetween()
	{
		$closure = Ranges::floatBetween(0.0, 3.0);
		self::assertFalse($closure(2));
		self::assertFalse($closure('test'));
		self::assertTrue($closure(1.2));
		self::assertFalse($closure(false));
		self::assertFalse($closure([ ]));
		self::assertFalse($closure('in_array'));
		self::assertFalse($closure(new stdClass()));

		self::assertFalse($closure(-3.0));
		self::assertFalse($closure(-2.0));
		self::assertFalse($closure(-1.0));
		self::assertTrue($closure(0.0));
		self::assertTrue($closure(1.0));
		self::assertTrue($closure(2.0));
		self::assertTrue($closure(3.0));
		self::assertFalse($closure(3.1));
		self::assertFalse($closure(4.0));
		self::assertFalse($closure(5.0));

		$closure = Ranges::floatBetween(-2.0, 2.0);
		self::assertFalse($closure(-3.0));
		self::assertFalse($closure(-2.1));
		self::assertTrue($closure(-2.0));
		self::assertTrue($closure(-1.0));
		self::assertTrue($closure(0.0));
		self::assertTrue($closure(1.0));
		self::assertTrue($closure(2.0));
		self::assertFalse($closure(2.1));
		self::assertFalse($closure(3.0));
		self::assertFalse($closure(4.0));
		self::assertFalse($closure(5.0));

        self::expectException(\InvalidArgumentException::class);
        Ranges::floatBetween(5.0, 3.0);
	}

    public function testFloatBetweenExclusive()
    {
        $closure = Ranges::floatBetweenExclusive(0.0, 3.0);
        self::assertFalse($closure(2));
        self::assertFalse($closure('test'));
        self::assertTrue($closure(1.2));
        self::assertFalse($closure(false));
        self::assertFalse($closure([ ]));
        self::assertFalse($closure('in_array'));
        self::assertFalse($closure(new stdClass()));

        self::assertFalse($closure(-3.0));
        self::assertFalse($closure(-2.0));
        self::assertFalse($closure(-1.0));
        self::assertFalse($closure(0.0));
        self::assertTrue($closure(0.1));
        self::assertTrue($closure(1.0));
        self::assertTrue($closure(2.0));
        self::assertTrue($closure(2.9));
        self::assertFalse($closure(3.0));
        self::assertFalse($closure(3.1));
        self::assertFalse($closure(4.0));
        self::assertFalse($closure(5.0));

        $closure = Ranges::floatBetweenExclusive(-2.0, 2.0);
        self::assertFalse($closure(-3.0));
        self::assertFalse($closure(-2.1));
        self::assertFalse($closure(-2.0));
        self::assertTrue($closure(-1.9));
        self::assertTrue($closure(-1.0));
        self::assertTrue($closure(0.0));
        self::assertTrue($closure(1.0));
        self::assertTrue($closure(1.9));
        self::assertFalse($closure(2.0));
        self::assertFalse($closure(2.1));
        self::assertFalse($closure(3.0));
        self::assertFalse($closure(4.0));
        self::assertFalse($closure(5.0));

        self::expectException(\InvalidArgumentException::class);
        Ranges::floatBetweenExclusive(5.0, 3.0);
    }

	public function testEnum()
	{
		$closure = Ranges::enum(10, 'test', false);

		self::assertTrue($closure(10));
		self::assertTrue($closure('test'));
		self::assertFalse($closure(1.2));
		self::assertTrue($closure(false));
		self::assertFalse($closure([ ]));
		self::assertFalse($closure('in_array'));
		self::assertFalse($closure(new stdClass()));
	}

	public function testTypeEnum()
	{
		$closure = Ranges::typeEnum('string', 'double');

		self::assertFalse($closure(10));
		self::assertTrue($closure('test'));
		self::assertTrue($closure(1.2));
		self::assertFalse($closure(false));
		self::assertFalse($closure([ ]));
		self::assertTrue($closure('in_array'));
		self::assertFalse($closure(new stdClass()));
	}

	public function testStringOneOf()
	{
		$closure = Ranges::stringOneOf('test', 'ing');
		self::assertFalse($closure(10));
		self::assertTrue($closure('test'));
		self::assertFalse($closure(1.2));
		self::assertFalse($closure(false));
		self::assertFalse($closure([]));
		self::assertFalse($closure('in_array'));
		self::assertFalse($closure(new stdClass()));

		self::assertTrue($closure('test'));
		self::assertTrue($closure('ing'));
		self::assertFalse($closure('something else'));
		self::assertFalse($closure(' '));
	}

	public function testStringOneOf_InvalidParams()
	{
		self::expectException(\InvalidArgumentException::class);
		Ranges::stringOneOf(10, 'test');
	}
}
