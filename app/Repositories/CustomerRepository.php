<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class CustomerRepository implements CustomerRepositoryInterface
{

    /**
     * Return full list of Customers
     *
     * @return Customer[]
     */
    public function getAll()
    {
        return Customer::select(
            DB::raw("
                CONCAT(firstname,' ',lastname) as fullname,
                email,
                username,
                gender,
                country,
                city,
                phone
            ")
        )->get();
    }

    /**
     * Find a specific Customer
     *
     * @param $id
     *
     * @return mixed
     */
    public function find(int $id)
    {
        return ( new Customer )->find($id);
    }

    /**
     * Create one new Customer
     *
     * @param array $data
     *
     * @return Customer|null
     */
    public function create(array $data)
    {
        $customer      = new Customer;
        $customerExist = $customer->where('email', $data['email'])->first();
        if ($customerExist) {
            return null;
        }

        return $customer->create($data);
    }

    /**
     * Update Customer information
     *
     * @param int   $id
     * @param array $data
     *
     * @return Customer
     * @throws QueryException
     */
    public function update(int $id, array $data)
    {
        $customer = ( new Customer )->where('id', $id)->first();

        $customer->fill($data);
        $customer->save();

        return $customer;
    }

    /**
     * Delete Customer information
     *
     * @param int $id
     *
     * @return int
     */
    public function delete(int $id)
    {
        return Customer::destroy($id);
    }
}
