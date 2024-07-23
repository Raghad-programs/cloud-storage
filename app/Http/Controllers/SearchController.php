<?php

namespace App\Http\Controllers;

use App\Models\DepartmentStorage;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
    
        // Search for documents based on the user's query
        $results = DepartmentStorage::where('title', 'like', "%{$query}%")
                            ->get();
    
        // Pass the search results to a view
        return view('dashboard.layouts.searchbar-test', ['results' => $results]);
    }

}
