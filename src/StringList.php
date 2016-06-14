<?php
namespace Hansel23\GenericLists;

/**
 * Class StringList
 *
 * @package Hansel23\GenericLists
 */
final class StringList extends AbstractList
{
	private $typeName;

	/**
	 * StringList constructor.
	 */
	public function __construct()
	{
		$this->typeName = gettype( '' );
	}

	protected function isItemValid( $item )
	{
		return is_string( $item );
	}

	public function getItemType()
	{
		return $this->typeName;
	}

	/**
	 * @param array $strings
	 *
	 * @return static
	 */
	public static function fromArray( array $strings )
	{
		$list = new static();
		
		foreach( $strings as $oneString )
		{
			$list->add( $oneString );
		}
		
		return $list;
	}
}