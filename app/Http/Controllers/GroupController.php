<?php
namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    
    /**
     * Store a newly created group in storage.
     *
     * @param  \Illuminate\Http\Request  $requests
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $group = Group::create($reques->data['attributes']);
        return response()->json(new ProductResource($product) ,201);
    }

    /**
     * Display the specified group.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $groupResource= new groupResource($group);
         return response()->json($groupResource,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function showMembers(Group $group)
    {
        $dataMembers = [
            'attributes' =>[
                'members' => $this->members
            ]
        ];
        return response()->json($dataMembers,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }
    /**
     * Add member to a group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function addMembers(Request $request, User $user)
    {
        //
    }

    /**
     * Add model to a group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function addFigures(Request $request, Figure $figure)
    {
        //
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
}
