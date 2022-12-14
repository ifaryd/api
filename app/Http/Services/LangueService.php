<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\LangueResource as DataResource;
use App\Models\Langue as DataModel;

class LangueService{

    public function findDataModel($id)
    {
      $data = DataModel::where('id', $id)->orWhere('initial', $id)->orWhere('libelle', $id)->first();
      if (!$data) return $data;
      return new DataResource($data);
    }
  
    public function filterDataModel(Request $request){
      
      $data;
      if($request->mobile){
        $data = DataModel::all();
        return DataResource::collection($data);
      }
      if ($request->per_page){
        $data = DataModel::orderBy('id', 'desc')->paginate((int)$request->per_page);
      }
      if($request->pays){
        $data = DataModel::with("pays")->lazyById(100);
      }
      else{
        $data = DataModel::lazyById(100);
      }
      return DataResource::collection($data);
    }
  
    public function createDataModel($body){
  
      $data = DataModel::create($body);
      $this->langue_pays($body, $data);
      return new DataResource($data);
    }
  
    public function updateDataModel($body, $id){

      $data = $this->find($id);
      $dataUpdated = $data->update($body);
      return $this->langue_pays($body, $data);

      return $dataUpdated;
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

    public function langue_pays($body, $data){

      $principal = false;
      if(isset($body['principal']) && !empty($body['principal'])){
        $principal = $body['principal'];
      }
      if (isset($body['pays_id']) && !empty($body['pays_id'])){
        $data->pays()->attach([$body['pays_id'] => ['principal' => $principal]]);
      }
    }
}