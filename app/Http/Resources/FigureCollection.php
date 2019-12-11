<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FigureCollection extends ResourceCollection
{

    public $collects = "App\Http\Resources\FigureResource";
    //private $pagination;

    /*public function __construct($resource) {
        $this->pagination = [
            'total' => $resource->total(),
        ];
        $resource = $resource->getCollection();
        parent::__construct($resource);
    }*/

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $nextPage = $this->currentPage() < $this->lastPage() ? $this->currentPage() + 1 : $this->lastPage();
        $nextPageURL = $this->path()."?page=".$nextPage."&limit=".$this->perPage().(request()->has('difficulty') ? "&difficulty=".request('difficulty'):'');
        return [
            //'pagination' => $this->pagination,
            'pagination' => [
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'next_page_url' => $nextPageURL
            ],
            'data' => $this->collection,
        ];
    }
}
