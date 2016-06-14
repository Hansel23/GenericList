<?php
namespace Hansel23\GenericLists;

use Hansel23\GenericLists\Exceptions\InvalidTypeException;

/**
 * Class GenericList
 *
 * @package Hansel23\GenericLists
 */
class GenericList extends AbstractList
{
	private static $OBJECT_TYPE  = 1;

	private static $STRING_TYPE  = 2;

	private static $INT_TYPE     = 3;

	private static $FLOAT_TYPE   = 4;

	private static $ARRAY_TYPE   = 5;

	private static $BOOL_TYPE    = 6;

	private static $NUMERIC_TYPE = 7;

	const STRING  = 'string';

	const INT     = 'integer';

	const FLOAT   = 'float';

	const _ARRAY  = 'array';

	const BOOL    = 'boolean';

	const NUMERIC = 'numeric';

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
	 * 
	 * @throws InvalidTypeException
	 */
	public function __construct( $itemTypeName )
	{
		$this->validItemTypeName = $itemTypeName;

		if ( class_exists( $itemTypeName ) || interface_exists( $itemTypeName ) )
		{
			$this->itemType = self::$OBJECT_TYPE;
		}
		else
		{
			switch ( $itemTypeName )
			{
				case self::STRING:
					$this->itemType = self::$STRING_TYPE;
					break;

				case self::INT:
					$this->itemType = self::$INT_TYPE;
					break;

				case self::_ARRAY:
					$this->itemType = self::$ARRAY_TYPE;
					break;

				case self::FLOAT:
					$this->itemType = self::$FLOAT_TYPE;
					break;

				case self::BOOL:
					$this->itemType = self::$BOOL_TYPE;
					break;

				case self::NUMERIC:
					$this->itemType = self::$NUMERIC_TYPE;
					break;

				default:
					throw new InvalidTypeException( sprintf( 'Type "%s" not allowed', $itemTypeName ) );
			}
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
			case self::$OBJECT_TYPE:
				return $item instanceof $this->validItemTypeName;

			case self::$STRING_TYPE:
				return is_string( $item );

			case self::$INT_TYPE:
				return is_int( $item );

			case self::$ARRAY_TYPE:
				return is_array( $item );

			case self::$FLOAT_TYPE:
				return is_float( $item );

			case self::$BOOL_TYPE:
				return is_bool( $item );

			case self::$NUMERIC_TYPE:
				return is_numeric( $item );
			
			// @codeCoverageIgnoreStart
			default:
				return false;
		}
		// @codeCoverageIgnoreEnd
	}
}