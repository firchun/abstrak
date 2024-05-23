<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FakultasController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Fakultas',
        ];
        return view('admin.fakultas.index', $data);
    }
    public function getFakultasDataTable()
    {
        $fakultas = Fakultas::orderByDesc('id');


        return DataTables::of($fakultas)

            ->addColumn('action', function ($fakultas) {
                return view('admin.fakultas.components.actions', compact('fakultas'));
            })

            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {

        $request->validate([
            'fakultas' => ['required', 'string', 'max:255'],
        ]);


        if ($request->filled('id')) {
            $usersData = [
                'fakultas' => $request->input('fakultas'),

            ];
            $user = Fakultas::find($request->input('id'));
            if (!$user) {
                return response()->json(['message' => 'fakultas not found'], 404);
            }

            $user->update($usersData);
            $message = 'fakultas updated successfully';
        } else {
            $usersData = [
                'fakultas' => $request->input('fakultas'),

            ];

            Fakultas::create($usersData);
            $message = 'fakultas created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function edit($id)
    {
        $User = Fakultas::find($id);

        if (!$User) {
            return response()->json(['message' => 'fakultas not found'], 404);
        }

        return response()->json($User);
    }
    public function destroy($id)
    {
        $user = Fakultas::find($id);

        if (!$user) {
            return response()->json(['message' => 'fakultas not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
