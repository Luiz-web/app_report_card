<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\Request;
use App\Repositories\StudentRepository;

class StudentController extends Controller
{
    public function __construct(Student $student) {
        $this->student = $student;
        $this->msgError = 'The researched student is not in the database';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $studentRepository = new StudentRepository($this->student);

        if($request->has('relational_attrs')) {
            $relational_attrs = 'schoolYear:id,'.$request->relational_attrs;
            $studentRepository->selectRelationalAttributes($relational_attrs);
        }

        if($request->has('area_attrs')) {
            $area_attrs = 'professionalFocus:id,'.$request->area_attrs;
            $studentRepository->selectProAreaAttributes($area_attrs);
        }

        if($request->has('filters')) {
            $filters = $request->filters;
            $studentRepository->filter($filters);
        }

        if($request->has('attrs')) {
            $attrs = $request->attrs;
            $studentRepository->selectAttributes($attrs);
        }

        return response()->json($studentRepository->getResult(), 200);
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
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        $student = $this->student->create([
            'id_school_year' => $request->id_school_year,
            'id_professional_focus' => $request->id_professional_focus,
            'name' => $request->name,
            'age' => $request->age,
            'first_score' => $request->first_score,
            'second_score' => $request->second_score,
        ]);

        return response()->json($student, 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = $this->student->find($id);

        if($student === null) {
            return response()->json(['error' => 'Unable to show data. '.$this->msgError], 404);
        }

        return response()->json($student, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, $id)
    {
        $student = $this->student->find($id);

        if($student === null) {
            return response()->json(['error' => 'Unable to update data. '.$this->msgError, 404]);
        }

        $student->fill($request->all());
        $student->save();

        return response()->json($student, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = $this->student->find($id);

        if($student === null) {
            return response()->json(['error' => 'Unable to delete data. '.$this->msgError], 404);
        }

        $student->delete();
        return response()->json(['msg' => "The data referred to the student $student->name  has been successfully deleted from the database"], 200);
        
    }
}
