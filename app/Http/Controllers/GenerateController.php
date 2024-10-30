<?php

namespace App\Http\Controllers;


use App\Exceptions\ApiException;
use App\Models\GenerateRecord;
use App\Services\GenerateBackendCodeService;
use App\Services\GenerateFrontCodeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GenerateController extends BaseController
{
    public function generate()
    {
    }

    public function del(string $tableName)
    {
        app(GenerateBackendCodeService::class)->delete('generate_records');
    }

}
