<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->paginate(5);
        return view('admin.category.index')->with(compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryHtmlSelect = $this->getCategories();
        return view('admin.category.create')->with(compact('categoryHtmlSelect'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required|unique:categories|max:255',
                'slug' => 'required|unique:categories|max:255',
                'parent_id' => 'required|int'
            ],
            [
                'name.require' => 'Tên category là bắt buộc!',
                'slug.require' => 'Slug category là bắt buộc!',
                'parent_id.require' => 'Tên category cha là bắt buộc!'
            ]
        );
        $category = new Category();
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->parent_id = $data['parent_id'];
        $category->save();
        return redirect()->route('categories.index')->with('status', 'Lưu category thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->category->find($id);
        $categoryHtmlSelect = $this->getCategories($category->parent_id);
        return view('admin.category.edit')->with(compact('category', 'categoryHtmlSelect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate(
            [
                'name' => 'required|max:255',
                'slug' => 'required|max:255',
                'parent_id' => 'required|int'
            ],
            [
                'name.require' => 'Tên category là bắt buộc!',
                'slug.require' => 'Slug category là bắt buộc!',
                'parent_id.require' => 'Tên category cha là bắt buộc!'
            ]
        );
        $category = $this->category->find($id);
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->parent_id = $data['parent_id'];
        $category->save();
        return redirect()->route('categories.index')->with('status', 'Cập nhật category thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);
        $category->delete();
        return redirect()->back()->with('status', "Xóa thành công $category->name!");
    }

//    public function messages()
//    {
//        return [
//            'name.required' => 'A title is required',
//            'slug.required' => 'A message is required',
//        ];
//    }

    private function getCategories($parentCategoryId = null) {
        $categories = $this->category->all();
        $recusive = new Recusive($categories);
        $categoryHtmlSelect = $recusive->categoryRecusive($parentCategoryId,0, '');
        return $categoryHtmlSelect;
    }
}
