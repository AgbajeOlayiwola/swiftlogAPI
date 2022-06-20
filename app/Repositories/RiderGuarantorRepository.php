<?php

namespace App\Repositories;


use App\Models\RiderGuarantor;
use App\Repositories\Interfaces\RiderGuarantorRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class RiderGuarantorRepository extends BaseRepository implements RiderGuarantorRepositoryInterface
{
    public function __construct(RiderGuarantor $model)
    {
        parent::__construct($model);
    }

    public function create(array $data): RiderGuarantor
    {
        return $this->model->create($data);
    }
}
