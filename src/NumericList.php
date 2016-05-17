<?php
namespace Hansel23\GenericList;

use Hansel23\GenericList\Exceptions\InvalidTypeException;

/**
 * Class NumericList
 *
 * @package Hansel23\GenericList
 */
final class NumericList	extends GenericList
{
	/**
	 * StringList constructor.
	 */
	public function __construct()
	{
		parent::__construct( 'numeric' );
	}

	/**
	 * @param $item
	 *
	 * @throws InvalidTypeException
	 */
	protected function validateItemType( $item )
	{
		if ( $itemType = !is_numeric( $item ) )
		{
			$itemType = $this->getType( $item );

			throw new InvalidTypeException(
				sprintf( 'Numeric item expected, item of type %s given', $itemType )
			);
		}
	}
}