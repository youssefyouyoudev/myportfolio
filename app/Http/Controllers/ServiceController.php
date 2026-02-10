<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::published()->orderBy('position')->get();

        return view('pages.services.index', compact('services'));
    }

    public function show( $service)
    {
        $service = Service::where('slug', $service)->firstOrFail();

        return view('pages.services.show', compact('service'));
    }
}
