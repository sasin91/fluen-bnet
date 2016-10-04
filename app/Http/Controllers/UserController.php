<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  User $model
     * @return \Illuminate\Http\Response
     */
    public function show(User $model)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $model
     * @return \Illuminate\Http\Response
     */
    public function edit(User $model)
    {
        return view('user.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $model)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $model)
    {
        //
    }
}
