<?php

use App\Models\Stocked;
use App\Models\Preview;
use App\Models\Formation;
use App\Models\Video;
use App\Models\Inscription;

use App\Libraries\Request;
use App\Libraries\Response;
use App\Libraries\Validator;

class coursesController
{
    private $stockedModel;
    private $previewModel;
    private $formationModel;
    private $videoModel;
    private $inscriptionModel;

    public function __construct()
    {
        $this->stockedModel = new Stocked;
        $this->previewModel = new Preview;
        $this->formationModel = new Formation;
        $this->videoModel = new Video;
        $this->inscriptionModel = new Inscription;
    }

    public function search()
    {
        $data = [
            'niveaux' => $this->formationModel->groupByNiveau(),
            'langues' => $this->formationModel->groupByLangue(),
            'categories' => $this->formationModel->groupByCategorie(),
            'durations' => $this->formationModel->groupByDuration(),
        ];

        return view("courses/index", $data);
    }

    public function index($search = null, $relationship = null)
    {  
        if(!is_null($relationship)){
        	if(!auth()){
        		return view('errors/page_404');
	        }

	        if(session('user')->get()->type !== 'formateur'){
	           return view('errors/page_404');
	        }

            $formationRelationships = ['videos'];
            if(!in_array($relationship, $formationRelationships)){
                return view('errors/page_404');
            }

            $validator = new Validator(['id_formation' => $search]);

	    	$validator->validate([
	            'id_formation' => 'numeric|exists:formations|check:formations',
	        ]);


            $videos = $this->videoModel->getVideosOfFormation($search);
            return view('videos/index', compact('videos'));
        }

        if(!is_null($search)){
        	$formation = $this->formationModel->whereSlug($search);
	        if(!$formation){
	            return redirect('courses/search');
	        }

			$videos = $this->videoModel->getVideosOfFormationPublic($formation->id_formation);
			$formation->inscriptions = $this->inscriptionModel->countApprenantsOfFormation($formation->id_formateur, $formation->id_formation);

			$data = [
				'formation' => $formation,
				'videos' => $videos,
				'totalVideos' => count($videos),
				'previewVideo' => $this->previewModel->getPreviewVideo($formation->id_formation),
			];

			return view("courses/show", $data);
        }

        return view('formateurs/courses/index', ['categories' => $this->stockedModel->getAllCategories()]);
    }

    public function add()
    {
        if(!auth()){
            return Response::json(null, 401);
        }

        if(session('user')->get()->type !== 'formateur'){
           return Response::json(null, 403); 
        }

        $request = new Request;
        if($request->getMethod() !== 'GET'){
            return Response::json(null, 405, "Method Not Allowed");
        }

        $categories = $this->stockedModel->getAllCategories();
        $niveaux = $this->stockedModel->getAllLevels();
        $langues = $this->stockedModel->getAllLangues();

        return view("courses/add", compact('categories', 'niveaux', 'langues'));
    }

    public function edit($id_formation = null)
    {
        if(!auth()){
            return redirect('user/login');
        }

        if(session('user')->get()->type !== 'formateur'){
           return Response::json(null, 403); 
        }

        $request = new Request;
        if($request->getMethod() !== 'GET'){
            return Response::json(null, 405, "Method Not Allowed");
        }

        $validator = new Validator([
            'id_formation' => strip_tags(trim($id_formation)),
        ]);

        $validator->validate([
            'id_formation' => 'required|exists:formations|check:formations',
        ]);

        $formation = $this->formationModel->find($id_formation);
        $categories = $this->stockedModel->getAllCategories();
        $niveaux = $this->stockedModel->getAllLevels();
        $langues = $this->stockedModel->getAllLangues();

        return view('courses/edit', compact('formation', 'categories', 'niveaux', 'langues')); 
    }

    public function removeAttachedFile($id_formation)
    {
        if(!auth()){
            return Response::json(null, 401);
        }

        if(session('user')->get()->type !== 'formateur'){
           return Response::json(null, 403); 
        }

        $request = new Request;
        if($request->getMethod() !== "DELETE"){
            return Response::json(null, 405, "Method Not Allowed");
        }

        $validator = new Validator([
            'id_formation' => strip_tags(trim($id_formation)),
        ]);

        $validator->validate([
            'id_formation' => 'required|exists:formations|check:formations',
        ]);

        $file = $this->formationModel->select($id_formation, ['fichier_attache']);
        if(!$file->fichier_attache){
            return Response::json(null, 400);
        }

        unlink('files/'.$file->fichier_attache);
        if($this->formationModel->setColumnToNull('fichier_attache', 'formations', 'id_formation', $id_formation)){
            return Response::json(null, 200, "Remove successfuly.");
        }
        return Response::json(null, 500, "Something went wrong.");
    }

    private function strip_critical_tags($text)
    {
        $dom = new DOMDocument();
        $dom->loadHTML($text);
        $tags_to_remove = ['script', 'style', 'iframe', 'link', 'video', 'img'];
        foreach($tags_to_remove as $tag){
            $element = $dom->getElementsByTagName($tag);
            foreach($element as $item){
                $item->parentNode->removeChild($item);
            }
        }

        $body = $dom->getElementsByTagName('body')->item(0);
        $cleanedHtml = '';

        if ($body) {
            foreach ($body->childNodes as $childNode) {
                $cleanedHtml .= $dom->saveHTML($childNode);
            }
        }
        return $cleanedHtml; 
    }

    public function sortVideos($id_formation = null)
    {
        $request = new Request;
        if($request->getMethod() !== 'POST'){
            return Response::json(null, 405, "Method Not Allowed");
        }

        $order = $request->post('order');
        $validator = new Validator([
            'order' => $order,
            'id_formation' => strip_tags(trim($id_formation)),
        ]);

        $validator->validate([
            'order' => 'required|array',
            'id_formation' => 'required|exists:formations|check:formations',
        ]);

        $this->validateArray($order);

        $this->videoModel->sortVideos($order, $id_formation);

        return Response::json(null, 200);
    }

    private function validateArray($array) {
        foreach ($array as $video) {
            foreach ($video as $key => $value) {
                if (!is_numeric($value) || $key !== 'id') {
                    return Response::json(null, 400);
                }
            }
        }
    }

    public function setVideoToPreview($id_formation = null)
    {
        $request = new Request;
        if($request->getMethod() !== 'POST'){
            return Response::json(null, 405, "Method Not Allowed");
        }

        $id_video = $request->post('id_video');
        $validator = new Validator([
            'id_formation' => strip_tags(trim($id_formation)),
            'id_video' => strip_tags(trim($id_video))
        ]);

        $validator->validate([
            'id_formation' => 'required|numeric|exists:formations|check:formations',
            'id_video' => 'required|numeric|exists:videos',
        ]);

        // CHECK IF THE VIDEO BELONGS TO GIVING FORMATION ID AND THE AUTH FORMATEUR OWNED IT.
        $validator->checkPermissionsFormateur('formations', 'videos', 'id_formation', ['id_video' => $id_video]);

        if($this->previewModel->update($id_video, $id_formation)){
            return Response::json(null, 200, 'Updated successfuly.');
        }
        return Response::json(null, 500, "Coudn't update the preview, please try again later.");
    }
}
