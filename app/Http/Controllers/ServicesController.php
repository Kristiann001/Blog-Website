<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServicesController extends Controller
{
    // Show all services
    public function index(Request $request)
    {
        $query = Service::query();

        // Optional search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Use pagination instead of all()
        $services = $query->paginate(9); // 9 per page, adjust as needed

        // Preserve the search query in pagination links
        $services->appends($request->only('search'));

        return view('services', compact('services'));
    }
}
