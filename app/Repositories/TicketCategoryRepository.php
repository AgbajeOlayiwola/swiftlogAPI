<?php


namespace App\Repositories;


use App\Models\TicketCategory;
use App\Models\UserTicket;
use App\Repositories\Interfaces\TicketCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TicketCategoryRepository extends BaseRepository implements TicketCategoryRepositoryInterface
{
    protected $userTicket;
    public function __construct(TicketCategory $model, UserTicket $userTicket)
    {
        parent::__construct($model);
        $this->userTicket = $userTicket;
    }

    public function create(array $data): TicketCategory
    {
        return $this->model->create($data);
    }

    public function all(): Collection
    {
        return $this->model->get();
    }

    public function createUser(array $data): UserTicket {
        return $this->userTicket->create($data);
    }

    public function allUser(): Collection {
        return $this->userTicket->with('ticket', 'user')->get();
    }
}
