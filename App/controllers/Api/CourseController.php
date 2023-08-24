<?php

use App\Controllers\Api\ApiController;
use App\Models\Formation;
use App\Libraries\Response;
use App\Libraries\Validator;

class CourseController extends ApiController
{
    private $formationModel;

    public function __construct()
    {
        $this->formationModel = new Formation;
        parent::__construct();
    }

	public function index($request)
    {
        if($request->get('page_for') !== 'formateur' || !auth()){
            return Response::json($this->publicCourses($request));    
        }

        if(session('user')->get()->type !== 'formateur'){
           return Response::json(null, 403); 
        }

        return Response::json($this->formateurCourses($request));
    }

    private function publicCourses($request)
    {
        $filters = [
            'fore.nom' => htmlspecialchars(strip_tags($request->get('q'))),
            'c.nom' => htmlspecialchars(strip_tags($request->get('categorie'))),
            'l.nom' => htmlspecialchars(strip_tags($request->get('langue'))),
            'n.nom' => htmlspecialchars(strip_tags($request->get('niveau'))),
        ];

        $filters = array_filter($filters);

        $filterQuery = "fore.etat = 'public' ";
        foreach ($filters as $key => $value) {
            $filterQuery .= "AND {$key} LIKE '%{$value}%' ";   
        }

        $duration = htmlspecialchars(strip_tags($request->get('duration')));
        $durations = [
            'extraShort' => "'00' AND '01:00:59'",
            'short' => "'01:00:00' AND '03:00:59'", 
            'medium' => "'03:00:00' AND '06:00:59'",
            'long' => "'06:00:00' AND '17:00:59'",
            'extraLong' => "'17:00:00' AND '800:00'"
        ];

        if(array_key_exists($duration, $durations)){
            $filterQuery .= 'AND mass_horaire BETWEEN ' . $durations[$duration];
        }

        $sort = htmlspecialchars(strip_tags($request->get('sort')));
        $sorts = ['newest' => 'fore.date_creation', 'mostLiked' => 'fore.jaimes'];

        if(array_key_exists($sort, $sorts)){
            $sort = ','.$sorts[$sort];
        }

        $page = htmlspecialchars(strip_tags($request->get('page')));
        if(!isset($page) || $page < 1) $page = 1;
        $offset = ($page - 1) * 10;
        $formations = $this->formationModel->filter($filterQuery, $offset, $sort);
        $totalFiltred = $this->formationModel->countFiltred($filterQuery);
        $totalPages = ceil($totalFiltred / 10);
        
        return [
            'totalCourses' => (int) $totalFiltred,
            'totalPages' => $totalPages == 0 ? 1 : $totalPages,
            'currentPage' => (int) $page,
            'nextPage' => $page < $totalPages ? $page + 1 : $totalPages,
            'courses' => $formations,
        ];
    }

    private function formateurCourses($request)
    {
        $filters = [
            'fore.nom' => htmlspecialchars(strip_tags($request->get('q'))),
            'c.nom' => htmlspecialchars(strip_tags($request->get('categorie'))),
        ];

        $filters = array_filter($filters);

        $filterQuery = 'fore.etat IS NOT NULL ';
        foreach ($filters as $key => $value) {
            $filterQuery .= "AND {$key} LIKE '%{$value}%' ";   
        }

        $sort = htmlspecialchars(strip_tags($request->get('sort')));
        $sorts = ['nom' => 'fore.nom', 'likes' => 'fore.jaimes DESC', 'newest' => 'fore.date_creation DESC'];

        if(array_key_exists($sort, $sorts)){
            $sort = ','.$sorts[$sort];
        }else{
            $sort = '';
        }

        $id_formateur = 'AND f.id_formateur = "'.session('user')->get()->id_formateur.'"';
        $totalFiltred = $this->formationModel->countFiltred($filterQuery, $id_formateur);
        $totalPages = ceil($totalFiltred / 10);

        $page = htmlspecialchars(strip_tags($request->get('page')));
        if(!isset($page) || $page < 1 || $page > $totalPages) $page = 1;

        $offset = ($page - 1) * 10;
        $formations = $this->formationModel->filter($filterQuery, $offset, $sort, $id_formateur);

        return [
            'totalCourses' => (int) $totalFiltred,
            'totalPages' => $totalPages == 0 ? 1 : $totalPages,
            'currentPage' => (int) $page,
            'nextPage' => $page + 1 > $totalPages ? null : $page + 1,
            'prevPage' => $page - 1 === 0 ? null : $page - 1,
            'courses' => $formations,
        ];
    }

    public function update($request, $id_formation)
    {
        if(!auth()){
            return Response::json(null, 401);
        }

        if(session('user')->get()->type !== 'formateur'){
           return Response::json(null, 403); 
        }

        $validator = new Validator([
            'id_formation' => strip_tags(trim($id_formation)),
            'nom' => strip_tags(trim($request->post('nom'))),
            'description' => $this->strip_critical_tags($request->post("description")),
            'prix' => strip_tags(trim($request->post('prix'))),
            'etat' => strip_tags(trim($request->post('etat'))),
            'id_categorie' => strip_tags(trim($request->post('id_categorie'))),
            'id_niveau' => strip_tags(trim($request->post('id_niveau'))),
            'id_langue' => strip_tags(trim($request->post('id_langue'))),
        ]);

        $validator->validate([
            'id_formation' => 'required|exists:formations|check:formations',
            'nom' => 'required|min:3|max:80',
            'description' => 'required|min:15|max:700',
            'prix' => 'required|numeric|numeric_min:10|numeric_max:1000',
            'etat' => 'required|in_array:public,private',
            'id_categorie' => 'required|exists:categories',
            'id_niveau' => 'required|exists:niveaux',
            'id_langue' => 'required|exists:langues',
        ]);

        $formation = $validator->validated();
        unset($formation['type']);
        $formation['is_published'] = $request->post('is_published') ? date('Y-m-d H:i:s') : null;

        $video = [];

        // updating preview video is optional, but...
        if(isset($_FILES['preview'])){
            if($_FILES['preview']['error'] === 0){
                $validator = new Validator([
                    'preview' => $_FILES['preview']
                ]);

                $validator->validate([
                    'preview' => 'size:1024|video|video_duration:50',
                ]);

                $video['url'] = uploader($_FILES['preview'], "videos/formations");
                $video['thumbnail'] = $this->getThumbnail('videos/'.$video['url']);

                $id_video = $this->previewModel->getPreviewOfFormation($id_formation)->id_video;
                $oldVideo = $this->videoModel->find($id_video);
                // Remove old files (video and thumbnail)
                unlink('videos/'.$oldVideo->url);
                unlink('images/'.$oldVideo->thumbnail);
                unset($oldVideo);
                $this->videoModel->update($video, $id_video);
            }
        }

        // updating formation's image is optional, but...
        if(isset($_FILES['image'])){
            if($_FILES['image']['error'] === 0){
                $validator = new Validator([
                    'image' => $_FILES['image']
                ]);

                $validator->validate([
                    'image' => 'required|size:5|image',
                ]);

                unlink('images/'.$this->formationModel->find($id_formation)->imgFormation);
                $formation['image'] = uploader($_FILES['image'], 'images/formations');
            }
        }

        // update formation
        if($this->formationModel->update($formation, $id_formation)){
            return Response::json(null, 200, 'Updated successfuly.');
        }
        return Response::json(null, 500, "Coudn't update the course, please try again later."); 
    }

    public function delete($id_formation)
    {
        if(!auth()){
            return Response::json(null, 401);
        }

        if(session('user')->get()->type !== 'formateur'){
           return Response::json(null, 403); 
        }

        $validator = new Validator([
            'id_formation' => strip_tags(trim($id_formation)),
        ]);

        $validator->validate([
            'id_formation' => 'required|exists:formations|check:formations',
        ]);

        if($this->formationModel->delete($id_formation)){
            return Response::json(null, 200, 'Deleted successfuly.');
        }
        return Response::json(null, 500, "Coudn't delete the course, please try again later."); 
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
}