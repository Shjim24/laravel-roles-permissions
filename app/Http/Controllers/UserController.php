<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Return a view or data for users listing
        return view('users.index');
    }

    // Add other methods (create, store, show, edit, update, destroy, toggleStatus) as needed
}