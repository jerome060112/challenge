<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use App\Events\CustomerPubSub;
use App\Repositories\CustomerRepositoryInterface;

class ImportCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:import-customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customers from 3rd party data provider and save to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        parent::__construct();
        $this->customerRepository = $customerRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $randomUserApi =  env('API_URL');
        $url =  "$randomUserApi/api/?nat=au&results=100";

        $users = json_decode(
            file_get_contents($url),
            true
        );

        foreach ($users['results'] as $user) {
            $customer = [
                'username' => $user['login']['username'],
                'firstname' => $user['name']['first'],
                'lastname' => $user['name']['last'],
                'password' => Crypt::encrypt($user['login']['password']),
                'email' => $user['email'],
                'gender' => $user['gender'],
                'country' => $user['location']['country'],
                'city' => $user['location']['city'],
                'phone' => $user['phone'],
            ];

            $this->customerRepository->create($customer);
        }
    }
}
