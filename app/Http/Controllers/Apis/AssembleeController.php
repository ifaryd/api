<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AssembleeStoreRequest as DataStoreRequest;
use App\Http\Services\AssembleeService as DataService;

class AssembleeController extends Controller
{
    private $dataService;
    
    function __construct(DataService $dataService){
      $this->dataService = $dataService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
      return $this->dataService->filterDataModel($request);   
    } 

    public function dirigeantAssemblee($assemblee_id){
      return $this->dataService->dirigeantAssemblee($assemblee_id); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataStoreRequest $request)
    {
      $body = $request->validated();
      return $this->dataService->createDataModel($body);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return $this->dataService->findDataModel($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DataStoreRequest $request, $id)
    {
      $body = $request->validated();
      return $this->dataService->updateDataModel($body, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      return $this->dataService->deleteDataModel($id);
    }
}
