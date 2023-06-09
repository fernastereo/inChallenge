<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Group::all();

        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255|unique:groups',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $group = Group::create([
            'name'   => strtoupper($request->name),
            'active' => $request->active,
        ]);

        return response()->json([
            'data' => $group,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        if ($group->users()->count() > 0) {
            return response()->json([
                'message' => 'This group still has members',
            ], 200);
        }

        $group->delete();

        return response()->json([
            'message'   => 'Group removed',
            'group'     => $group,
        ], 200);
    }
}
