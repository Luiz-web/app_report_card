<?php

namespace App\Http\Controllers;

use App\Models\Approved;
use App\Models\Situation;
use App\Http\Requests\StoreApprovedRequest;
use App\Http\Requests\UpdateApprovedRequest;

class ApprovedController extends Controller
{
    public function __construct(Approved $approved) {
        $this->approved = $approved;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return response()->json(Approved::all());
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
     * @param  \App\Http\Requests\StoreApprovedRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApprovedRequest $request)
    {
        $approved_id = [];
        $situations_id = [];
        $new_registers = [];

        $situations = Situation::where('status', 'A')->orderBy('id')->get();
        foreach($situations as $situation) {
            $situations_id[] = $situation->id;
        }

        $approveds = Approved::all();
        foreach($approveds as $approved) {
            $approved_id[] = $approved->situation_id;
        } 

        $difference = array_diff($situations_id, $approved_id);
        
        $situations = Situation::with('students')->where('id', $difference)->get();
        foreach($situations as $situation) {
            $new_registers[] = $situation;
        }

        if(empty($new_registers)) {
            return response()->json(['msg' => 'The Approved table is already synchronized  with the situations table']);
        } else {
            foreach($new_registers as $new_register) {
                $approved = $this->approved->create([
                    'name' => $new_register->name,
                    'situation_id' => $new_register->id,
                    'school_year' =>  $new_register->students->schoolYear->school_year,
                    'professional_area' => $new_register->students->professionalFocus->professional_area,
                ]);
            }
        }

        return response()->json($approved, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $approved = $this->approved->find($id);

        if($approved === null) {
            return response()->json(['error' => 'Unabel to find data. Check if the ID number was entered correctly']);
        }

        return response()->json($approved);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Approved  $approved
     * @return \Illuminate\Http\Response
     */
    public function edit(Approved $approved)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApprovedRequest  $request
     * @param  \App\Models\Approved  $approved
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApprovedRequest $request, Approved $approved)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Approved  $approved
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approved $approved)
    {
        //
    }
}
