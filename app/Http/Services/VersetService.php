<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\CantiqueResource as DataResource;
use App\Models\Verset as DataModel;
use App\Models\Predication;
use App\Models\Concordance;

class VersetService{

    public function findDataModel($id)
    {
      $data = $this->find($id);
      $data->predication = $data->predication;
      $data->concordances = $data->concordances;
      return new DataResource($data);
    }
  
    public function filterDataModel(Request $request){
      
      $data;
      if($request->mobile && $request->predication){
        $data = DataModel::orderBy('id', "ASC")->where('predication_id', $request->predication)->get();
        return DataResource::collection($data);
      }

      if($request->langue){
        $predication = Predication::where('langue_id', $request->langue)->first();
        if(!$predication || empty($predication)){
          return DataResource::collection([]); 
        }else{
          $data = DataModel::orderBy('id', "ASC")
          ->where('predication_id', $predication->id)->get();
        }
      }if($request->predication){
        $data = DataModel::orderBy('id', "ASC")
          ->where('predication_id', $request->predication)->get();
      }
      if ($request->per_page){
        $data =  $versets->paginate((int)$request->per_page);
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

    public function addConcordance($body){

      $data = Concordance::create($body);
      return new DataResource($data);
    }

    public function removeConcordance($id){

      $data = Concordance::find($id);
      if (!$data) modelNotFound();
      return $data->delete();
    }

}
