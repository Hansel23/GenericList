<?php
namespace Hansel23\GenericLists;

use Hansel23\GenericLists\Exceptions\InvalidTypeException;
use Hansel23\GenericLists\Interfaces\ListsItems;

/**
 * Class GenericList
 *
 * @package Hansel23\GenericLists
 */
class GenericList extends AbstractList
{
	const OBJECT  = 1;

	const STRING  = 2;

	const INT     = 3;

	const FLOAT   = 4;

	const ARR     = 5;

	const BOOL    = 6;

	const NUMERIC = 7;

	/**
	 * @var string
	 */
	protected $validItemTypeName;

	/**
	 * @var int
	 */
	protected $itemType;

	/**
	 * GenericList constructor.
	 *
	 * @param $itemTypeName
	 */
	public function __construct( $itemTypeName )
	{
		$this->validItemTypeName = $itemTypeName;

		if ( class_exists( $itemTypeName ) || interface_exists( $itemTypeName ) )
		{
			$this->itemType = self::OBJECT;
		}
		elseif ( $itemTypeName == 'string' )
		{
			$this->itemType = self::STRING;
		}
		elseif ( $itemTypeName == 'integer' )
		{
			$this->itemType = self::INT;
		}
		elseif ( $itemTypeName == 'array' )
		{
			$this->itemType = self::ARR;
		}
		elseif ( $itemTypeName == 'double' )
		{
			$this->itemType = self::FLOAT;
		}
		elseif ( $itemTypeName == 'boolean' )
		{
			$this->itemType = self::BOOL;
		}
		elseif ( $itemTypeName == 'numeric' )
		{
			$this->itemType = self::NUMERIC;
		}
		else
		{
			throw new InvalidTypeException( sprintf( 'Type "%s" not allowed', $itemTypeName ) );
		}
	}

	/**
	 * @return string
	 */
	public function getItemType()
	{
		return $this->validItemTypeName;
	}

	/**
	 * @param $item
	 *
	 * @return bool
	 */
	protected function isItemValid( $item )
	{
		switch ( $this->itemType )
		{
			case self::OBJECT:
				return $item instanceof $this->validItemTypeName;

			case self::STRING:
				return is_string( $item );

			case self::INT:
				return is_int( $item );

			case self::ARR:
				return is_array( $item );

			case self::FLOAT:
				return is_float( $item );

			case self::BOOL:
				return is_bool( $item );

			case self::NUMERIC:
				return is_numeric( $item );
		}

		return false;
	}

	/**
	 * @param ListsItems $list
	 *
	 * @return bool
	 */
	protected function isValidList( ListsItems $list )
	{
		$validItemType = $this->getItemType();
		$itemType      = $list->getItemType();

		return $itemType == $validItemType || in_array( $validItemType, class_implements( $itemType ) );
	}
}