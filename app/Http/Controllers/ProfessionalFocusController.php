<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalFocus;
use App\Http\Requests\StoreProfessionalFocusRequest;
use App\Http\Requests\UpdateProfessionalFocusRequest;
use Illuminate\Http\Request;
use App\Repositories\ProfessionalFocusRepository;

class ProfessionalFocusController extends Controller
{

    public function __construct(ProfessionalFocus $professionalFocus) {
        $this->professionalFocus = $professionalFocus;
        $msgError = 'The researched professional area does not exist in the database';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $professionalFocusRepository = new ProfessionalFocusRepository($this->professionalFocus);

        if($request->has('relational_attrs')) {
            $relational_attrs = 'schoolYear:id,'.$request->relational_attrs;
            $professionalFocusRepository->selectRelationalAttributes($relational_attrs);
        }

        if($request->has('filters')) {
            $filters = $request->filters;
            $professionalFocusRepository->filter($filters);
        }

        if($request->has('attrs')) {
            $attrs = $request->attrs;
            $professionalFocusRepository->selectAttributes($attrs);
        }

        return response()->json($professionalFocusRepository->getResult(), 200);
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
     * @param  \App\Http\Requests\StoreProfessionalFocusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfessionalFocusRequest $request)
    {
        $professionalFocus = $this->professionalFocus->create([
            'professional_area' => $request->professional_area,
        ]);

        return response()->json($professionalFocus, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $professionalFocus = $this->professionalFocus->find($id);

        if($professionalFocus === null) {
            return response()->json(['error' => 'Unable to show data. '.$this->msgErro], 404);
        }

        return response()->json($professionalFocus, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfessionalFocus  $professionalFocus
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfessionalFocus $professionalFocus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfessionalFocusRequest  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfessionalFocusRequest $request, $id)
    {
        $professionalFocus = $this->professionalFocus->find($id);

        if($professionalFocus === null) {
            return response()->json(['error' => 'Unable to update data. '.$this->msgErro], 404);
        }

        $professionalFocus->fill($request->all());
        $professionalFocus->save();

        return reponse()->json($professionalFocus, 200);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $professionalFocus = $this->professionalFocus->find($id);

        if($professionalFocus === null) {
            return response()->json(['error' => 'Unable to delete data. '.$this->msgErro], 404);
        }

        $professionalFocus->delete();
        return response()->json(['msg' => 'The professional area '.$professionalFocus->professional_area. ' gas been successfully deleted in the database'], 200);
    }
}
