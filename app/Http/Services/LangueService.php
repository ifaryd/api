<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\LangueResource as DataResource;
use App\Models\Langue as DataModel;

class LangueService{

    public function findDataModel($id)
    {
      $data = $this->find($id);
      return new DataResource($data);
    }
  
    public function filterDataModel(Request $request){
      
      $data;
      if ($request->per_page){
        $data = DataModel::orderBy('id', 'desc')->paginate((int)$request->per_page);
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
      $this->langue_pays($body, $data);

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
      $data->pays()->sync([$body['pays_id'] => ['principal' => $principal]]);
    }
}