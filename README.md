[![Coverage Status](https://coveralls.io/repos/github/Hansel23/GenericListss/badge.svg?branch=master)](https://coveralls.io/github/Hansel23/GenericListss?branch=master)

# GenericList
Generic list with interface. It's based on the list type of some other famous languages, like java or c#

### My Motivation

I like strong typing. I think it makes the code more stable and easier to understand.

I want to be sure to have certain objects in the list and not only trust to have the right object
in the array.

I like the methods of the list types of other languages like java or c#. They are often usefull.

### Usage

You can build an instance of the GenericList on the fly: *new GenericList( YourOwnType::class )*

*Recommended usage:*

1. create a new type, e.g. YourOwnTypeList
2. extend this type from **GenericList**
3. override the constructor: *public function \_\_construct() { parent::__construct( YourOwnType::class ) }*

Now you can use typehints for this list.

You can iterate over the list like you do it with a normal array. 

Also there are many useful methods:

 - **add( $item )** Adds a new item to the list
 - **addAll( ListsItems $list )** Adds another list to the items. No item will be overwritten
 - **merge( ListsItems $list )** Merges lhe list with another list. If the index already exists, the item will be overwritten with the new one.
 - **remove( $item )** Removes an item from the list. Only the first item that is equal to the given item will be removed.
 - **removeByIndex( $index )** Removes the item with the given index. If the index doesn't exist an InvalidIndexException will be thrown.
 - **removeAll( ListsItems $list )** Removes all items from another list from the current list.
 - **removeAllExcept( ListsItems $list )** Removes all items from the list except the items of the given list.
 - **contains( $item )** Looks if the given item exists in the list.
 - **indexOf( $item )** Returns the index of the first item that equals to the given item. If there is no equal item in the list, the method returns -1.
 - **lastIndexOf( $item )** Returns the index of the last item that equals to the given item. If there is no equal item in the list, the method returns -1.
 - **set( $index, $item )** Overwrites the item with the given index in the list. This method is equal to $list[$index] = $item, except that the index must be an integer and already existing. 
 - **get( $index )** Returns the item with the given index. If the index doesn't exist, an InvalidIndexException will be thrown.
 - **toArray()** Returns an array-representation of the list, so you can use array functions.
 - **reverse()** Reverses the whole list.
 - **clear()** Clears the list. All items will be removed and the indices resetted.
 - **sortBy( SortsLists $sorter )** Sorts the list by a list sorter.
 - **find( FindsItems $filter )** Returns the first item that will be found by your list filter.
 - **findLast( FindsItems $filter )** Returns the last item that will be found by your list filter.
 - **findAll( FindsItems $filter )** Returns a list of all items that will be found by your list filter.
 - **getItemType()** Returns the type of the items in the list.
   	
All exceptions are extended from the ListException.

### List Sorters

To sort a list, you have to create a sorter, that implements the **SortsLists** interface.

The implementation of the method *compare( $object1, $object2 )* must return an integer less than, equal to, or greater
than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.

Pass an instance of your sorter implementation to the method sortBy of the list.

### List Filters

To filter a list, you have to create a filter, that implements the **FindsItems** interface with the *isValid( $object )*
method. This method must return a boolean value to indicate whether the object matches to the filter and should be
returned or not.

Pass an instance of your filter implementation to the method *find*, *findLast* or *findAll* of the list.
*Find* and *findLast* will return one object (first or last) that matches your filter method and *findAll* will return
a new list of the same type that contains all objects filtered by your filter.

### Example

*using list type directly*

    <?php  
		$list = new List( YourClass::class );
		$list->add( new YourClass() );
    ?>

*creating the list type*

    <?php  
		class AddressList extends GenericList  
		{
			public function __construct()  
			{  
				parent::__construct( Address::class ); 
			}  
		}
    ?>
*creating a sorter*

    <?php  
	class AddressSorter implements SortsLists  
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
		public function compare( $address1, $address2 )
		{
			/**
			 * @var Address $address1
			 * @var Address $address2
			 */
			if( $address1->getCity() == $address2->getCity() )
			{
				if( $address1->getStreet() == $address2->getStreet() )
				{
					return 0;
				}	
				else
				{
					$result = strcmp( $address1->getStreet(), $address2->getStreet() );
				} 
			}
			else
			{
				$result = strcmp( $address1->getCity(), $address2->getCity() );
			}

			if( $this->sortDirection === SORT_DESC )
			{
				return - ( $result );
			}
	
			return $result;
		}
	}
    ?>
*using typehint for the list and sort with the created sorter*

	<?php
	class AnnoyingHandler
	{		
		public function sortAddresses( AddressList $addresses )
		{
			$addressSorter = new AddressSorter( SORT_DESC );
			$addresses->sortBy( $addressSorter );			
		}
	}
    ?>

*creating a filter*

	<?php
	class BeginningStreetNameFilter implements FindsItems
	{
		private $beginningStreetName;

		public function __construct( $beginningStreetName )
		{
			if( !is_string( $beginningStreetName ) )
			{
				throw new Exception( 'Street name must be a string' );
			}
			
			$this->beginningStreetName = $beginningStreetName;
		}

		public function isValid( $address )
		{
			return ( preg_match( sprintf( '!^%s!', $this->beginningStreetName ), $address->getStreet() ) );
		}
	}
    ?>

*using the filter*

	<?php
	$beginningStreetNameFilter 	= new BeginningStreetNameFilter( 'Arlington' );

	$firstAddressFound 			= $addresses->find( $beginningStreetNameFilter );
	$lastAddressFound 			= $addresses->findLast( $beginningStreetNameFilter );
	$foundAddresses				= $addresses->findAll( $beginningStreetNameFilter );	
    ?>