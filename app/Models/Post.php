<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tag;

class Post extends Model
{
    use HasFactory;
    use Filterable;
    use SoftDeletes;

    protected $table = 'posts';
    protected $guarded = false;
    protected $fillable = ['title', 'content', 'image', 'likes', 'category', 'tags', 'user'];


    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
