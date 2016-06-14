<?php
namespace Hansel23\GenericLists;

/**
 * Class FloatList
 *
 * @package Hansel23\GenericLists
 */
final class FloatList extends AbstractList
{
	private $typeName;

	/**
	 * StringList constructor.
	 */
	public function __construct()
	{
		$this->typeName = gettype( 2.0 );
	}

	protected function isItemValid( $item )
	{
		return is_float( $item );
	}

	public function getItemType()
	{
		return $this->typeName;
	}

	/**
	 * @param array $floats
	 *
	 * @return static
	 */
	public static function fromArray( array $floats )
	{
		$list = new static();

		foreach( $floats as $float )
		{
			$list->add( $float );
		}

		return $list;
	}
}