<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\CantiqueResource as DataResource;
use App\Models\Cantique as DataModel;
use App\Models\User;

class CantiqueService{

    public function findDataModel($id)
    {
      $data = $this->find($id);
      $data->verset_from = $data->verset_from;
      $data->verset_to = $data->verset_to;
      return new DataResource($data);
    }
  
    public function filterDataModel(Request $request){
      
      return [];
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
