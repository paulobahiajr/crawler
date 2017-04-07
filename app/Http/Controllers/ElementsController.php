<?php

namespace App\Http\Controllers;

use App\Element;
use App\Services\CrawlService;
use Illuminate\Http\Request;

class ElementsController extends Controller
{
    private $service;

    public function __construct(CrawlService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        return view('index.index');
    }

    public function cnpq()
    {
        $this->service->crawlCnpq();
        $data = Element::paginate(16);
        return view('cnpq-data.cnpq-data', compact('data'));
    }
}
