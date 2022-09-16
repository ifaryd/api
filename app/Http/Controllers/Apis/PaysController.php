<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PaysStoreRequest as DataStoreRequest;
use App\Http\Services\PaysService as DataService;
use App\Models\Pays as DataModel;
use Illuminate\Support\Facades\DB;
class PaysController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DataStoreRequest $request)
    {
      $body = $request->validated();
      if(isset($request->langue_id) && !empty($request->langue_id)){
        $body['langue_id'] = $request->langue_id;
      }

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
      if(isset($request->langue_id) && !empty($request->langue_id)){
        $body['langue_id'] = $request->langue_id;
      }
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

    public function merges(){

    }
}
