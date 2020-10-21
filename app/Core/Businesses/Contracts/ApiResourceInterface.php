<?php

namespace App\Core\Businesses\Contracts;

interface ApiResourceInterface
{
    public function index();

    public function store($data);

    public function show($id);

    public function update($id, $data);

    public function destroy($id);
}
