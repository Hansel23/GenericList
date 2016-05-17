<?php
namespace Hansel23\GenericList\Tests\Unit;

use Hansel23\GenericList\BooleanList;

class BooleanListTest extends \Codeception\TestCase\Test
{
	public function InvalidItemProvider()
	{
		return [
			[ 1, 1.0, 0, 0.0, 'true', 'false', new \stdClass(), [ ] ],
		];
	}

	/**
	 * @dataProvider InvalidItemProvider
	 *
	 * @expectedException \Hansel23\GenericList\Exceptions\InvalidTypeException
	 */
	public function testIfInvalidItemsThrowsException( $item )
	{
		$boolList = new BooleanList();
		$boolList->add( $item );
	}

	public function ValidItemProvider()
	{
		return [
			[ true, false ],
		];
	}

	/**
	 * @dataProvider ValidItemProvider
	 */
	public function testAddingValidItems( $item )
	{
		$boolList = new BooleanList();
		$boolList->add( $item );

		$this->assertNotEquals( -1, $boolList->indexOf( $item ) );
	}
}