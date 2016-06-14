<?php
namespace Hansel23\GenericLists;

/**
 * Class BooleanList
 *
 * @package Hansel23\GenericLists
 */
final class BooleanList	extends AbstractList
{
	private $typeName;

	/**
	 * StringList constructor.
	 */
	public function __construct()
	{
		$this->typeName = gettype( false );
	}

	protected function isItemValid( $item )
	{
		return is_bool( $item );
	}

	public function getItemType()
	{
		return $this->typeName;
	}
}