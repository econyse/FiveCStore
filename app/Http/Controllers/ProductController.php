<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB;

class ProductController extends Controller
{

    public function Index() {
        $collection = (new MongoDB\Client)->FiveCStore->Products;
        $products = $collection->find();
        return view('Admin.Products.index', [ "products" => $products ]);
    }

    public function ProductStore() {
        $collection = (new MongoDB\Client)->FiveCStore->Products;
        $productCount = $collection->count();
        $page = request("pg") == 0 ? 1 : request("pg");
        $products = $collection->find([], [ "limit" => 12, "skip" => ($page - 1) * 12 ]);
        return view('Products.index', [ "products" => $products, "productCount" => $productCount ]);
    }

    public function ProductDetails($id) {
        $collection = (new MongoDB\Client)->FiveCStore->Products;
        $product = $collection->findOne([ "_id" => new MongoDB\BSON\ObjectId($id) ]);
        return view("Products.Details", ["product" => $product]);
    }

    public function Show($id) { //Details
        $collection = (new MongoDB\Client)->FiveCStore->Products;
        $product = $collection->findOne([ "_id" => new \MongoDB\BSON\ObjectId($id) ]);
        return view('Admin.Products.details', [ "product" => $product ]);
    }

    public function Create() {
        $collection = (new MongoDB\Client)->FiveCStore->Categories;
        $categories = $collection->find();
        return view('Admin.Products.create', [ "categories" => $categories ]);
    }

    public function Store() {
        $product = [
            "product_name" => request("product_name"),
            "category_id" => request("category"),
            "description" => request("description"),
            "price" => request("price"),
            "currency" => request("currency"),
            "specification" => [],
            "rating" => [],
            "comments" => []
        ];
        $collection = (new MongoDB\Client)->FiveCStore->Products;
        $insertOneResult = $collection->insertOne($product);
        if ($insertOneResult->getInsertedCount() == 1) 
            return redirect('/admin/products')->with('mssg', request('product_name')." was added succesfuly.")->with('alerttype', "success");
            
    }

    public function Edit($id) {
        $collection = (new MongoDB\Client)->FiveCStore->Products;
        $collectionC = (new MongoDB\Client)->FiveCStore->Categories;
        $categories = $collectionC->find();
        $product = $collection->findOne([ "_id" => new \MongoDB\BSON\ObjectId($id) ]);
        return view('Admin.Products.edit', [ "product" => $product, "categories" => $categories]);
    }

    public function Update() {
        $collection = (new MongoDB\Client)->FiveCStore->Products;
        $product = [
            "product_name" => request("product_name"),
            "category_id" => request("category"),
            "description" => request("description"),
            "price" => request("price"),
            "currency" => request("currency"),
            "specification" => [],
            "rating" => [],
            "comments" => []
        ];
        $updateOneResult = $collection->updateOne([
            "_id" => new \MongoDB\BSON\ObjectId(request("productid"))
        ],[
            '$set' => $product
        ]);

        if($updateOneResult->getModifiedCount() == 1)
            return redirect("/admin/products/".request("productid"))->with('mssg', "Updated succesfuly.")->with("alerttype", "success");
    }

    public function Delete($id) {
        $collection = (new MongoDB\Client)->FiveCStore->Products;
        $collectionC = (new MongoDB\Client)->FiveCStore->Categories;
        $categories = $collectionC->find();
        $product = $collection->findOne([ "_id" => new \MongoDB\BSON\ObjectId($id) ]);
        return view('Admin.Products.delete', [ "product" => $product, "categories" => $categories ]);
    }

    public function Remove() {
        $collection = (new MongoDB\Client)->FiveCStore->Products;
        $productname = request('product_name');
        $deletOneResult = $collection->deleteOne([
            "_id" => new \MongoDB\BSON\ObjectId(request("productid"))
        ]);

        if($deletOneResult->getDeletedCount() == 1)
            return redirect("/admin/products")->with("mssg", $productname." was deleted succesfuly.")->with("alerttype", "success");
    }

    public function AddComment() {
        $collection = (new MongoDB\Client)->FiveCStore->Products;
        $comment = [
            "user_id" => request('userid'),
            "comment" => request('comment'),
            "date" => date("Y-m-d H:i:s")
        ];
        $product = $collection->findOne([ "_id" => new MongoDB\BSON\ObjectId(request('productid')) ]);
        $comments = $product->comments;
        if (count($comments) == 0 || $comments == null || empty($comments)) {
            $comments = [$comment];
        } else {
            $comments = [$comment, ...$comments];
        }
        $updateOneResult = $collection->updateOne([
            "_id" => new MongoDB\BSON\ObjectId(request('productid'))
        ],[
            '$set' => [ "comments" => $comments ]
        ]);

        return redirect("/products/".request('productid'));
    }
}
