<?php

namespace Milwad\LaravelCrod\Datas;

class QueryModuleData
{
    public static function getControllerIdData(string $comment, string $request, string $id)
    {
        return "    public function index()
    {
        $comment
    }

    public function create()
    {
        $comment
    }

    public function store(Request $request)
    {
        $comment
    }

    public function edit($id)
    {
        $comment
    }

    public function update(Request $request, $id)
    {
        $comment
    }

    public function destroy($id)
    {
        $comment
    }";
    }

    public static function getControllerRouteModelBinding(string $comment, string $request, string $name, string $lowerName)
    {
        return "    public function index()
    {
        $comment
    }

    public function create()
    {
        $comment
    }

    public function store(Request $request)
    {
        $comment
    }

    public function edit($name $$lowerName)
    {
        $comment
    }

    public function update(Request $request, $name $$lowerName)
    {
        $comment
    }

    public function destroy($name $$lowerName)
    {
        $comment
    }";
    }
}