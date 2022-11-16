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
        $data = DataModel::where('predication_id', $request->predication)->get();
        return DataResource::collection($data);
      }
      $versets = DataModel::orderBy('id', "ASC")->with(['predication','concordances']);

      // ->whereHas('predication', function ($query){
          //$query->where('langue_id', $request->langue);
      // })

      if($request->langue){
        $versets->whereHas('predication', function ($query){
          $query->where('langue_id', $request->langue);
        });
      }if($request->predication){
        $versets->where('predication_id', $request->predication);
      }
      if ($request->per_page){
        $data =  $versets->paginate((int)$request->per_page);
      }
      else{
        $data = $versets->get();
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
