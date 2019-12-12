<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Request\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Exceptions\ErrorHandler;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }


    /**
     * Store a newly created group in storage.
     *
     * @param  \Illuminate\Http\Request  $requests
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $group_data['name'] = $request ->data['attributes']['name'];
        $group_data['description'] = $request ->data['attributes']['description'];       
        $group = Group::create($group_data);
        $usersRequest= $request->data['attributes']['members'];
        array_push($usersRequest, Auth::id());
        $usersId= array_unique($usersRequest);
        $figuresId= array_unique($request->data['attributes']['figures']);
        $this -> addUsers($group, $usersId);
        $this -> addFigures($group,$figuresId);        
        return response()->json(new groupResource($group) ,201);
    }

    /**
     * Display the specified group.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   
        //AUTH: El user pertenece al grupo y por tanto, puede ver 
        $group = Group::find($request->id);
        if($group){

            $groupResource= new groupResource($group);
         return response()->json($groupResource,201);
        } else {
            (new ErrorHandler())->notFound('There is not a group with the id: ' . $id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response with members id or empty array []
     */
    public function showMembers(Request $request)
    {
        //AUTH: El user pertenece al grupo y por tanto, puede ver 
        $group = Group::find($request->id);
        if ($group) {
            $users = $group -> users() -> pluck('id');
                    $dataMembers = [
                        'attributes' =>[
                            'members' => $users,
                        ]
                    ];
                    return response()->json($dataMembers,200);
        } else {
            (new ErrorHandler())->notFound('There is not a group with the id: ' . $id);   
        }
        
    }

    /**
     * Update the group in storage,only name and description.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //AUTH: El user pertenece al grupo y por tanto, puede editarlo
        //Solo: cambiar nombre y descripción
        $group = Group::find($id);
        if ($group) {            
            $group['name'] = $request ->data['attributes']['name'];
            $group['description'] = $request ->data['attributes']['description'];       
            $group-> save();
            return response()->json(new groupResource($group) ,201);

        } else {
            (new ErrorHandler())->notFound('There is not a group with the id: ' . $id);   
        }
    }

    /**
     * Add member to a group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateMembers(Request $request, $id)
    {
        //AUTH: Solo la persona que creó el grupo puede hacer esto 
        //Verificar que el id de las personas no estén repetidos y si están, no hacer nada, o marcar error? si se marca
        //error, va en el GroupRequest, sino, aqui 
        #SE implementa el "Aqui va "
        //Revisar.
        $group = Group::find($id);
        if ($group) {      
            $usersRequest= $request->data['attributes']['members']; 
            $usersInGroup = $group -> users() -> pluck('id')->toArray();
            $newUsers= array_diff($usersRequest, $usersInGroup);
            $this -> addUsers($group, $newUsers);
            return response()->json(new groupResource($group) ,201);
        } else {
            (new ErrorHandler())->notFound('There is not a group with the id: ' . $id);   
        }
    }

    /**
     * Add model to a group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateFigures(Request $request, $id)
    {
        //AUTH: La persona pertenece al grupo
        //Verificar que el id de la figura no esté repetido, lo mismo de arriba:c.
        $group = Group::find($id);
        if ($group) {

            $figuresRequest= $request->data['attributes']['figures'];
            $figuresInGroup = $group -> figures() -> pluck('id')->toArray();
            $newFigures= array_values(array_diff($figuresRequest, $figuresInGroup));
            $this -> addFigures($group,$newFigures); 
            return response()->json(new groupResource($group) ,201);

        } else {
            (new ErrorHandler())->notFound('There is not a group with the id: ' . $id);   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
    /**
     * Remove the specified user from group.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function removeMember(Group $group, User $user)
    {
        //
    }
    /**
     * Remove the specified figure from group.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function removeFigure(Group $group, Figure $figure)
    {
        //
    }

    private function addUsers($group, $usersId) {
        foreach ($usersId as $id) {
            $group->users()->attach($id);
        }
    }

    private function addFigures($group, $figuresId){
        foreach ($figuresId as $id) {
            $group->figures()->attach($id);
        }
    }

    private function getMembers($group, $figuresId){
        foreach ($figuresId as $id) {
            $group->figures()->attach($id);
        }
    }

}
