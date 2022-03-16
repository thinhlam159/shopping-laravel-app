<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Traits\StorageImageTrait;
use Illuminate\Support\Facades\Log;
use DB;

class AdminProductController extends Controller
{
    private $product;
    private $productImage;
    private $productTag;
    private $tag;

    public function __construct(
        Product      $product,
        ProductImage $productImage,
        ProductTag   $productTag,
        Tag          $tag)
    {
        $this->product = $product;
        $this->productImage = $productImage;
        $this->productTag = $productTag;
        $this->tag = $tag;
    }

    use StorageImageTrait;

    private function getCategories($parentCategoryId = null)
    {
        $categories = Category::all();
        $recusive = new Recusive($categories);
        $categoryHtmlSelect = $recusive->categoryRecusive($parentCategoryId, 0, '');
        return $categoryHtmlSelect;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->paginate(5);
        return view('admin.product.index')->with(compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categorySelectHtml = $this->getCategories();
        return view('admin.product.create')->with(compact('categorySelectHtml'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('add_product');
        try {
            DB::beginTransaction();
            $createProductData = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->contents,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
            ];
            $dataUploads = $this->storageTraitUpload($request, 'feature_image_path', 'product');
            if (!empty($dataUploads)) {
                $createProductData['feature_image_path'] = $dataUploads['file_path'];
                $createProductData['feature_image_name'] = $dataUploads['file_name'];
            }
            $product = Product::create($createProductData);
            if (!empty($product->id)) {
                if (!empty($request->file('image_path'))) {
                    foreach ($request->file('image_path') as $detailImage) {
                        $detailImageUploads = $this->storageTraitImage($detailImage, 'product');
                        $product->productImages()->create([
                                'image_path' => $detailImageUploads['file_path'],
                                'image_name' => $detailImageUploads['file_name'],
                            ]
                        );
                    }
                }
                if (!empty($request->has('tags'))) {
                    $tagIds = [];
                    foreach ($request->tags as $tag) {
                        $tagInstance = $this->tag->firstOrCreate([
                            'name' => $tag
                        ]);
                        $tagIds[] = $tagInstance->id;
                    }
                    $product->tags()->attach($tagIds);
                }
            }
            DB::commit();
            return redirect()->route('product.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line: ' . $exception->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit_product');
        $product = $this->product->find($id);
        $menuSelectHtml = $this->getCategories($product->category_id);
        return view('admin.product.edit')->with(compact('product', 'menuSelectHtml'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit_product');
        try {
            DB::beginTransaction();
            $createProductData = [
                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->contents,
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
            ];
            $dataUploads = $this->storageTraitUpload($request, 'feature_image_path', 'product');
            if (!empty($dataUploads)) {
                $createProductData['feature_image_path'] = $dataUploads['file_path'];
                $createProductData['feature_image_name'] = $dataUploads['file_name'];
            }
            $product = $this->product->find($id);
            $product->update($createProductData);
            if (!empty($product->id)) {
                if (!empty($request->file('image_path'))) {
                    $product->productImages()->detach();
                    foreach ($request->file('image_path') as $detailImage) {
                        $detailImageUploads = $this->storageTraitImage($detailImage, 'product');
                        $product->productImages()->create([
                                'image_path' => $detailImageUploads['file_path'],
                                'image_name' => $detailImageUploads['file_name'],
                            ]
                        );
                    }
                }
                if (!empty($request->has('tags'))) {
                    $tagIds = [];
                    foreach ($request->tags as $tag) {
                        $tagInstance = $this->tag->firstOrCreate([
                            'name' => $tag
                        ]);
                        $tagIds[] = $tagInstance->id;
                    }
                    $product->tags()->detach();
                }
            }
            DB::commit();
            return redirect()->route('product.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line: ' . $exception->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('delete_product');
        try {
            DB::beginTransaction();

            $product = $this->product->find($id)->delete();

            if (!empty($product->id)) {
                $product->productImages()->detach();
                $product->tags()->detach();
            }
            DB::commit();
            return redirect()->route('product.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line: ' . $exception->getLine());
        }
    }
}
