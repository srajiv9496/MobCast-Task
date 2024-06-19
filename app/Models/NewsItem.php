<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $fillable = ['title', 'link', 'description', 'pubDate', 'guid', 'dcCreator', 'enclosure'];
    protected $perPage = 10;
}
