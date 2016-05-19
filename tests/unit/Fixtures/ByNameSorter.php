<?php
namespace Hansel23\GenericLists\Tests\Unit\Fixtures;

use Hansel23\GenericLists\Interfaces\SortsLists;

/**
 * Class ByNameSorter
 *
 * @package Fortuneglobe\PermissionManagementService\Hansel23\GenericListsSorters
 */
class ByNameSorter implements SortsLists
{
	protected $sortDirection;

	/**
	 * @param int $sortDirection
	 */
	public function __construct( $sortDirection = SORT_ASC )
	{
		$this->sortDirection = $sortDirection;
	}

	/**
	 * @param $object1
	 * @param $object2
	 *
	 * @return int
	 */
	public function compare( $object1, $object2 )
	{
		if($object1->getName() == $object2->getName())
		{
			return 0;
		}

		$result = strcmp( $object1->getName(), $object2->getName() );

		if( $this->sortDirection === SORT_DESC )
		{
			return - ( $result );
		}

		return $result;
	}
}