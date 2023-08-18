<?php

use App\Controllers\Api\ApiController;
use App\Models\Formation;
use App\Libraries\Response;

class courseController extends ApiController
{
    private $formationModel;

    public function __construct()
    {
        $this->formationModel = new Formation;
        parent::__construct();
    }

	public function index($request)
    {
        $filters = [
            'fore.nom' => htmlspecialchars(strip_tags($request->get('q'))),
            'c.nom' => htmlspecialchars(strip_tags($request->get('categorie'))),
            'l.nom' => htmlspecialchars(strip_tags($request->get('langue'))),
            'n.nom' => htmlspecialchars(strip_tags($request->get('niveau'))),
        ];

        $filters = array_filter($filters);

        $filterQuery = '';
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
        
        $data = [
            'totalCourses' => (int) $totalFiltred,
            'totalPages' => $totalPages == 0 ? 1 : $totalPages,
            'currentPage' => (int) $page,
            'nextPage' => $page < $totalPages ? $page + 1 : $totalPages,
            'courses' => $formations,
        ];

        return Response::json($data);
    }
}