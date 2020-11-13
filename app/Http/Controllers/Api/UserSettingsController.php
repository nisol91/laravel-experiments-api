<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Category;
use App\UserSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    public function getAllCategories()
    {
        $categories = Category::get();



        return response()->json([
            "categories" => $categories,
        ]);
    }

    public function getCategories()
    {
        $user = User::orderBy('id', 'desc')->where('id', Auth::user()->id)->with('categories')->first();

        $categories = $user['categories'];
        $categoriesArray = [];
        foreach ($categories as $category) {
            $categoriesArray[] = [
                "name" => $category['name'],
                "slug" => $category['slug'],
                "id" => $category['id'],
            ];
        }

        return response()->json([
            "categories" => $categoriesArray,
        ]);
    }

    public function editCategory(Request $request)
    {
        try {
            $id = $request['id'];
            $name = ucfirst($request['slug']);
            $slug = implode("-", explode(" ", $request['slug']));

            $category = Category::findOrFail($id);
            $category->name = $name;
            $category->slug = $slug;
            if ($category->save()) {
                # code...
                return response()->json([
                    "edit" => 'SUCCESS',
                ]);
            }
        } catch (\Throwable $th) {
            // grazie al try catch vado a cercare l'errore e restituisco un errore custom
            return response()->json([
                "edit" => "ERROR",
                "error type" => $th,
                "message" => "edit error"
            ], 420);
        }
    }
    public function addCategory(Request $request)
    {
        try {

            $category = new Category();
            $name = ucfirst($request['slug']);
            $slug = implode("-", explode(" ", $request['slug']));
            $category->name = $name;
            $category->slug = $slug;
            if ($category->save()) {
                # code...
                return response()->json([
                    "add" => 'SUCCESS',
                ]);
            }
        } catch (\Throwable $th) {
            // grazie al try catch vado a cercare l'errore e restituisco un errore custom
            return response()->json([
                "edit" => "ERROR",
                "error type" => $th,
                "message" => "add new category error"
            ], 420);
        }
    }


    public function addSelectedCategory(Request $request)
    {
        try {
            $names = $request['names'];
            $user = Auth::user();
            $user = User::orderBy('id', 'desc')->where('id', Auth::user()->id)->with('categories')->first();

            $categories = $user['categories'];
            $attachedIds = [];
            foreach ($categories as $category) {
                $attachedIds[] = [
                    $category['id']
                ];
            }


            foreach ($names as $name) {
                $id = Category::where('name', $name)->pluck('id')->toArray();

                if (!in_array($id, $attachedIds)) {
                    $user->categories()->attach($id);
                }
            }
            return response()->json([
                "add" => 'SUCCESS',
            ]);
        } catch (\Throwable $th) {
            // grazie al try catch vado a cercare l'errore e restituisco un errore custom
            return response()->json([
                "adding categories" => "ERROR",
                "error type" => $th,
                "message" => "add category to user error"
            ], 420);
        }
    }


    public function deleteCategory(Request $request)
    {
        $id = $request['id'];
        $category = Category::findOrFail($id);


        // qui elimino definitivamente la categoria
        $category->delete();
    }

    public function removeCategory(Request $request)
    {
        $id = $request['id'];
        $user = Auth::user();

        // non vado ad eliminare completamente la categoria, elimino solo la relazione con quell utente
        $user->categories()->detach($id);
    }

    public function getUserSettings()
    {
        try {
            $settings = UserSettings::where('user_id', Auth::user()->id)->first();
            // se usavo get() mi ritornava la collection, con first() mi ritorna solo un valore

            if ($settings) {
                return response()->json([
                    "message" => 'SUCCESS retrieving user settings',
                    "userSettings" => $settings,
                    "assetAvatar" => $settings->path
                    // per $settings->path vedi il model UserSettings
                ]);
            }
        } catch (\Throwable $th) {
            // grazie al try catch vado a cercare l'errore e restituisco un errore custom
            return response()->json([
                "getUserSettings categories" => "ERROR",
                "error type" => $th,
                "message" => "error getting user settings"
            ], 420);
        }
    }
    public function saveUserSettings(Request $request)
    {

        try {
            $settings = UserSettings::where('user_id', Auth::user()->id)->first();

            if (!$settings) {
                $settings = new UserSettings();
            }
            // $data = $request->validate([
            //     'hide_profile' => 'boolean',
            //     'address' => 'string',
            //     'number_of_orders' => 'numeric',
            //     // 'profile_image' => 'string',
            // ]);
            $settings->address = $request['address'];
            $settings->hide_profile = $request['hide_profile'];
            $settings->number_of_orders = $request['number_of_orders'];
            $settings->user_id = Auth::user()->id;

            if ($settings->save()) {
                return response()->json([
                    "add" => 'SUCCESS saving user settings',
                ]);
            }
        } catch (\Throwable $th) {
            // grazie al try catch vado a cercare l'errore e restituisco un errore custom
            return response()->json([
                "adding categories" => "ERROR",
                "error type" => $th,
                "message" => "error saving user settings"
            ], 420);
        }
    }

    public function saveFile(Request $request)
    {

        try {

            $settings = UserSettings::where('user_id', Auth::user()->id)->first();

            $file = $request->file('file');
            // dd([$file, $request->all()]);

            if (!$request->hasFile('file') || !$file->isValid()) {
                return response()->json([
                    "adding categories" => "ERROR",
                    "message" => "error saving file"
                ], 420);
            }

            $settings->profile_image =  $this->processFile($file, Auth::user()->id);

            if ($settings->save()) {
                return response()->json([
                    "add" => 'SUCCESS saving file',
                ]);
            }
        } catch (\Throwable $th) {
            // grazie al try catch vado a cercare l'errore e restituisco un errore custom
            return response()->json([
                "adding categories" => "ERROR",
                "error type" => $th,
                "message" => "error saving file"
            ], 420);
        }
    }




    /**
     * this method processes files upload
     */
    public function processFile($file, $id)
    {

        //nome standard dato da laravel
        // $fileName = $file->store(env('ALBUM_THUMBS_DIR'));

        //nome custom
        $string = $id . random_int(0, 9999) . '.' . $file->extension();
        $fileName = $file->storeAs('avatars', $string);

        return $fileName;
    }
}
