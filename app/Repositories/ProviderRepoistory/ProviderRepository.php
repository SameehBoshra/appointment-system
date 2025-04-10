<?php
namespace App\Repositories\ProviderRepoistory;

use App\Models\Provider;
class ProviderRepository implements InterFaces\IProviderRepository
{
    public function getAllProviders()
    {
        return Provider::all();
    }
    public function getProviderById($id)
    {
        return Provider::find($id);
    }
    public function createProvider( array $data)
    {
        return Provider::create($data);
    }
    public function updateProvider($id, array $data)
    {
        $provider = Provider::find($id);
        if ($provider) {
            $provider->update($data);
            return $provider;
        }
        return null;
    }
    public function deleteProvider($id)
    {
        $provider = Provider::find($id);
        if ($provider) {
            $provider->delete();
            return true;
        }
        return false;
    }
}