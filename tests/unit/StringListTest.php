<?php
namespace Hansel23\GenericLists\Tests\Unit;

use Hansel23\GenericLists\StringList;
use Hansel23\GenericLists\Tests\Unit\Fixtures\Stringable;

class StringListTest extends \Codeception\TestCase\Test
{
	public function InvalidItemProvider()
	{
		return [
			[ 1, 1.0, true, false, new \stdClass(), new Stringable(), [ ] ],
		];
	}

	/**
	 * @dataProvider InvalidItemProvider
	 *
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfInvalidItemsThrowsException( $item )
	{
		$stringList = new StringList();
		$stringList->add( $item );
	}

	public function ValidItemProvider()
	{
		return [
			[ 'true', '1', '1.0', 'false' ],
		];
	}

	/**
	 * @dataProvider ValidItemProvider
	 */
	public function testAddingValidItems( $item )
	{
		$stringList = new StringList();
		$stringList->add( $item );

		$this->assertNotEquals( -1, $stringList->indexOf( $item ) );
	}

	public function ValidStringArrayProvider()
	{
		return [
			[ [ 'here', 'is', 'a', 'testarray' ], [ 'I like some', 'more tests' ] ],
		];
	}

	/**
	 * @dataProvider ValidStringArrayProvider
	 */
	public function testCreatingStringListFromArray( array $stringArray )
	{
		$stringList = StringList::fromArray( $stringArray );

		$this->assertEquals( count( $stringArray ), $stringList->count() );
		$this->assertEquals( $stringArray, $stringList->toArray() );
	}

	public function InvalidArrayProvider()
	{
		return [
			[ [ 1, false ], [ 'string', 'one more string', true ], [ [ ] ] ],
		];
	}

	/**
	 * @dataProvider InvalidArrayProvider
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfCreatingFromInvalidArrayThrowsException( array $invalidArray )
	{
		StringList::fromArray( $invalidArray );
	}
}