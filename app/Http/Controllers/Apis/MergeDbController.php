<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use App\Models\Langue;
use App\Models\Ville;
use App\Models\Assemblee;
use App\Models\User;
use App\Models\Charge;
use App\Models\Chantre;
use App\Models\Ministre;
use App\Models\Dirigeant;
use App\Models\Cantique;
use App\Models\Predication;
use App\Models\Verset;
use App\Models\Concordance;
use App\Models\Temoignage;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Type;
use App\Models\Confirme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MergeDbController extends Controller
{

    
/**
 * merge existing data from sqlite db into mysqldb.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function merges()
{

    #$this->mergeCantiquesJSONFile();
    #$this->mergeChantreChargesJson();

    #return $this->mergeLanguageCommon();
    #return $this->mergeLanguageData("Français", "fr-fr", "France", "fr", true);
    #return $this->mergeLanguageData("Anglais", "en-en", "Angletèrre", "gb", true);
    #return $this->mergeLanguageData("Espagnol", "es-es", "Espagne", "es", true);
    return $this->mergeLanguageData("Portugais", "pt-pt", "Portugal", "pt", true);

    #return $this->mergeConcordances("fr-fr");
    #return $this->mergeConcordances("en-en");
    #return $this->mergeConcordances("es-es");
    #return $this->mergeConcordances("pt-pt");
}

private function mergeCantiquesJSONFile(){

    $dataModel = new Cantique;
    //$cantiques = $dataModel::on('sqlite')->withTrashed()->get();
    $cantiques = json_decode(file_get_contents(env('PUBLIC_FILE').'/Audio.json'));

    if(!isset($cantiques) || empty($cantiques)){
        return false;
    }

    foreach ($cantiques as $key => $cantique){
        //$chantre = Chantre::on('sqlite')->where("numero", $cantique->num_chantre)->first();
        $explode_nom = explode(" (", $cantique->artist);
        $first_name = $explode_nom[0];
        $user = User::where("first_name", $first_name)->first();

        if(!isset($user)){

            $user = $this->createChantre($cantique);
        }
        $dataModel::firstOrCreate(
            ['titre' =>  $cantique->title, 'lien_audio' =>  $cantique->audioLink],
            [
            'titre' =>  $cantique->title,
            'lien_audio' =>  $cantique->audioLink,
            "nom_fichier" =>  $cantique->fileName,
            "duree" =>  $cantique->duration,
            "contenu" =>  isset($cantique->words) ? $cantique->words : '',
            "user_id" =>  isset($user->id) ? $user->id : 0
            ]
        ); 
    }

    return $dataModel->all();
    
}

private function mergeLanguageData($langue, $initial_langue, $pays, $sigle_pays, $langue_principal_du_pays){

    $predications = $this->mergePredication($langue, $initial_langue, $pays, $sigle_pays, $langue_principal_du_pays);
    //$temoignages =  $this->mergeTemoignages($initial_langue);
    //$photos = $this->mergePhotos($initial_langue);
    //$videos = $this->mergeVideos($initial_langue);
    $confirmes = $this->mergeConfirmes($initial_langue);
    return $predications;
}

private function mergeLanguageCommon(){
    $pays = $this->mergePays();
    $villes = $this->mergeVilles();
    $ministres = $this->mergeCharges('Ministre');
    $assemblees = $this->mergeAssemblees();
    
    //this option is now an alternative if not it replace
    /*$chantres = $this->mergeCharges('Chantre');
    $cantiques = $this->mergeCantiques();*/

    return $assemblees;
}

private function mergePays(){

    $dataModel = new Pays;
    $dataFromLites = $dataModel::on('sqlite')->withTrashed()->get();

    if(!isset($dataFromLites) || empty($dataFromLites)){
        return false;
    }
    foreach ($dataFromLites as $key => $value){
        $dataModel::firstOrCreate(
            ['nom' =>  $value->nom, 'sigle' =>  $value->sigle],
            ['nom' =>  $value->nom, 'sigle' =>  $value->sigle]
        );
    }

    return $dataModel->all();
    
}

private function mergeVilles(){

    $dataModel = new Ville;
    $dataFromLites = $dataModel::on('sqlite')->withTrashed()->get();
    if(!isset($dataFromLites) || empty($dataFromLites)){
        return false;
    }
    foreach ($dataFromLites as $key => $value){
        $pays = Pays::where("sigle", $value->sigle_pays)->first();
        if($pays && $pays->id){
            $dataModel::firstOrCreate(
                ['libelle' =>  $value->nom, 'pays_id' =>  $pays->id],
                ['libelle' =>  $value->nom, 'pays_id' =>  $pays->id]
            );
        }  
    }

    return $dataModel->all();
    
}

private function mergeCharges($charge_value){

    $dataModel = new Charge;
    $chantreModel = new Chantre;
    $ministreModel = new Ministre;
    $country_name = '';
    $country_id = null; 

    $charge = $dataModel::firstOrCreate(
        ['libelle' =>  $charge_value],
        ['libelle' =>  $charge_value]
    );

    if ($charge_value === "Chantre"){

        $chantres = $chantreModel::on('sqlite')->get();
        if(!isset($chantres) || empty($chantres)){
            return false;
        }
        foreach($chantres as $chantre){
            $explode_nom = explode(" (", $chantre->nom);
            $first_name = $explode_nom[0];
            $user = User::firstOrCreate(
                ['first_name' =>  $first_name],
                ['first_name' =>  $first_name, 'last_name' =>  '']
            );

            if($explode_nom && isset($explode_nom[1])){
                $country_name = explode(")", $explode_nom[1])[0];
                $pays = Pays::where('nom',$country_name)->first();
                $country_id = $pays && $pays->id;
            }
            
            $charge_user = DB::table('charge_users')
                ->where('charge_id', $charge->id)
                ->where('user_id', $user->id)
                ->first();
            
            if(!isset($charge_user)){
                $data = [
                'charge_id' => $charge->id, 
                'user_id' => $user->id,
                "principal" => false
                ];
                if(isset($country_id) && !empty($country_id)){
                    $data["pays_id"] = $country_id;
                }
                DB::table('charge_users')->insert($data);
            }
        }

        
    }

    if($charge_value === "Ministre"){

        $ministres = $ministreModel::on('sqlite')->get();

        if(!isset($ministres) || empty($ministres)){
            return false;
        }

        foreach($ministres as $ministre){
            $user = User::updateOrCreate(
                ['first_name' =>  $ministre->nom],
            
                ['last_name' => '', 
                'telephone'=> $ministre->tel1 .'/'. $ministre->tel2,
                'email'=>$ministre->email,
                "facebook"=>$ministre->page_facebook,
                "youtube"=>$ministre->page_youtube,
                ]
            );

            $apotre = $dataModel::firstOrCreate(
                ['libelle' =>  "Apotre"],
                ['libelle' =>  "Apotre"]
            );

            $pays = Pays::where('sigle',$ministre->sigle_pays)->first();

            $charge_user = DB::table('charge_users')
                ->where('charge_id', $charge->id)
                ->where('user_id', $user->id)
                ->where('pays_id', $pays->id)
                ->first();
            
            if(!isset($charge_user)){
                $data = [
                'charge_id' => $charge->id, 
                'user_id' => $user->id,
                "principal" => false
                ];
                if(isset($pays->id) && !empty($pays->id)){
                    $data["pays_id"] = $pays->id;
                }
                DB::table('charge_users')->insert($data);

                $data = [
                'charge_id' => $apotre->id, 
                'user_id' => $user->id,
                "principal" => false
                ];
                if(isset($pays->id) && !empty($pays->id)){
                    $data["pays_id"] = $pays->id;
                }
                DB::table('charge_users')->insert($data);
            }

        }
        
    }

    return [count(User::all()), Charge::all(), count(DB::table('charge_users')->get())];
    
}

private function createChantre($chantre){

    $name = isset($chantre->name) ? $chantre->name : $chantre->artist ;
    $explode_nom = explode(" (", $name);
    $first_name = $explode_nom[0];
    $chantre_position = isset($chantre->position) ? $chantre->position :  0;

    $user = User::updateOrCreate(
        ['first_name' =>  $first_name],
        ['first_name' =>  $first_name, 'last_name' =>  '']
    );

    $charge = Charge::updateOrCreate(
        ['libelle' =>  "Chantre"],
        ['libelle' =>  "Chantre"]
    );
    
    if($explode_nom && isset($explode_nom[1])){
        $country_name = explode(")", $explode_nom[1])[0];
        $pays = Pays::where('nom',$country_name)->first();
        if($country_name == "RDC"){
            $pays = Pays::where('nom',"RD. Congo")->first();
        }
        $country_id = $pays && $pays->id;
    }

    if(isset($explode_nom)){

        if($explode_nom == "Mexique"){

            $pays = Pays::firstOrCreate(
                ['nom' =>  "México"],
                ['nom' =>  "México", 'sigle' =>  'MX']
            );

            $country_id = $pays && $pays->id;
        }

        if($explode_nom == "Portugais"){

            $pays = Pays::firstOrCreate(
                ['nom' =>  "Portugal"],
                ['nom' =>  "Portugal", 'sigle' =>  'PT']
            );

            $country_id = $pays && $pays->id;
        }

        if($explode_nom == "Zimbabwe"){

            $pays = Pays::firstOrCreate(
                ['nom' =>  "Zimbabwe"],
                ['nom' =>  "Zimbabwe", 'sigle' =>  'ZW']
            );

            $country_id = $pays && $pays->id;
        }

        if($explode_nom == "Chants juifs"){

            $pays = Pays::firstOrCreate(
                ['nom' =>  "Israël"],
                ['nom' =>  "Israël", 'sigle' =>  'IL']
            );

            $country_id = $pays && $pays->id;
        }
        if($explode_nom == "Chants Lingala"){

            $pays = Pays::firstOrCreate(
                ['nom' =>  "RD. Congo"],
                ['nom' =>  "RD. Congo", 'sigle' =>  'IL']
            );

            $country_id = $pays && $pays->id;
        }
    }
        

    $charge_user = DB::table('charge_users')
        ->where('charge_id', $charge->id)
        ->where('user_id', $user->id)
        ->first();

    if(!isset($charge_user)){
        $data = [
        'charge_id' => $charge->id, 
        'user_id' => $user->id,
        'position_chantre' => $chantre_position,
        "principal" => false
        ];
        if(isset($country_id) && !empty($country_id)){
            $data["pays_id"] = $country_id;
        }
        DB::table('charge_users')->insert($data);
    }

    return $user;
}

private function mergeChantreChargesJson(){

    $dataModel = new Charge;
    $chantreModel = new Chantre;
    $ministreModel = new Ministre;
    $country_name = '';
    $country_id = null; 

    $charge = $dataModel::firstOrCreate(
        ['libelle' =>  "Chantre"],
        ['libelle' =>  "Chantre"]
    );
   //"Chants Lingala", "RDC", "Chants juifs", "Zimbabwe", "Portugais", "Mexique"
    $chantres = json_decode(file_get_contents(env('PUBLIC_FILE').'/Folder.json'));
    //dd($chantres);

    if(!isset($chantres) || empty($chantres)){
        return false;
    }
    
    foreach($chantres as $chantre){
        $explode_nom = explode(" (", $chantre->name);
        $first_name = $explode_nom[0];
        $chantre_position = $chantre->position ?? 0;

        $user = User::firstOrCreate(
            ['first_name' =>  $first_name],
            ['first_name' =>  $first_name, 'last_name' =>  '']
        );
        
        if($explode_nom && isset($explode_nom[1])){
            $country_name = explode(")", $explode_nom[1])[0];
            $pays = Pays::where('nom',$country_name)->first();
            if($country_name == "RDC"){
                $pays = Pays::where('nom',"RD. Congo")->first();
            }
            $country_id = $pays && $pays->id;
        }

        if(isset($explode_nom)){

            if($explode_nom == "Mexique"){

                $pays = Pays::firstOrCreate(
                    ['nom' =>  "México"],
                    ['nom' =>  "México", 'sigle' =>  'MX']
                );

                $country_id = $pays && $pays->id;
            }

            if($explode_nom == "Portugais"){

                $pays = Pays::firstOrCreate(
                    ['nom' =>  "Portugal"],
                    ['nom' =>  "Portugal", 'sigle' =>  'PT']
                );

                $country_id = $pays && $pays->id;
            }

            if($explode_nom == "Zimbabwe"){

                $pays = Pays::firstOrCreate(
                    ['nom' =>  "Zimbabwe"],
                    ['nom' =>  "Zimbabwe", 'sigle' =>  'ZW']
                );

                $country_id = $pays && $pays->id;
            }

            if($explode_nom == "Chants juifs"){

                $pays = Pays::firstOrCreate(
                    ['nom' =>  "Israël"],
                    ['nom' =>  "Israël", 'sigle' =>  'IL']
                );

                $country_id = $pays && $pays->id;
            }
            if($explode_nom == "Chants Lingala"){

                $pays = Pays::firstOrCreate(
                    ['nom' =>  "RD. Congo"],
                    ['nom' =>  "RD. Congo", 'sigle' =>  'IL']
                );

                $country_id = $pays && $pays->id;
            }
        }
        

        $charge_user = DB::table('charge_users')
            ->where('charge_id', $charge->id)
            ->where('user_id', $user->id)
            ->first();
        //dd($charge_user);

        if(!isset($charge_user)){
            $data = [
            'charge_id' => $charge->id, 
            'user_id' => $user->id,
            'position_chantre' => $chantre_position,
            "principal" => false
            ];
            if(isset($country_id) && !empty($country_id)){
                $data["pays_id"] = $country_id;
            }
            DB::table('charge_users')->insert($data);
        }
    }

    return [count(User::all()), Charge::all(), count(DB::table('charge_users')->get())];
    
}

private function mergeAssemblees(){

    $dataModel = new Assemblee;
    $paysModel = new Pays;
    $assemblees = $dataModel::on('sqlite')->withTrashed()->get();

    $dirigeant = Charge::firstOrCreate(
        ['libelle' =>  "Dirigeant"],
        ['libelle' =>  "Dirigeant"]
    );

    if(!isset($assemblees) || empty($assemblees)){
        return false;
    }

    foreach ($assemblees as $key => $assemblee){
        $dirigeantLite = Dirigeant::on('sqlite')->where('numero', $assemblee->num_dirigeant)->first();
        $villeLite = Ville::on('sqlite')->where('numero', $assemblee->num_ville)->withTrashed()->first();
        

        if(isset($dirigeantLite) && !empty($dirigeantLite) && isset($villeLite) && !empty($villeLite)){
            $ville = Ville::where("libelle", $villeLite->nom)->first();
            $pays_id = $ville->pays_id;
       
            $user = User::updateOrCreate(
                ['first_name' =>  $dirigeantLite->nom],
                ['last_name' => '', 
                'telephone'=> $dirigeantLite->tel1 .'/'. $dirigeantLite->tel2,
                'email'=>$dirigeantLite->email,
                "facebook"=>$dirigeantLite->page_facebook,
                "youtube"=>$dirigeantLite->page_youtube,
                ]
            );

            if(isset($pays_id) && !empty($pays_id)){
                $assemble = $dataModel::firstOrCreate(
                    ['nom' =>  $assemblee->nom, 'ville_id' =>  $ville->id],
                    [
                    'nom' =>  $assemblee->nom, 
                    'ville_id' =>  $ville->id,
                    'localisation' =>  $assemblee->gps,
                    'addresse' =>  $assemblee->situation,
                    'photo' =>  ""
                    ]
                );

                $charge_user = DB::table('charge_users')
                ->where('charge_id', $dirigeant->id)
                ->where('user_id', $user->id)
                ->where('pays_id', $pays_id)
                ->where('assemblee_id', $assemble->id)
                ->first();

                if(!isset($charge_user)){
                    $data = [
                        'charge_id' => $dirigeant->id,
                        'user_id' => $user->id,
                        "principal" => true,
                        "pays_id" => $pays_id,
                        "assemblee_id" => $assemble->id
                    ];
                    DB::table('charge_users')->insert($data);
                }
            }
        }  
    }

    return [$dataModel->first(), Ville::first()];    
}

private function mergeCantiques(){

    $dataModel = new Cantique;
    $cantiques = $dataModel::on('sqlite')->withTrashed()->get();

    if(!isset($cantiques) || empty($cantiques)){
        return false;
    }

    foreach ($cantiques as $key => $cantique){

        $chantre = Chantre::on('sqlite')->where("numero", $cantique->num_chantre)->first();
        $explode_nom = explode(" (", $chantre->nom);
        $first_name = $explode_nom[0];
        $user = User::where("first_name", $first_name)->first();
        $dataModel::firstOrCreate(
            ['titre' =>  $cantique->titre, 'lien_audio' =>  $cantique->lien_audio],
            [
            'titre' =>  $cantique->titre,
            'lien_audio' =>  $cantique->lien_audio,
            "nom_fichier" =>  $cantique->file_name,
            "duree" =>  $cantique->duration,
            "contenu" =>  $cantique->paroles,
            "user_id" =>  $user->id
            ]
        ); 
    }

    return $dataModel->all();
    
}

private function predicationIntervalle($start, $end) {
    return range($start, $end);
}

private function mergePredication($libelle_langue, $initial_langue, $nom_pays, $sigle_pays, $principal){

    $pays = Pays::firstOrCreate(
        ['sigle' =>  strtoupper($sigle_pays)],
        ['nom' =>  $nom_pays, 'sigle' =>  strtoupper($sigle_pays)]
    );

    $langue = Langue::firstOrCreate(
        ['libelle' =>  $libelle_langue],
        ['libelle' =>  $libelle_langue, 'initial' =>  $initial_langue]
    );

    $pays->langues()->sync([$langue->id => ['principal' => $principal]]);

    $dataModel = new Predication;

    $inRange = $this->predicationIntervalle(162, 162);

    $predications = $dataModel::on('sqlite')->whereIn('numero', $inRange)->withTrashed()->get();

    if(!isset($predications) || empty($predications)){
        return false;
    }

    foreach ($predications as $key => $predicationF){
        //return $predicationF;
        if(isset($predicationF) && isset($predicationF->duree) && !empty($predicationF->duree)){
            $duree = str_replace("mn ", ",", $predicationF->duree);
            $duree = str_replace("s", ",", $duree);
            $duree = str_replace("h ", ",", $duree);

            $duree = explode(",", $duree);
            
            if(isset($duree) && isset($duree[2]) && (int)$duree[2] >= 1){
                $duree = ((int)$duree[0] * 3600) + ((int)$duree[1] * 60) + (int)$duree[2];
            }
            if(isset($duree) && isset($duree[2]) &&  (int)$duree[2] == 0){
                $duree = (int)$duree[0] * 60 + (int)$duree[1];
            }
            }else{
                $duree = 0; 
            }


        // $data =  explode("-", $predicationF->lien_audio)[0];
        // if(isset($data) && !empty($data)){
        //     $data = "https://api.soundcloud.com/tracks/".explode("stream/",trim($data))[1];
        // }

        $data = $predicationF->lien_audio;
        $predicationData =  [
            'numero' => $predicationF->numero,
            "chapitre"=>$predicationF->chapitre,
            'titre' => $predicationF->titre,
            'sous_titre' => $predicationF->sous_titre,
            "date_publication"=>$predicationF->date_publication,
            "nom_audio"=>$predicationF->nom_audio,
            'lien_audio'=>$predicationF->lien_audio,
            'lien_audio_cloud' => $data,
            "lien_video"=>$predicationF->lien_video,
            "duree"=> $duree,
            "couverture"=>"",
            "sermon_similaire"=>$predicationF->similar_sermon,
            "lien_pdf"=>$predicationF->lien_pdf,
            "lien_epub"=>$predicationF->lien_epub,
            "img_pred"=>$predicationF->img_pred,
            "legende"=>$predicationF->legende,
        ];

        
        if(isset($langue->id)){
            $predicationData["langue_id"] =  $langue->id;
        }
         \Log::info($predicationF->chapitre." ".$predicationF->sous_titre);

        $predication = Predication::updateOrCreate(
            ['titre' =>  $predicationF->titre],
            $predicationData
        );

        $versets = Verset::on('sqlite')->where("num_pred", $predication->numero)->withTrashed()->get();

        if(isset($versets) && !empty($versets) && !empty($predication->id)){

            Verset::where("predication_id", $predication->id)->delete();

            foreach ($versets as $verset){

                if(isset($verset) && !empty($verset->numero) && !empty($verset->contenu)){

                    $verset = Verset::updateOrCreate(
                        [
                            'numero' =>  $verset->numero,
                            'predication_id' =>  $predication->id
                        ],
                        [
                        'contenu' =>  $verset->contenu,
                        'info' => $verset->info,
                        'numero' => $verset->numero,
                        'linkAtContent' => $verset->linkAtContent,
                        'urlContent' => $verset->urlContent,
                        ]
                    );
                }
    
            }
        }
           
    }

    return [Predication::count(), Verset::count(), Concordance::count()];
}

private function mergeConcordances($initial) {

    $langue = Langue::where('initial', $initial)->first();

    $concordances = Concordance::on('sqlite2')->withTrashed()->get();

    if(isset($concordances) && count($concordances)){
        foreach($concordances as $concordance){
            $num_pred = $concordance->num_pred;
            $num_verset = $concordance->num_verset;
            $concordance_v = $concordance->concordance;

            $predication = Predication::where("numero", (int)$num_pred)
                                    ->where("langue_id", $langue->id)
                                    ->withTrashed()
                                    ->first();
            $verset = Verset::where("predication_id", $predication->id)
            ->where('numero', $num_verset)
            ->withTrashed()->first();

            preg_match_all('/Kc\.(\d+v\d+)/', $concordance_v, $matches);

            if(isset($matches[1])){
                $concordance_verset = $matches[1];
                foreach($concordance_verset as $verset_to){
                    $predication_num = explode("v", $verset_to)[0];
                    $verset_num = explode("v", $verset_to)[1];
                    
                    $predication_new = Predication::where("numero", (int)$predication_num)
                                    ->where("langue_id", $langue->id)
                                    ->first();
    
                    $verset_new = Verset::where("predication_id", $predication_new->id)
                                    ->where('numero', $verset_num)
                                    ->withTrashed()->first();

                    if(isset($verset_new) && isset($verset_new->id)){
                        
                        if(isset($verset_to) && $verset){
                            \Log::info($predication->chapitre."v$verset->numero concordance verset from : ".$verset->id. " verset to : ".$verset_new->id, $concordance_verset);
                            Concordance::updateOrCreate(
                                ['verset_from_id' => $verset->id, 'verset_to_id' =>  $verset_new->id]
                            );
                        }
                    }
                }
            }
        }
    }
}

private function mergeTemoignages($initial_langue){

    $langue = Langue::where('initial', $initial_langue)->first();
    $temoignages = Temoignage::on('sqlite')->withTrashed()->get();

    if(!isset($temoignages) || empty($temoignages)){
        return false;
    }
    foreach ($temoignages as $temoignage){
        Temoignage::updateOrCreate(
            ['titre' =>  $temoignage->titre],
            [
            'contenu' => $temoignage->texte,
            "langue_id"=>$langue->id,
            'lien_video' => $temoignage->lien_video,
            "photo"=>$temoignage->photo,
            ]
        );
    }

    return Temoignage::count();
}

private function mergePhotos($initial_langue){

    $langue = Langue::where('initial', $initial_langue)->first();
    $photos = Photo::on('sqlite')->withTrashed()->get();

    if(!isset($photos) || empty($photos)){
        return false;
    }
    foreach ($photos as $photo){
        Photo::updateOrCreate(
            ['url' =>  $photo->lien],
            [
            'description' => $photo->description,
            "langue_id"=>$langue->id,
            'lieu' => $photo->lieu,
            ]
        );
    }

    return Photo::count();
}


private function mergeVideos($initial_langue){

    $langue = Langue::where('initial', $initial_langue)->first();
    $videos = Video::on('sqlite')->withTrashed()->get();

    if(!isset($videos) || empty($videos)){
        return false;
    }
    foreach ($videos as $video){
        $type = Type::updateOrCreate(
            ['libelle' =>  $video->type],
            [
            'description' => ""
            ]
        );

        Video::updateOrCreate(
            ['url' =>  $video->lien],
            [
            'description' => $video->description,
            'titre' => $video->titre,
            "langue_id"=>$langue->id,
            'lieu' => $video->lieu,
            'type_id' => $type->id,
            ]
        );
    }

    return Video::all();
}


private function mergeConfirmes($initial_langue){

    $langue = Langue::where('initial', $initial_langue)->first();
    $confirmes = Confirme::on('sqlite')->withTrashed()->get();
    if(!$confirmes){return false;}
    $video = null;

    if(!isset($confirmes) || empty($confirmes)){
        return false;
    }

    foreach ($confirmes as $confirme){
        
        $charge_libelle = trim(explode(" ", $confirme->nom)[0]);
        $first_name = trim(str_replace($charge_libelle, "", $confirme->nom));
        
        if(strtolower($confirme->nom) == "sagnon boga eric" || 
        strtolower($confirme->nom) == "noumsi abel christian" ||
        strtolower($confirme->nom) == "palanga ferramenta"
        ){
        $charge_libelle = "Frère";
        $first_name = $confirme->nom;
        }

        $charge = Charge::updateOrCreate(
            ['libelle' =>  $charge_libelle],
            [
            'description' => ""
            ]
        );

        $userData = ['last_name' => ''];

        if(isset($confirme->page_youtube) && !empty($confirme->page_youtube)){
            $userData["page_youtube"] = $confirme->page_youtube;
        }
        if(isset($confirme->page_facebook) && !empty($confirme->page_facebook)){
            $userData["page_facebook"] = $confirme->page_facebook;
        }
        if(isset($confirme->lien_image) && !empty($confirme->lien_image)){
            $userData["avatar"] = $confirme->lien_image;
        }

        $user = User::updateOrCreate(
            ['first_name' =>  $first_name],
            $userData);

        $pays = Pays::where('sigle', $confirme->sigle_pays)->first();
        
        if(isset($confirme->lien) && !empty($confirme->lien)){
            $type = Type::updateOrCreate(
                ['libelle' =>  "Confirmé"],
                [
                'description' => ""
                ]
            );
    
            $video = Video::updateOrCreate(
                ['url' =>  $confirme->lien],
                [
                'description' => "",
                'titre' => "Confirmation",
                "langue_id"=>$langue->id,
                'lieu' => "",
                'type_id' => $type->id,
                ]
            );
        }

        $dataConfirme = ['langue_id' =>  $langue->id];
        if(isset($video) && !empty($video)){
            $dataConfirme['video_id'] = $video->id;
        }
        Confirme::updateOrCreate(
            ['user_id' =>  $user->id, 'pays_id' =>  $pays->id, 
            'details' =>  $confirme->detail],
            $dataConfirme
            );

    }

    return Confirme::all();
}

}

//  
