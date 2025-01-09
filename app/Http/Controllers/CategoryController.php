<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\MediaController;

class CategoryController extends Controller
{
    public function list()
    {
        $categoryResources = [];
        Category::chunk(100, function($categories) use (&$categoryResources) {
            $categoryResources = array_merge($categoryResources, CategoryResource::collection($categories)->toArray(request()));
        });
        if (empty($categoryResources)) {
            return Helper::responseData('No Categories Found', false, null, 404);
        }
        return Helper::responseData('Categories found', true, $categoryResources, Response::HTTP_OK);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        $this->authorize('create', $category);
        if ($request->hasFile('media')) {
            $mimeType = $request->file('media')->getMimeType();
            MediaController::saveMedia($request, $mimeType, $category, Category::class);
        }
        return Helper::responseData('Category Added Successfully', true, new CategoryResource($category), Response::HTTP_OK);

    }

    public function show(int $categoryId)
    {
        $category = Category::findOrFail($categoryId);
//        $this->authorize('show', $category);
        return Helper::responseData('Category found', true, CategoryResource::make($category), Response::HTTP_OK);
    }


    public function update(UpdateCategoryRequest $request, int $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->update($request->validated());
        return Helper::responseData('Category Updated', true, CategoryResource::make($category), Response::HTTP_OK);

    }

    public function destroy(int $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->delete();
        return Helper::responseData('Comment Deleted', true, null, Response::HTTP_OK);

    }
}
