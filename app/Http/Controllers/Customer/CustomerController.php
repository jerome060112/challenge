<?php

namespace App\Http\Controllers\Customer;

use App\Events\CustomerPubSub;
use App\Http\Controllers\Controller;
use App\Repositories\CustomerRepositoryInterface;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    use ApiResponser;

    /**
     * @var customerRepositoryInterface
     */
    private $customerRepository;

    /**
     * Create a new controller instance.
     *
     * @param customerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Return full list of Customers
     *
     * @Get("/Customers")
     *
     * @return JsonResponse
     */
    public function index()
    {
        $customers = $this->customerRepository->getAll();

        return $this->successResponseWithData($customers);
    }

    /**
     * Create one new Customer
     *
     * @Post("Customers")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $customer = $this->customerRepository->create($request->all());

        if (!$customer) {
            return $this->errorResponse('Error in creating the Customer', Response::HTTP_CONFLICT);
        }

        broadcast(new CustomerPubSub($customer, 'created'))->toOthers();

        return $this->successResponseWithData($customer, Response::HTTP_CREATED);
    }


    /**
     * View a specific Customer
     *
     * @Get("Customers/{id}" where={"id": "[0-9]+"})
     *
     * @param int $CustomerId
     * @return JsonResponse
     */
    public function show(int $CustomerId)
    {
        $customer = $this->customerRepository->find($CustomerId);

        if (! $customer) {
            return $this->errorResponse('Customer Not Found', Response::HTTP_NOT_FOUND);
        }

        return $this->successResponseWithData($customer);
    }
}
