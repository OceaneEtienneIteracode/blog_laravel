<?php

    namespace App\Models;

//    use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
    {
        public $title;
        public $excerpt;
        public $date;
        public $body;
        public $slug;


        public function __construct($title, $excerpt, $date, $body, $slug)
        {
            $this->title = $title;
            $this->excerpt = $excerpt;
            $this->date = $date;
            $this->body = $body;
            $this->slug=$slug;
        }

        public static function all()
        {
             return cache()->rememberForever('posts.all',function(){ //Lorsqu'un nouveau post est créé on clear le cache
                 // Laracast - Laravel 8 From Scratch E3 1:54
                 return collect(File::files(resource_path("posts/")))

                     ->map(fn($file) => YamlFrontMatter::parseFile($file))

                     ->map(fn($document) => new Post(
                         $document->title,
                         $document->excerpt,
                         $document->date,
                         $document->body(),
                         $document->slug,
                     ))
                     ->sortByDesc('date'); //Laracast - Laravel 8 From Scratch E13 00:30min
             });
        }

        public static function find($slug)
        {
            return static::all()->firstWhere('slug',$slug);
        }
        public static function findOrFail($slug)
        {
            $post= static::find($slug);

            if (!$post){
                throw new ModelNotFoundException();
            }

            return $post;
        }

    }
