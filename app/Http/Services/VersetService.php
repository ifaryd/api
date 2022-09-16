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
      $predications = Predication::orderBy('id', "ASC")->whereHas('langue', function ($query){
      });

      if($request->langue){
        $predications->where('langue_id', $request->langue)->with('versets');
      }if($request->predication){
        $predications->where('id', $request->predication)->with('versets');
      }
      if ($request->per_page){
        $data =  $predications->paginate((int)$request->per_page);
      }
      else{
        $data = $predications->with('versets')->limit(2)->get();
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
