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
    // $predications = Predication::all();

    // foreach ($predications as $predication){
    //     Predication::where('id',$predication->id)
    //     ->update(['lien_audio_cloud' =>explode("-", $predication->lien_audio)[0]]);
    // }

    //return $this->mergeLanguageCommon();
    //return $this->mergeLanguageData("Français", "fr-fr", "France", "fr", true);
    //return $this->mergeLanguageData("Anglais", "en-en", "Angletèrre", "en", true);
    //return $this->mergeLanguageData("Espagnol", "es-es", "Espagne", "es", true);
    //return $this->mergeLanguageData("Portugais", "pt-pt", "Portugal", "pt", true);
}

private function mergeLanguageData($langue, $initial_langue, $pays, $sigle_pays, $langue_principal_du_pays){

    $predications = $this->mergePredication($langue, $initial_langue, $pays, $sigle_pays, $langue_principal_du_pays);
    $temoignages =  $this->mergeTemoignages($initial_langue);
    $photos = $this->mergePhotos($initial_langue);
    $videos = $this->mergeVideos($initial_langue);
    $confirmes = $this->mergeConfirmes($initial_langue);
    return $confirmes;
}

private function mergeLanguageCommon(){
    $pays = $this->mergePays();
    $villes = $this->mergeVilles();
    $chantres = $this->mergeCharges('Chantre');
    $ministres = $this->mergeCharges('Ministre');
    $assemblees = $this->mergeAssemblees();
    $cantiques = $this->mergeCantiques();
    return $cantiques;
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
    $country_id; 

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

private function mergeAssemblees(){

    $dataModel = new Assemblee;
    $paysModel = new Pays;
    $assemblees = $dataModel::on('sqlite')->withTrashed()->get();

    if(!isset($assemblees) || empty($assemblees)){
        return false;
    }

    foreach ($assemblees as $key => $assemblee){
        $dirigeantLite = Dirigeant::on('sqlite')->where('numero', $assemblee->num_dirigeant)->first();
        $villeLite = Ville::on('sqlite')->where('numero', $assemblee->num_ville)->withTrashed()->first();
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

        $dirigeant = Charge::firstOrCreate(
            ['libelle' =>  "Dirigeant"],
            ['libelle' =>  "Dirigeant"]
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
    $predications = $dataModel::on('sqlite')->withTrashed()->limit(152)->get();

    if(!isset($predications) || empty($predications)){
        return false;
    }

    foreach ($predications as $key => $predicationF){
        if(isset($predicationF->duree) && !empty($predicationF->duree)){
        $duree = str_replace("mn ", ",", $predicationF->duree);
        $duree = str_replace("s", ",", $duree);
        $duree = str_replace("h ", ",", $duree);

        $duree = explode(",", $duree);
        
        if(isset($duree) && isset($duree[2]) && (int)$duree[2] > 1){
            $duree = ((int)$duree[0] * 3600) + ((int)$duree[1] * 60) + (int)$duree[2];
        }
        if(isset($duree) && isset($duree[2]) &&  (int)$duree[2] == 0){
            $duree = (int)$duree[0] * 60 + (int)$duree[1];
        }
        }else{
            $duree = 0; 
        }

        $predicationData =  [
            'sous_titre' => $predicationF->sous_titre,
            'numero' => $predicationF->numero, 
            'lien_audio'=>$predicationF->lien_audio,
            'lien_audio_cloud' => explode("-", $predicationF->lien_audio)[0],
            "nom_audio"=>$predicationF->nom_audio,
            "lien_video"=>$predicationF->lien_video,
            "duree"=> $duree,
            "chapitre"=>$predicationF->chapitre,
            "couverture"=>"",
            "sermon_similaire"=>$predicationF->similar_sermon,
        ];
        if(isset($langue->id)){
            $predicationData["langue_id"] =  $langue->id;
        }
        $predication = Predication::updateOrCreate(
            ['titre' =>  $predicationF->titre],
            $predicationData
        );
        $versets = Verset::on('sqlite')->where("num_pred", $predication->numero)->withTrashed()->get();

        if(isset($versets) && !empty($versets) && !empty($predication->id)){

            foreach ($versets as $verset){

                if(isset($verset) && !empty($verset->numero) && !empty($verset->contenu)){
                    
                    $verset = Verset::updateOrCreate(
                        [
                            'contenu' =>  $verset->contenu,
                            'predication_id' =>  $predication->id
                        ],
                        [
                        'info' => $verset->info,
                        'numero' => $verset->numero,
                        ]
                    );
        
                    $concordances = Concordance::on('sqlite')
                        ->where("num_pred", $predication->numero)
                        ->where("num_verset", $verset->numero)
                        ->withTrashed()->get();
        
                    if(!isset($concordances) || empty($concordances)){
                    foreach($concordances as $concordance){
        
                        $concordance_verset = str_replace("[Kc.", "", $concordance->concordance);
                        $concordance_verset = str_replace("] [Kc.", "", $concordance_verset);
                        $concordance_verset = str_replace("]", "", $concordance_verset);
        
                        $concordance_verset = explode(" ", $concordance_verset);
                        foreach($concordance_verset as $verset_to){
                            $predication_num = explode("v", $verset_to)[0];

                            $predication_new = Predication::where("numero", (int)$predication_num)
                                            ->where("langue_id", $langue->id)
                                            ->first();
        
                            if(isset($predication_new) && isset($predication_new->id)){
                                $verset_to = Verset::where("predication_id", $predication_new->id)
                                                    ->withTrashed()->first();
                                if(isset($verset_to)){
                                    Concordance::updateOrCreate(
                                        ['verset_from_id' => $verset->id, 'verset_to_id' =>  $verset_to->id]
                                    );
                                }
                            }
                        }
                        
                    }
                    }
                }
    
            }
        }
           
    }

    return [Predication::count(), Verset::count(), Concordance::count()];
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
    $video;

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
