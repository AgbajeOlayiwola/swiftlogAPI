<?php
namespace App\Repositories\Interfaces;

use App\Models\RiderGuarantor;

interface RiderGuarantorRepositoryInterface {
    public function create(array $data): RiderGuarantor;
}
