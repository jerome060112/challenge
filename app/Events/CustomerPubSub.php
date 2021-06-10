<?php

namespace App\Events;

use App\Models\Customer;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CustomerPubSub implements ShouldBroadcast
{
    /**
     * @var Customer $customer
     */
    public $customer;

    /**
     * @var string $status
     */
    public $status;

    /**
     * Create a new event instance.
     *
     * @param Customer $customer
     * @param string $status
     */
    public function __construct(Customer $customer, string $status)
    {
        $this->customer = $customer;
        $this->status = $status;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['CustomerPubSub.'.$this->customer->id];
    }
}
