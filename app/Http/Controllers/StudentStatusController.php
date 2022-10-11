<?php

namespace App\Http\Controllers;

use App\Models\StudentStatus;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Repositories\StudentStatusRepository;

class StudentStatusController extends Controller
{
    public function __construct(StudentStatus $studentStatus, Student $student) {
        $this->studentStatus = $studentStatus;
        $this->student = $student;
        $this->msgError = "The searched register is not in the database. Check the inserted data.";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentStatusRepository = new StudentStatusRepository($this->studentStatus);

        if($request->has('relational_attrs')) {
            $relational_attrs = 'students:id,'.$request->relational_attrs;
            $studentStatusRepository->selectRelationalAttributes($relational_attrs);
        }

        if($request->has('filters')) {
            $filters = $request->filters;
            $studentStatusRepository->filter($filters);
        }

        if($request->has('attrs')) {
            $attrs = $request->attrs;
            $studentStatusRepository->selectAttributes($attrs);
        }

        return response()->json($studentStatusRepository->getResult(), 200);
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
        $studentStatus = $this->studentStatus->create([
            'id_student' => $request->id_student,
            'total_score' => 0 ,
            'situation' => 'R',
        ]);
        
        $id = $studentStatus->id_student;
        $student = $this->student->find($id);

        $first_score = $student->first_score;
        $second_score = $student->second_score;

        $total_score = $first_score + $second_score;
        $situation = 'R';

        if($total_score >= 60) {
            $situation = 'A';
        }


        $studentStatus->update([
            'situation' => $situation,
            'total_score' => $total_score,
        ]);

        return response()->json($studentStatus, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(StudentStatus $studentStatus)
    {
        $studentStatus = $this->studentStatus->find($id);

        if($studentStatus === null) {
            return response()->json(['error' => 'Unable to show data. '.$this->msgError]);
        }

        return response()->json($studentStatus, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentStatus  $studentStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentStatus $studentStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studentStatus = $this->studentStatus->find($id);

        if($studentStatus === null) {
            return response()->json(['error' => 'Unable to update data. '.$this->msgError], 404);
        }
        

        $studentStatus->fill($request->all());
        $studentStatus->save();

        return response()->json($studentStatus, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $studentStatus = $this->studentStatus->find($id);
        $id = $studentStatus->id_student;

        if($studentStatus === null) {
            return response()->json(['error' => 'Unable to delete data. '.$this->msgError], 404);
        }
        $student = $this->student->find($id);
    
        $studentStatus->delete();
        return response()->json(['msg' => 'The status referred to the student  '.$student->name. ' has been successfully deleted in the database'], 200);
    }

}

