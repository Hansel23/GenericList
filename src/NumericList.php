<?php
namespace Hansel23\GenericLists;

/**
 * Class NumericList
 *
 * @package Hansel23\GenericLists
 */
final class NumericList	extends AbstractList
{
	private $typeName = 'numeric';

	protected function isItemValid( $item )
	{
		return is_numeric( $item );
	}

	public function getItemType()
	{
		return $this->typeName;
	}

	/**
	 * @param array $numerics
	 *
	 * @return static
	 */
	public static function fromArray( array $numerics )
	{
		$list = new static();

		foreach( $numerics as $numeric )
		{
			$list->add( $numeric );
		}

		return $list;
	}
}