<?php namespace LasseRafn\Dinero\Builders;

use GuzzleHttp\Exception\ClientException;
use LasseRafn\Dinero\Exceptions\DineroRequestException;
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
		try
		{
			$response = $this->request->curl->get( "{$this->entity}/{$id}" );
			$responseData = json_decode( $response->getBody()->getContents() );

			return new $this->model( $this->request, $responseData );
		} catch ( ClientException $exception )
		{
			throw new DineroRequestException($exception);
		}

	}

	/**
	 * @param string $parameters
	 *
	 * @return \Illuminate\Support\Collection|Model[]
	 */
	public function get( $parameters = '' )
	{
		try
		{
			$response = $this->request->curl->get( "{$this->entity}{$parameters}" );
			$responseData = json_decode( $response->getBody()->getContents() );
		} catch ( ClientException $exception )
		{
			throw new DineroRequestException($exception);
		} catch ( \RuntimeException $exception )
		{
			// todo...
		}

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
}