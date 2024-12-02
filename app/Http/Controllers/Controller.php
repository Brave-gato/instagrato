<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}


class ImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $imagePath = public_path('images/'.$imageName);

        // Redimensionner l'image avec GD
        $img = imagecreatefromstring(file_get_contents($image->getRealPath()));
        $width = imagesx($img);
        $height = imagesy($img);
        $newWidth = 300;
        $newHeight = 300;
        $imageResized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($imageResized, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($imageResized, $imagePath);

        // Enregistrer le chemin de l'image dans la base de données
        // ...
    }
}
