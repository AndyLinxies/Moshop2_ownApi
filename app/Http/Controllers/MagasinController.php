<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMagasinRequest;
use App\Http\Requests\UpdateMagasinRequest;
use App\Models\Magasin;

class MagasinController extends Controller
{
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
     * @param  \App\Http\Requests\StoreMagasinRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMagasinRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Magasin  $magasin
     * @return \Illuminate\Http\Response
     */
    public function show(Magasin $magasin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Magasin  $magasin
     * @return \Illuminate\Http\Response
     */
    public function edit(Magasin $magasin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMagasinRequest  $request
     * @param  \App\Models\Magasin  $magasin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMagasinRequest $request, Magasin $magasin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Magasin  $magasin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Magasin $magasin)
    {
        //
    }
}
