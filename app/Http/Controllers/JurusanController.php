<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JurusanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Jurusan',
        ];
        return view('admin.jurusan.index', $data);
    }
    public function getJurusanDataTable()
    {
        $jurusan = Jurusan::with(['fakultas'])->orderByDesc('id');


        return DataTables::of($jurusan)

            ->addColumn('action', function ($jurusan) {
                return view('admin.jurusan.components.actions', compact('jurusan'));
            })

            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {

        $request->validate([
            'id_fakultas' => ['required'],
            'jurusan' => ['required', 'string', 'max:255'],
        ]);


        if ($request->filled('id')) {
            $usersData = [
                'id_fakultas' => $request->input('id_fakultas'),
                'jurusan' => $request->input('jurusan'),

            ];
            $user = Jurusan::find($request->input('id'));
            if (!$user) {
                return response()->json(['message' => 'jurusan not found'], 404);
            }

            $user->update($usersData);
            $message = 'jurusan updated successfully';
        } else {
            $usersData = [
                'id_fakultas' => $request->input('id_fakultas'),
                'jurusan' => $request->input('jurusan'),

            ];

            Jurusan::create($usersData);
            $message = 'jurusan created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function edit($id)
    {
        $User = Jurusan::find($id);

        if (!$User) {
            return response()->json(['message' => 'jurusan not found'], 404);
        }

        return response()->json($User);
    }
    public function destroy($id)
    {
        $user = Jurusan::find($id);

        if (!$user) {
            return response()->json(['message' => 'jurusan not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'jurusan deleted successfully']);
    }
}