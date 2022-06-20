<?php

namespace App\Repositories\Interfaces;

use App\Models\TicketCategory;
use App\Models\UserTicket;
use Illuminate\Database\Eloquent\Collection;

interface TicketCategoryRepositoryInterface {
    public function create(array $data): TicketCategory;

    public function all(): Collection;

    public function createUser(array $data): UserTicket;

    public function allUser(): Collection;
}
