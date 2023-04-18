<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserGroupController extends Controller
{
    public function assign(User $user, Group $group)
    {
        $hasGroup = $user->groups->contains($group->id);

        if ($hasGroup) {
            return response()->json([
                'message' => 'User is already member of this group',
            ], 200);
        }

        $user->groups()->attach($group->id);

        return response()->json([
            'message' => 'User added to group',
            'user'    => $user,
            'group'   => $group
        ]);
    }

    public function remove(User $user, Group $group)
    {
        $hasGroup = $user->groups->contains($group->id);

        if (!$hasGroup) {
            return response()->json([
                'message' => 'User is not member of this group',
            ], 200);
        }

        $user->groups()->detach($group->id);

        return response()->json([
            'message' => 'User removed from group',
            'user'    => $user,
            'group'   => $group
        ]);
    }
}
