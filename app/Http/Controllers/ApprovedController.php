<?php

namespace App\Http\Controllers;

use App\Models\Approved;
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
    public function store()
    {
        $new_registers = Approved::gettingnewRegisters();
     
        //If all the approved students are already on the approved table(when the new_registers is empty), the method will finish with the message.
        if(empty($new_registers)) {
            return response()->json(['msg' => 'The Approved table is already synchronized  with the situations table']);
        //The data will be filled dynamically
        } else {
            $new_students = [];
            foreach($new_registers as $new_register) {
                $approved = $this->approved->create([
                    'name' => $new_register->name,
                    'situation_id' => $new_register->id,
                    'school_year' =>  $new_register->students->schoolYear->school_year,
                    'professional_area' => $new_register->students->professionalFocus->professional_area,
                ]);
                $new_students[] = $approved;
            }
        }

        return response()->json($new_students, 201);
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
        return response()->json(['error', 'the update method is prohibited'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Approved  $approved
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approved $approved)
    {
        return response()->json(['error', 'the delete  method is prohibited'], 403);
    }
}
