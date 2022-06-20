<?php

namespace App\Repositories;


use App\Models\Rider;
use App\Repositories\Interfaces\RiderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RiderRepository extends BaseRepository implements RiderRepositoryInterface {
    public function __construct(Rider $model) {
        parent::__construct($model);
    }

    public function create(array $data): Rider {
        return $this->model->create([
            'profile_pic' => $data['profile_pic'],
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'marital' => $data['marital'],
            'education' => $data['education'],
            'residential_address' => $data['residential_address'],
            'drivers_license' => $data['drivers_license'],
            'passport' => $data['passport'],
            'user_id' => $data['user_id']
        ]);
    }

    public function all(): Collection {
        return $this->model->with(
            'guarantors',
            'user',
            'orderRider',
            'orderRider.order',
            'score',
            'orderRider.order'
        )->get();
    }
}
