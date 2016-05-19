<?php
namespace Hansel23\GenericLists\Tests\Unit;

use Hansel23\GenericLists\NumericList;

class NumericListTest extends \Codeception\TestCase\Test
{
	public function InvalidItemProvider()
	{
		return [
			[ 'string', true, false, new \stdClass(), [ ] ],
		];
	}

	/**
	 * @dataProvider InvalidItemProvider
	 *
	 * @expectedException \Hansel23\GenericLists\Exceptions\InvalidTypeException
	 */
	public function testIfInvalidItemsThrowsException( $item )
	{
		$numericList = new NumericList();
		$numericList->add( $item );
	}

	public function ValidItemProvider()
	{
		return [
			[ '1.0', '1', '0.0', '0', 1.0, 0.0, 100.00, -324.234, 11.23, 1, 0, -100, '-100', '-1.02' ],
		];
	}

	/**
	 * @dataProvider ValidItemProvider
	 */
	public function testAddingValidItems( $item )
	{
		$numericList = new NumericList();
		$numericList->add( $item );

		$this->assertNotEquals( -1, $numericList->indexOf( $item ) );
	}
}