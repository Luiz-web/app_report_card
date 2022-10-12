<?php

namespace App\Http\Controllers;

use App\Models\Situation;
use App\Http\Requests\StoreSituationRequest;
use App\Http\Requests\UpdateSituationRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Repositories\situationRepository;

class SituationController extends Controller
{
    
    public function __construct(Situation $situation, Student $student) {
        $this->situation = $situation;
        $this->student = $student;
        $this->msgError = "The searched register is not in the database. Check the inserted data.";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $situationRepository = new SituationRepository($this->situation);

        if($request->has('relational_attrs')) {
            $relational_attrs = 'student:id,'.$request->relational_attrs;
            $situationRepository->selectRelationalAttributes($relational_attrs);
        }

        if($request->has('filters')) {
            $filters = $request->filters;
            $situationRepository->filter($filters);
        }

        if($request->has('attrs')) {
            $attrs = $request->attrs;
            $situationRepository->selectAttributes($attrs);
        }

        return response()->json($situationRepository->getResult(), 200);
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
     * @param  \App\Http\Requests\StoreSituationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSituationRequest $request)
    {
        $student_id = $request->student_id;
        $student = $this->student->find($student_id);

        $name = $student->name;
        $first_score = $student->first_score;
        $second_score = $student->second_score;
        $total_score = $first_score + $second_score;
        
        $status = 'R';

        if($total_score >= 60) {
            $status = 'A';
        }

        $situation = $this->situation->create([
            'student_id' => $student_id,
            'total_score' => $total_score,
            'status' => $status,
            'name' => $name
        ]);

        return response()->json($situation, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $situation = $this->situation->find($id);

        if($situation === null) {
            return response()->json(['error' => 'Unable to show data. '.$this->msgError]);
        }

        return response()->json($situation, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Situation  $situation
     * @return \Illuminate\Http\Response
     */
    public function edit(Situation $situation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSituationRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSituationRequest $request, $id)
    {
        $situation = $this->situation->find($id);

        if($situation === null) {
            return response()->json(['error' => 'Unable to update data. '.$this->msgError], 404);
        }
        
        $situation->fill($request->all());
        $situation->total_score = (double) $situation->total_score;
        $situation->save();

        return response()->json($situation, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $situation = $this->situation->find($id);
        
        if($situation === null) {
            return response()->json(['error' => 'Unable to delete data. '.$this->msgError], 404);
        }

        $situation->delete();
        return response()->json(['msg' => 'The status referred to the student '.$situation->name. ' has been successfully deleted in the database'], 200);
    }
}