<?php
namespace Hansel23\GenericLists;

/**
 * Class GenericList
 *
 * @package Hansel23\GenericLists
 */
class GenericList extends AbstractList
{
	/**
	 * @var string
	 */
	protected $validItemType;

	/**
	 * @param string $itemClassName
	 */
	public function __construct( $itemClassName )
	{
		$this->validItemType = $itemClassName;
	}

	/**
	 * @return string
	 */
	public function getItemType()
	{
		return $this->validItemType;
	}
}