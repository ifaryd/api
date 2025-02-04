<?php
namespace App\Http\Controllers\Apis;
use Illuminate\Support\Facades\File;
use App\Models\Langue;
use Illuminate\Support\Facades\DB;
ini_set('memory_limit', '-1');
class WriteToJsonController
{

    function writeToJson($lang){

        if (!in_array($lang, ['fr', 'en', 'pt', 'es'])) {
            return "invalid request param";
        }

        $this->writeInBaseFile($lang, "users");
        $this->writeInBaseFile($lang, "password_resets");
        $this->writeInBaseFile($lang, "failed_jobs");
        $this->writeInBaseFile($lang, "personal_access_tokens");

        $this->writeInBaseFile($lang, "types");
        $this->writeInBaseFile($lang, "langues");
        $this->writeInBaseFile($lang, "pays");
        $this->writeInBaseFile($lang, "langue_pays");
        
        $this->writeInBaseFile($lang, "villes");
        $this->writeInBaseFile($lang, "assemblees");
        $this->writeInBaseFile($lang, "charges");
        $this->writeInBaseFile($lang, "charge_users");

        $this->writeInBaseFile($lang, "videos");
        $this->writeInBaseFile($lang, "photos");
        $this->writeInBaseFile($lang, "temoignages");
        $this->writeInBaseFile($lang, "actualites");
        $this->writeInBaseFile($lang, "cantiques");
        $this->writeInBaseFile($lang, "concordances");
        $this->writeInBaseFile($lang, "confirmes");

        $this->writeInFile($lang, "predications");

        return true;
    }

    private function writeInFile($lang, $tableName){
        $versetTable = "versets";
        $langue = Langue::where('initial', $lang.'-'.$lang)->firstOrFail();

        $data = DB::table($tableName)->where('langue_id', $langue->id)->get();

        $dataJson = json_encode($data, JSON_PRETTY_PRINT);

        $filePath = env('ASSET_DIR')."jsons/$lang/$tableName.json";

        File::put($filePath, $dataJson);

        if($tableName === "predications"){
            $ids = DB::table($tableName)->where('langue_id', $langue->id)->pluck('id');
            $versets = DB::table($versetTable)->whereIn('predication_id', $ids)->get();
            $dataJson = json_encode($versets, JSON_PRETTY_PRINT);

            $filePath = env('ASSET_DIR')."jsons/$lang/$versetTable.json";

            File::put($filePath, $dataJson);
        }

        unset($data);
        unset($dataJson);
        unset($filePath);
        unset($versets);
        unset($ids);
    }

    private function writeInBaseFile($lang, $tableName){
        $data = DB::table($tableName)->get();
        $dataJson = json_encode($data, JSON_PRETTY_PRINT);

        $filePath = env('ASSET_DIR')."jsons/$lang/$tableName.json";

        File::put($filePath, $dataJson);

        unset($data);
        unset($dataJson);
        unset($filePath);
    }
}
