<?php


namespace LasseRafn\Dinero\Utils;


use Illuminate\Support\Collection;
use LasseRafn\Dinero\Builders\Builder;

class RequestBuilder
{
	private $builder;

	private $fields = [];
	private $queryFilter = null; // todo set these
	private $changesSince = null; // todo set these
	private $deletedOnly = null;
	private $page = 0;
	private $pageSize = 100;

	public function __construct( Builder $builder )
	{
		$this->builder = $builder;
	}

	/**
	 * @param Collection|array|integer|string $fields
	 *
	 * @return $this
	 */
	public function select( $fields )
	{
		if ( is_array( $fields ) )
		{
			foreach ( $fields as $field )
			{
				$this->fields[] = $field;
			}
		}
		elseif ( is_string( $fields ) || is_int( $fields ) )
		{
			$this->fields[] = $fields;
		}
		elseif ( typeOf( $fields ) === Collection::class )
		{
			$fields;

			foreach ( $fields->toArray() as $field )
			{
				$this->fields[] = $field;
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
		$this->page = $page;

		return $this;
	}

	/**
	 * @param $pageSize
	 *
	 * @return $this
	 */
	public function perPage($pageSize)
	{
		$this->pageSize = $pageSize;

		return $this;
	}

	/**
	 * @return $this
	 */
	public function deletedOnly()
	{
		$this->deletedOnly = true;

		return $this;
	}

	/**
	 * @return array
	 */
	private function buildParameters()
	{
		$parameters = [];

		$parameters['page'] = $this->page;
		$parameters['pageSize'] = $this->pageSize;

		if( count($this->fields) > 0)
		{
			$parameters['fields'] = $this->fields;
		}

		if( $this->deletedOnly !== null)
		{
			$parameters['deletedOnly'] = 'true';
		}

		if( $this->changesSince !== null)
		{
			$parameters['changesSince'] = $this->changesSince;
		}

		if( $this->queryFilter !== null)
		{
			$parameters['queryFilter'] = $this->queryFilter;
		}

		$parameters = http_build_query($parameters);

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

			$this->page($this->page + 1);

			if( $sleep)
			{
				usleep(200);
			}
		}

		return $items;
	}
}