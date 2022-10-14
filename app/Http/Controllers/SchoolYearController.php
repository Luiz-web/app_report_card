<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use App\Repositories\SchoolYearRepository;
use App\Http\Requests\StoreSchoolYearRequest;
use App\Http\Requests\UpdateSchoolYearRequest;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    public function __construct(SchoolYear $schoolYear) {
        $this->schoolYear = $schoolYear;
        $msgError = 'The researched school year area does not exist in the database';
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schoolYearRepository = new schoolYearRepository($this->schoolYear);

        if($request->has('relational_attrs')) {
            $relational_attrs = 'students:id,'.$request->relational_attrs;
            $schoolYearRepository->selectRelationalAttributes($relational_attrs);
        }

        if($request->has('filters')) {
            $filters = $request->filters;
            $schoolYearRepository->filter($filters);
        }

        if($request->has('attrs')) {
            $attrs = $request->attrs;
            $schoolYearRepository->selectAttributes($attrs);
        }

        return response()->json($schoolYearRepository->getResult(), 200);
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
     * @param  \App\Http\Requests\StoreSchoolYearRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSchoolYearRequest $request)
    {
        $request->validate($this->schoolYear->rules());
       
        $schoolYear = $this->schoolYear->create([
            'school_year' => $request->school_year,
        ]);

        return response()->json($schoolYear, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schoolYear = $this->schoolYear->find($id);

        if($schoolYear === null) {
            return response()->json(['error' => 'Unable to show data. '.$this->msgErro], 404);
        }

        return response()->json($schoolYear, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSchoolYearRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSchoolYearRequest $request, $id)
    {
        $schoolYear = $this->schoolYear->find($id);

        if($schoolYear === null) {
            return response()->json(['error' => 'Unable to update data. '.$this->msgErro], 404);
        }

        $request->validate($this->schoolYear->rules());

        $schoolYear->fill($request->all());
        $schoolYear->save();

        return response()->json($schoolYear, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schoolYear = $this->schoolYear->find($id);

        if($schoolYear === null) {
            return response()->json(['error' => 'Unable to delete data. '.$this->msgErro], 404);
        }

        $schoolYear->delete();
        return response()->json(['msg' => 'The School year '.$schoolYear->school_year. ' has been successfully removed from the database'], 200);
    }
}
