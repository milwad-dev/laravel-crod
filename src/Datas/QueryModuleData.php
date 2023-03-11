<?php

namespace Milwad\LaravelCrod\Datas;

/*
 * This file is for add data in crud files.
 *
 * ======================== WARNING ======================== => DO NOT MAKE ANY CHANGES TO THIS FILE
 */

class QueryModuleData
{
    /**
     * Add Controller-ID data.
     *
     * @param string $comment
     * @param string $request
     * @param string $id
     *
     * @return string
     */
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

    /**
     * Add controller route-model-binding data,.
     *
     * @param string $comment
     * @param string $request
     * @param string $name
     * @param string $lowerName
     *
     * @return string
     */
    public static function getControllerRouteModelBindingData(string $comment, string $request, string $name, string $lowerName)
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
