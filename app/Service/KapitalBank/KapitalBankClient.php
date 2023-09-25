<?php

declare(strict_types=1);

namespace App\Service\KapitalBank;

use GuzzleHttp\Client;

class KapitalBankClient
{
    private const PURCHASE_PATH = '/Exec';
    private const CURRENCY_AZN = 944;

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://tstpg.kapitalbank.az:5443',
            'verify' => false,
            'ssl_key' => [
                storage_path('app/certs/merchant_name.key'), // todo move to construct
            ],
            'cert' => storage_path('app/certs/testmerchant.crt'), // todo move to construct
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ],
        ]);
    }

    public function purchase(PurchaseDto $purchaseDto)
    {
        $approve_url = $cancel_url = $decline_url = 'https://webhook.site/3a117021-5264-4d90-acdd-5c5d4d126894';

        $xml = XmlHelper::generateXML([
            'Request' => [
                'Operation' => 'CreateOrder',
                'Language' => 'EN', // todo change
                'Order' => [
                    'OrderType' => 'Purchase',
                    'Merchant' => 'E1000010',
                    'Amount' => (int) bcmul($purchaseDto->amount, '100'),
                    'Currency' => self::CURRENCY_AZN,
                    'Description' => sprintf('Purchase product %s', $purchaseDto->productTitle),
                    'ApproveURL' => $approve_url, // todo generate with transaction_id
                    'CancelURL' => $cancel_url, // todo generate with transaction_id
                    'DeclineURL' => $decline_url, // todo generate with transaction_id
                ]
            ]
        ]);

        $resp = $this->client->post(self::PURCHASE_PATH, ['body' => $xml]);
        $resData = $resp->getBody()->getContents();


        // <TKKPG><Response><Operation>CreateOrder</Operation><Status>00</Status><Order><OrderID>664396</OrderID><SessionID>865F74E9BD489BC5197B112646E99C7E</SessionID><URL>https://tstpg.kapitalbank.az/index.jsp</URL></Order></Response></TKKPG>
//        <TKKPG><Response><Operation>CreateOrder</Operation><Status>00</Status><Order><OrderID>661917</OrderID><SessionID>161CCFD26D9A36245D36DFF689BC3DA0</SessionID><URL>https://tstpg.kapitalbank.az/index.jsp</URL></Order></Response></TKKPG>

        return $this;
    }
}
