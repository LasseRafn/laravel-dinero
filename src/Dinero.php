<?php namespace LasseRafn\Dinero;

use GuzzleHttp\Exception\ClientException;
use LasseRafn\Dinero\Builders\ContactBuilder;
use LasseRafn\Dinero\Builders\InvoiceBuilder;
use LasseRafn\Dinero\Requests\ContactRequestBuilder;
use LasseRafn\Dinero\Requests\InvoiceRequestBuilder;
use LasseRafn\Dinero\Utils\Request;
use LasseRafn\Dinero\Utils\RequestBuilder;

class Dinero
{
	protected $request;

	private $clientId;
	private $clientSecret;

	public function __construct( $clientId, $clientSecret, $token = null, $org = null )
	{
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;

		$this->request = new Request( $clientId, $clientSecret, $token, $org );
	}

	public function setAuth($token, $org = null)
	{
		$this->request = new Request( $this->clientId, $this->clientSecret, $token, $org );
	}

	public function auth( $apiKey, $orgId = null )
	{
		try
		{
			$response = json_decode($this->request->curl->post( $this->request->getAuthUrl(), [
				'form_params' => [
					'grant_type' => 'password',
					'scope'      => 'read write',
					'username'   => $apiKey,
					'password'   => $apiKey
				]
			] )->getBody()->getContents());

			$this->setAuth($response->access_token, $orgId);

			return $response;
		} catch ( ClientException $exception )
		{
			if ( $exception->hasResponse() )
			{
				$error = json_decode( json_decode( $exception->getResponse()->getBody()->getContents() )->message )->error;

				throw new ClientException( "{$exception->getRequest()->getUri()}: $error", $exception->getRequest(), $exception->getResponse(), $exception->getPrevious(), $exception->getHandlerContext() );
			}
		}
	}

	public function contacts()
	{
		return new ContactRequestBuilder(new ContactBuilder($this->request));
	}

	public function invoices()
	{
		return new InvoiceRequestBuilder(new InvoiceBuilder($this->request));
	}

	public function products()
	{
//		return new RequestBuilder(new ProductBuilder($this->request));
	}
}