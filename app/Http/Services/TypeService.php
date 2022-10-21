<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\TypeResource as DataResource;
use App\Models\Type as DataModel;

class TypeService{

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