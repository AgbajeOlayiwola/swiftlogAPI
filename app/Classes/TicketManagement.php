<?php

namespace App\Classes;


use App\Repositories\Interfaces\TicketCategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class TicketManagement
{

    private $ticketCategoryRepository;

    public function __construct(TicketCategoryRepositoryInterface $ticketCategoryRepository)
    {
        $this->ticketCategoryRepository = $ticketCategoryRepository;
    }

    public function createCategory(array $data) {
        return response()->created(
            "Successfully created category",
            $this->ticketCategoryRepository->create($data),
            "category"
        );
    }

    public function categories() {
        return response()->fetch(
            'Categories fetched Successfully',
            $this->ticketCategoryRepository->all(),
            'categories'
        );
    }

    public function createUser(array $data) {
        $data['user_id'] = Auth::user()->id;
        return response()->created(
            "Successfully created ticket",
            $this->ticketCategoryRepository->createUser($data),
            "ticket"
        );
    }

    public function allUser() {
        return response()->fetch(
            'Tickets fetched Successfully',
            $this->ticketCategoryRepository->allUser(),
            'tickets'
        );
    }
}
