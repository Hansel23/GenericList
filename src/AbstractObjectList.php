<?php
namespace Hansel23\GenericLists;

/**
 * Class AbstractObjectList
 *
 * @package Hansel23\GenericLists
 */
abstract class AbstractObjectList extends AbstractList
{
	/**
	 * @param $item
	 *
	 * @return bool
	 */
	protected function isItemValid( $item )
	{
		$validItemType = $this->getItemType();
		
		return $item instanceof $validItemType;
	}

	/**
	 * @param array $objects
	 *
	 * @return static
	 */
	public static function fromArray( array $objects )
	{
		$list = new static();

		foreach( $objects as $object )
		{
			$list->add( $object );
		}

		return $list;
	}
}