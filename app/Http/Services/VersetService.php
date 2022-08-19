<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\CantiqueResource as DataResource;
use App\Models\Cantique as DataModel;
use App\Models\Predication;

class CantiqueService{

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
      }if($request->predication_id){
        $predications->where('id', $request->predication_id)->with('versets');
      }
      if ($request->per_page){
        $data =  $predications->paginate((int)$request->per_page);
      }
      else{
        $data = $predications->get();
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
