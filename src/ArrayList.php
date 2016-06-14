<?php
namespace Hansel23\GenericLists;

/**
 * Class ArrayList
 *
 * @package Hansel23\GenericLists
 */
final class ArrayList extends AbstractList
{
	private $typeName;

	/**
	 * StringList constructor.
	 */
	public function __construct()
	{
		$this->typeName = gettype( [] );
	}

	protected function isItemValid( $item )
	{
		return is_array( $item );
	}

	public function getItemType()
	{
		return $this->typeName;
	}

	/**
	 * @param array $subArrays
	 *
	 * @return static
	 */
	public static function fromArray( array $subArrays )
	{
		$list = new static();

		foreach( $subArrays as $subArray )
		{
			$list->add( $subArray );
		}

		return $list;
	}
}