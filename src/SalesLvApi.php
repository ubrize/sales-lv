<?php

namespace Ubrize\SalesLv;

use DomainException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;
use Ubrize\SalesLv\Exceptions\CouldNotSendNotification;
use function array_filter;
use function array_merge;
use function json_decode;

class SalesLvApi
{
    const COMMAND_SEND = 'SendOne';

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $sender;

    public function __construct(array $config)
    {
        $this->key = Arr::get($config, 'key');
        $this->sender = Arr::get($config, 'sender');
        $this->endpoint = Arr::get($config, 'endpoint', 'https://traffic.sales.lv/API:0.14/');

        $this->client = new HttpClient([
            'timeout' => 5,
            'connect_timeout' => 5,
        ]);
    }

    /**
     * @param array $params
     * @return mixed|ResponseInterface
     * @throws GuzzleException
     */
    public function send($params)
    {
        $base = [
            'APIKey' => $this->key,
            'Command' => self::COMMAND_SEND,
            'Sender' => $this->sender,
        ];

        $params = array_merge($base, array_filter($params));

        try {
            $response = $this->client->request('POST', $this->endpoint, ['form_params' => $params]);

            $response = json_decode((string)$response->getBody(), true);

            if (isset($response['Error'])) {
                throw new DomainException($response['Error'], 400);
            }

            return $response;
        } catch (DomainException $exception) {
            throw CouldNotSendNotification::salesLvRespondedWithAnError($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithSalesLv($exception);
        }
    }
}
