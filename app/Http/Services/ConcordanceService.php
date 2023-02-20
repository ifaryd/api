<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\ConcordanceResource as DataResource;
use App\Models\Concordance as DataModel;
use App\Models\User;

class ConcordanceService{

    public function findDataModel($id)
    {
      $data = $this->find($id);
      $data->verset_from = $data->verset_from;
      $data->verset_to = $data->verset_to;
      return new DataResource($data);
    }
  
    public function filterDataModel(Request $request){
      $data;
      if($request->mobile){
        $data = DataModel::all();
        return DataResource::collection($data);
      }
      else{
        $data = DataModel::with(['verset_from', 'verset_to'])->get();
      }
      return new DataResource($data);
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
