<?php
namespace Hansel23\GenericList\Tests\Unit;

use Hansel23\GenericList\FloatList;

class FloatListTest extends \Codeception\TestCase\Test
{
	public function InvalidItemProvider()
	{
		return [
			[ '1.0', 1, '0.0', 0, 'string', true, false, new \stdClass(), [ ] ],
		];
	}

	/**
	 * @dataProvider InvalidItemProvider
	 *
	 * @expectedException \Hansel23\GenericList\Exceptions\InvalidTypeException
	 */
	public function testIfInvalidItemsThrowsException( $item )
	{
		$floatList = new FloatList();
		$floatList->add( $item );
	}

	public function ValidItemProvider()
	{
		return [
			[ 1.0, 0.0, 100.00, -324.234, 11.23 ],
		];
	}

	/**
	 * @dataProvider ValidItemProvider
	 */
	public function testAddingValidItems( $item )
	{
		$floatList = new FloatList();
		$floatList->add( $item );

		$this->assertNotEquals( -1, $floatList->indexOf( $item ) );
	}
}