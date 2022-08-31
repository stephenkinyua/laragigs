<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // get and show all listings
    public function index()
    {

        // $tag_query = request('tag');

        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
        ]);
    }


    // get and show all listings
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // show listing create form
    public function create()
    {
        return view('listings.create');
    }


    // save a new listing to the db
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['email', 'required'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        // dd($request->all());

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }
}
