<?php namespace LasseRafn\Dinero\Requests;

use LasseRafn\Dinero\Builders\Builder;
use LasseRafn\Dinero\Utils\RequestBuilder;

class ContactRequestBuilder extends RequestBuilder
{
	public function __construct( Builder $builder )
	{
		$this->parameters['fields'] = 'Name,ContactGuid,ExternalReference,IsPerson,Street,ZipCode,City,CountryKey,Phone,Email,Webpage,AttPerson,VatNumber,EanNumber,PaymentConditionType,PaymentConditionNumberOfDays,CreatedAt,UpdatedAt,DeletedAt';

		parent::__construct( $builder );
	}
}