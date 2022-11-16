<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Resources\ConfirmeResource as DataResource;
use App\Models\Confirme as DataModel;
use App\Models\Pays;
class ConfirmeService{

    public function findDataModel($id)
    {
      $data = $this->find($id);
      $data->user = $data->user;
      $data->pays = $data->pays;
      $data->video = $data->video;
      return new DataResource($data); 
    }
  
    public function filterDataModel(Request $request){

      $data;
      if($request->mobile){
        $data = DataModel::all();
        return DataResource::collection($data);
      }
      if ($request->per_page){
        $data = DataModel::orderBy('id', 'desc')->with(["user", "video", "pays", "langue"])->paginate((int)$request->per_page);
      }
      if ($request->has("per_country")){
        $data = Pays::whereHas('confirmes', function ($query){
                })->with("confirmes", function ($query){
                  $query->with(["user", "video","langue"]);
                })->get();
      }
      if ($request->has("per_country") && $request->langue){
        $langue_id = $request->langue;
        $data = Pays::whereHas('confirmes', function ($query){
                })->with("confirmes", function ($query) use($langue_id){
                  $query->with(["user", "video","langue"])->where("langue_id", $langue_id);
                })
                ->get();
      }
      else{
        $data = DataModel::with(["user", "video", "pays", "langue"])->lazyById(100);
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