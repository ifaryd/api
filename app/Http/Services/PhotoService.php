<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource as DataResource;
use App\Models\Photo as DataModel;

class PhotoService{

    public function findDataModel($id)
    {
      $data = $this->find($id);
      $data->langue = $data->langue;
      return new DataResource($data);
    }
  
    public function filterDataModel(Request $request){
      
      $data;
      if($request->mobile){
        $data = DataModel::all();
        return DataResource::collection($data);
      }
      if($request->langue){
        $data = Langue::with('photos')->where('initial', $request->langue);
      }
      if(!$request->langue && !$request->per_page){
        $data = DataModel::with('langue')->lazyById(100);
      }
      if(!$request->langue && $request->per_page){
        $data = DataModel::with('langue')->paginate((int)$request->per_page);
      }
      if ($request->langue && $request->per_page){
        $data = $data->paginate((int)$request->per_page);
      }
      if($request->langue && !$request->per_page){
        $data = $data->get();
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