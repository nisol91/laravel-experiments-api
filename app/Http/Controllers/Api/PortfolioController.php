<?php

namespace App\Http\Controllers\Api;

use App\PortfolioProject;
use App\Http\Controllers\Controller;


class PortfolioController extends Controller
{
    public function getProjects()
    {
        $projects = PortfolioProject::with('media')->get();

        return response()->json([
            "projects" => $projects,
        ]);
    }
    public function getProject($id)
    {
        // dd($id);
        $project = PortfolioProject::where('id', $id)->with('media')->first();
        // $project = PortfolioProject::findOrFail($id)->with('media')->get();


        return response()->json([
            "project" => $project,
        ]);
    }
}
