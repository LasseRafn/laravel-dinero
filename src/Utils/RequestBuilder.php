<?php


namespace LasseRafn\Dinero\Utils;


use Illuminate\Support\Collection;
use LasseRafn\Dinero\Builders\Builder;

class RequestBuilder
{
	private $builder;

	protected $parameters = [];
	protected $dateFormat = 'Y-m-d\TH:i:s\Z';

	public function __construct( Builder $builder )
	{
		$this->parameters['page'] = 0;
		$this->parameters['pageSize'] = 100;

		$this->builder = $builder;
	}

	/**
	 * @param Collection|array|integer|string $fields
	 *
	 * @return $this
	 */
	public function select( $fields )
	{
		if(!isset($this->parameters['fields']))
		{
			$this->parameters['fields'] = [];
		}

		if ( is_array( $fields ) )
		{
			foreach ( $fields as $field )
			{
				$this->parameters['fields'][] = $field;
			}
		}
		elseif ( is_string( $fields ) || is_int( $fields ) )
		{
			$this->parameters['fields'][] = $fields;
		}
		elseif ( typeOf( $fields ) === Collection::class )
		{
			$fields;

			foreach ( $fields->toArray() as $field )
			{
				$this->parameters['fields'][] = $field;
			}
		}

		return $this;
	}

	/**
	 * @param $page
	 *
	 * @return $this
	 */
	public function page($page)
	{
		$this->parameters['page'] = $page;

		return $this;
	}

	/**
	 * @param $pageSize
	 *
	 * @return $this
	 */
	public function perPage($pageSize)
	{
		$this->parameters['pageSize'] = $pageSize;

		return $this;
	}

	/**
	 * @return $this
	 */
	public function deletedOnly()
	{
		$this->parameters['deletedOnly'] = 'true';

		return $this;
	}

	/**
	 * @param \DateTime $date
	 *
	 * @return $this
	 */
	public function since(\DateTime $date)
	{
		$this->parameters['changesSince'] = $date->format($this->dateFormat);

		return $this;
	}

	/**
	 * @return array
	 */
	private function buildParameters()
	{
		$parameters = http_build_query($this->parameters);

		if( $parameters !== '')
		{
			$parameters = "?{$parameters}";
		}

		return $parameters;
	}

	/**
	 * @return Collection|Model[]
	 */
	public function get( )
	{
		$response = $this->builder->get($this->buildParameters());

		return $response;
	}

	/**
	 * @param bool $sleep
	 *
	 * @return Collection
	 */
	public function all($sleep = true)
	{
		$items = collect([]);

		while(count($response = $this->builder->get($this->buildParameters())) > 0)
		{
			foreach($response as $item)
			{
				$items->push($item);
			}

			$this->page($this->parameters['page'] + 1);

			if( $sleep)
			{
				usleep(200);
			}
		}

		return $items;
	}

	public function find($guid)
	{
		return $this->builder->find($guid);
	}
}