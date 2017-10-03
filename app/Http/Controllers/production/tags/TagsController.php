<?php
/**
 * Created by PhpStorm.
 * User: krzysztofgrys
 * Date: 9/14/17
 * Time: 11:00 PM
 */

namespace App\Tags;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Response\ApiResponse;


class TagsController extends Controller{

    protected $tagsGateway;
    protected $response;

    public function __construct(TagsGateway $tagsGateway)
    {
        $this->tagsGateway = $tagsGateway;
    }

    public function index(){

        $tags = $this->tagsGateway->getTags();

        return ApiResponse::makeResponse($tags);

    }

    public function show(Request $request, $tag){

        return 1;
    }

}