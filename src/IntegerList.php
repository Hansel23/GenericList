<?php
namespace Hansel23\GenericLists;

/**
 * Class IntegerList
 *
 * @package Hansel23\GenericLists
 */
final class IntegerList	extends AbstractList
{
	private $typeName;

	/**
	 * StringList constructor.
	 */
	public function __construct()
	{
		$this->typeName = gettype( 2 );
	}

	protected function isItemValid( $item )
	{
		return is_int( $item );
	}

	public function getItemType()
	{
		return $this->typeName;
	}
	
	/**
	 * @param array $integers
	 *
	 * @return static
	 */
	public static function fromArray( array $integers )
	{
		$list = new static();

		foreach( $integers as $integer )
		{
			$list->add( $integer );
		}

		return $list;
	}	
}