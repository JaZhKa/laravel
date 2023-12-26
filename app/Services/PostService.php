<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;


class PostService
{
  public function store($data)
  {
    try {
      Db::beginTransaction();
      $tags = $data['tags'];
      $category = $data['category'];
      unset($data['tags'], $data['category']);

      $tagIds = $this->getTagIds($tags);
      if (!isset($category['id'])) {
        $category = Category::create($category);
      } else {
        $category = Category::find($category['id']);
      }
      $data['category_id'] = $category->id;
      $post = Post::create($data);
      $post->category()->associate($category);
      $post->save();
      $post->tags()->attach($tagIds);
      DB::commit();
    } catch (\Exception $exception) {
      DB::rollBack();
      return $exception->getMessage();
    }
    return $post;
  }

  public function update($post, $data)
  {
    try {
      Db::beginTransaction();
      $tags = $data['tags'];
      $category = $data['category'];
      unset($data['tags'], $data['category']);
      $tagIds = $this->getTagIdsWithUpdate($tags);
      $post->category_id = $this->getCategoryIdWithUpdate($category);
      $post->update($data);
      $post->save();
      $post->tags()->sync($tagIds);
      DB::commit();
    } catch (\Exception $exception) {
      DB::rollBack();
      return $exception->getMessage();
    }
    return $post->fresh();
  }

  private function getTagIds($tags)
  {
    $tagIds = [];
    foreach ($tags as $tag) {
      $tag = !isset($tag['id']) ? Tag::create($tag) : Tag::find($tag['id']);
      $tagIds[] = $tag->id;
    }
    return $tagIds;
  }

  private function getCategoryIdWithUpdate($item)
  {
    if (!isset($item['id'])) {
      $category = Category::create($item);
    } else {
      $category = Category::find($item['id']);
      $category->update($item);
      $category->save();
      $category = $category->fresh();
    }
    return $category->id;
  }


  private function getTagIdsWithUpdate($tags)
  {
    $tagIds = [];
    foreach ($tags as $tag) {
      if (!isset($tag['id'])) {
        $tag = Tag::create($tag);
      } else {
        $currentTag = Tag::find($tag['id']);
        $currentTag->update($tag);
        $tag = $currentTag->fresh();
      }
      $tagIds[] = $tag->id;
    }
    return $tagIds;
  }
}
