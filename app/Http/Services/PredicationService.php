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

      $data;
      if($request->mobile && $request->langue){
        $data = DataModel::where('langue_id', $request->langue)->get();
        return DataResource::collection($data);
      }
      $predications = Langue::orderBy('id', "ASC")->whereHas('predications', function ($query){
      });
     
      if(!$request->langue){
        $predications = DataModel::with('langue')->get();
        if ($request->per_page){
            if($request->verset && $request->verset==='true'){
              $data = $predications->each->versets;
            }
            $data = paginate($predications, (int)$request->per_page);
        }
        else{
            return DataResource::collection($predications);;
            //$data = $predications->each->versets;
        }
      }
      else{
        //return $request->langue;
        $predications = DataModel::with('langue')->where('langue_id', $request->langue)->get();
        if($request->per_page){
            if($request->verset && $request->verset==='true'){
              $data = $predications->each->versets;
            }
            $data = paginate($predications, (int)$request->per_page);
        }
        else{
            if($request->verset && $request->verset==='true'){
              $data = $predications->each->versets;
            }

            else{
              $data = $predications;
            }
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
