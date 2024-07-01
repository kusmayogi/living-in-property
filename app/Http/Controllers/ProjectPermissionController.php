<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProjectPermission;
use Illuminate\Http\Request;

class ProjectPermissionController extends Controller
{
    public function update(Request $request, $userId, $projectId)
{
    $request->validate([
        'can_attend' => 'required|boolean',
    ]);

    // Cari izin yang sudah ada atau buat baru jika belum ada
    $permission = ProjectPermission::where('user_id', $userId)
        ->where('project_id', $projectId)
        ->firstOrNew();

    // Atur izin
    $permission->user_id = $userId;
    $permission->project_id = $projectId;
    $permission->can_attend = $request->input('can_attend');
    $permission->save();

    return redirect()->back()->with('success', 'Izin berhasil disimpan');
}
}