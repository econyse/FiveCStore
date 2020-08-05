<?php
namespace App\Services\Contracts;

Interface NosqlServiceInterface {
    public function create($collection, Array $document);
    public function update($collection, $id, Array $document);
    public function delete($collection, $id);
    public function find($collection, Array $criteria);
}