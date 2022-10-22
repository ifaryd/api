<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\PredicationResource as DataResource;
use App\Models\Predication as DataModel;
use App\Models\Langue;

class PredicationService{

    public function findDataModel($id)
    {
      $data = $this->find($id);
      $data->versets = $data->versets;
      $data->langue = $data->langue;
      return new DataResource($data);
    }
  
    public function filterDataModel(Request $request){

      $predications = Langue::orderBy('id', "ASC")->whereHas('predications', function ($query){
      });
      $data;

      if(!$request->langue){
        $predications = DataModel::with('langue')->get();
        if ($request->per_page){
            $data = $predications->each->versets;
            $data = paginate($data, (int)$request->per_page);
        }
        else{
            return DataResource::collection($predications);;
            //$data = $predications->each->versets;
        }
      }
      else{
        //return $request->langue;
        $predications = DataModel::where('langue_id', $request->langue)->get();
        if($request->per_page){
            $data = $predications->each->versets;
            $data = paginate($data, (int)$request->per_page);
        }
        else{
            $data = $predications->each->versets;
        }
      }
      return DataResource::collection($data);
    }

    public function createDataModel($body){
  
      $data = DataModel::create($body);
      return new DataResource($data);
    }
  
    public function updateDataModel($body, $id){
  
      $data = $this->find($id);
      return $data->update($body);
    }
  
    public function deleteDataModel($id){
  
      $data = $this->find($id);
      return $data->delete();
    }
  
    public function find($id)
    {
      $data = DataModel::find($id);
      if (!$data) modelNotFound();
      return $data;
    }

}
