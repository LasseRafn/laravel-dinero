<?php namespace LasseRafn\Dinero\Models;

use LasseRafn\Dinero\Utils\Model;

class Contact extends Model
{
	protected $entity     = 'contacts';
	protected $primaryKey = 'contactGuid';
	protected $fillable   = [
		'contactGuid',
		'createdAt',
		'updatedAt',
		'deletedAt',
		'isDebitor',
		'isCreditor',
		'externalReference',
		'name',
		'street',
		'zipCode',
		'city',
		'countryKey',
		'phone',
		'email',
		'webpage',
		'attPerson',
		'vatNumber',
		'eanNumber',
		'paymentConditionType',
		'paymentConditionNumberOfDays',
		'isPerson',
	];

	public $contactGuid;
	public $createdAt;
	public $updatedAt;
	public $deletedAt;
	public $isDebitor;
	public $isCreditor;
	public $externalReference;
	public $name;
	public $street;
	public $zipCode;
	public $city;
	public $countryKey;
	public $phone;
	public $email;
	public $webpage;
	public $attPerson;
	public $vatNumber;
	public $eanNumber;
	public $paymentConditionType;
	public $paymentConditionNumberOfDays;
	public $isPerson;
}