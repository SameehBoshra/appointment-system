<?php
namespace App\Repositories\ProviderRepoistory\InterFaces;

interface IProviderRepository
{
    public function getAllProviders();
    public function getProviderById($id);
    public function createProvider(array $data);
    public function updateProvider($id, array $data);
    public function deleteProvider($id);
}
