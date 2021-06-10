<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\QueryException;

interface CustomerRepositoryInterface
{
    /**
     * Return full list of Customers
     *
     * @return Customer[]
     */
    public function getAll();

    /**
     * Find a specific Customer
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * Create one new Customer
     *
     * @param array $data
     * @return Customer|null
     */
    public function create(array $data);

    /**
     * Update Customer information
     *
     * @param int   $id
     * @param array $data
     *
     * @return Customer
     * @throws QueryException
     */
    public function update(int $id, array $data);

    /**
     * Delete Customer information
     *
     * @param int $id
     *
     * @return int
     */
    public function delete(int $id);
}
