<?php namespace LasseRafn\Dinero\Builders;

use LasseRafn\Dinero\Utils\Model;
use LasseRafn\Dinero\Utils\Request;

class Builder
{
	private   $request;
	protected $entity;

	/** @var Model */
	protected $model;

	function __construct( Request $request )
	{
		$this->request = $request;
	}

	/**
	 * @param $id
	 *
	 * @return mixed|Model
	 */
	public function find( $id )
	{
		$response = $this->request->curl->get( "{$this->entity}/{$id}" );

		// todo check for errors and such

		$responseData = json_decode( $response->getBody()->getContents() );

		return new $this->model( $this->request, $responseData );
	}

	/**
	 * @param string $parameters
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 */
	public function get( $parameters = '' )
	{
		$response = $this->request->curl->get( "{$this->entity}{$parameters}" );

		// todo check for errors and such

		$responseData = json_decode( $response->getBody()->getContents() );

		/** @var array $fetchedItems */
		$fetchedItems = $responseData->Collection;

		$items = collect( [] );
		foreach ( $fetchedItems as $item )
		{
			/** @var Model $model */
			$model = new $this->model( $this->request, $item );

			$items->push( $model );
		}

		return $items;
	}

	/**
	 * @return \Illuminate\Support\Collection|Model[]
	 */
	public function all()
	{
		$page     = 0;
		$pagesize = 100;
		$hasMore  = true;
		$items    = collect( [] );

		while ( $hasMore )
		{
			$response = $this->request->curl->get( "{$this->entity}?page={$page}&pageSize={$pagesize}" );

			// todo check for errors and such

			$responseData = json_decode( $response->getBody()->getContents() );

			/** @var array $fetchedItems */
			$fetchedItems = $responseData->Collection;

			if ( count( $fetchedItems ) === 0 )
			{
				$hasMore = false;

				break;
			}

			foreach ( $fetchedItems as $item )
			{
				/** @var Model $model */
				$model = new $this->model( $this->request, $item );

				$items->push( $model );
			}

			$page ++;
		}

		return $items;
	}
}