<?php

namespace App\Http\Controllers;


use App\Services\GenerateBackendCodeService;
use App\Services\GenerateFrontCodeService;

class GenerateController extends BaseController
{
    public function generate()
    {
//        GenerateBackendCodeService::init([
//            'path'       => 'finance',
//            'table_name' => 'fin_cost_items',
//            'prefix'     => 'fin',
//        ])
//        ->initController()
//            ->initLogic()
//            ->initRequest()
//            ->generate();

        app(GenerateFrontCodeService::class)
            ->init([
                'path'       => 'finance',
                'table_name' => 'fin_cost_items',
                'prefix'     => 'fin_',
            ])
            ->initIndex();
    }

    public function del()
    {
        GenerateBackendCodeService::delete('fin_cost_items');
    }

}
