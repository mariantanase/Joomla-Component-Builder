<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Interfaces;


/**
 * Database Load Interface
 * 
 * @since 3.2.0
 */
interface LoadInterface
{
	/**
	 * Load data rows as an array of associated arrays
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array        $tables   Array of tables to search
	 * @param   array|null   $where    Array of where key=>value match exist
	 * @param   array|null   $order    Array of how to order the data
	 * @param   int|null     $limit    Limit the number of values returned
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function rows(array $select, array $tables, ?array $where = null,
		?array $order = null, ?int $limit = null): ?array;

	/**
	 * Load data rows as an array of objects
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array        $tables   Array of tables to search
	 * @param   array|null   $where    Array of where key=>value match exist
	 * @param   array|null   $order    Array of how to order the data
	 * @param   int|null     $limit    Limit the number of values returned
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function items(array $select, array $tables, ?array $where = null,
		?array $order = null, ?int $limit = null): ?array;

	/**
	 * Load data row as an associated array
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array       $tables  Array of tables to search
	 * @param   array|null  $where   Array of where key=>value match exist
	 * @param   array|null  $order    Array of how to order the data
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function row(array $select, array $tables, ?array $where = null, ?array $order = null): ?array;

	/**
	 * Load data row as an object
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array       $tables  Array of tables to search
	 * @param   array|null  $where   Array of where key=>value match exist
	 * @param   array|null  $order    Array of how to order the data
	 *
	 * @return  object|null
	 * @since   3.2.0
	 **/
	public function item(array $select, array $tables, ?array $where = null, ?array $order = null): ?object;

	/**
	 * Load one value from a row
	 *
	 * @param   array        $select   Array of selection keys
	 * @param   array       $tables  Array of tables to search
	 * @param   array|null  $where   Array of where key=>value match exist
	 * @param   array|null  $order    Array of how to order the data
	 *
	 * @return  mixed
	 * @since   3.2.0
	 **/
	public function value(array $select, array $tables, ?array $where = null, ?array $order = null);

}

