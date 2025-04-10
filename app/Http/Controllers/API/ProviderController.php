<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\ProviderRepoistory\ProviderRepository;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    protected $provider_Repository;
    public function __construct(ProviderRepository $provider_Repository)
    {
         return $this->provider_Repository = $provider_Repository;
    }

    public function index()
    {
        $providers = $this->provider_Repository->getAllProviders();
        return response()->json([
            'status' => true,
            'Providers '=>$providers
        ]
            , 200);
    }
    public function show($id)
    {
        $provider = $this->provider_Repository->getProviderById($id);
        if ($provider) {
            return response()->json([
                'status' => true,
                'Provider' => $provider
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Provider not found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
       $data= $request->validate([
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|min:5|max:255|unique:providers',
            'specialization' => 'required|string|min:5|max:255',
        ]);
        $provider = $this->provider_Repository->createProvider($data);
        return response()->json([
            'status' => true,
            'Provider' => $provider
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $data= $request->validate([
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|min:5|max:255|unique:providers,email,'.$id,
            'specialization' => 'required|string|min:5|max:255',
        ]);
        $provider = $this->provider_Repository->updateProvider($id, $data);
        if ($provider) {
            return response()->json([
                'status' => true,
                'Provider' => $provider
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Provider not found'
            ], 404);
        }
    }

    public function delete(Request $request, $id)
    {
        $deleted = $this->provider_Repository->deleteProvider($id);
        if ($deleted) {
            return response()->json([
                'status' => true,
                'message' => 'Provider deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Provider not found'
            ], 404);
        }
    }

}
