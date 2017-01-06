<?php namespace LasseRafn\Dinero\Models;

use LasseRafn\Dinero\Utils\Model;

class Product extends Model
{
	protected $entity     = 'products';
	protected $primaryKey = 'ProductGuid';
	protected $fillable   = [
		'CreatedAt',
		'UpdatedAt',
		'DeletedAt',
		'ProductGuid',
		'ProductNumber',
		'Name',
		'BaseAmountValue',
		'Quantity',
		'AccountNumber',
		'Unit',
	];

	public $CreatedAt;
	public $UpdatedAt;
	public $DeletedAt;
	public $ProductGuid;
	public $ProductNumber;
	public $Name;
	public $BaseAmountValue;
	public $Quantity;
	public $AccountNumber;
	public $Unit;
}