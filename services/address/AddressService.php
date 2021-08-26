<?php


namespace app\services\address;


use app\models\Addresses;
use app\models\Clients;

class AddressService
{

    /**
     * @var Addresses
     */
    private Addresses $address;
    /**
     * @var Clients
     */
    private Clients $client;

    public function __construct(Addresses $addresses, Clients $clients)
    {
        $this->address = $addresses;
        $this->client = $clients;
    }

    public function getPrincipalAddress()
    {
        return $this->address::find()
            ->where(['clients_id' => $this->client->id])
            ->andWhere(['principal' => true])
            ->one();
    }

    public function isPrincipalAddress(): ?Addresses
    {
        return $this->address::findOne([
            'id' => $this->address->id,
            'principal' => true
        ]);
    }

}