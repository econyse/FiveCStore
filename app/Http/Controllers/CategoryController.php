<?php

namespace App\Http\Controllers;
use MongoDB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index() {
        $collection = (new MongoDB\Client)->FiveCStore->Categories;
        $categories = $collection->find();
        return view('admin.categories.index', [ "categories" => $categories ]);
    }

    public function create() {
        $collection = (new MongoDB\Client)->FiveCStore->Categories;
        $category = (object)[
            "category" => request("category"),
            "description" => request("description")
        ];
        $insertOneResult = $collection->insertOne($category);
        if ($insertOneResult->getInsertedCount() == 1)
            return redirect(route('categories'))->with("mssg", "Category ".$insertOneResult->getInsertedId()." created.")->with("alerttype", "success");
        else    
            return redirect(route('categories'))->with("mssg", "Category was not created. Try again later")->with("alerttype", "warning");
    }

    public function edit($id) {
        $collection = (new MongoDB\Client)->FiveCStore->Categories;
        $category = (object)[
            "category" => request("editcategory"),
            "description" => request("editdescription")
        ];
        $updateOneResult = $collection->updateOne(
            [ "_id" => new MongoDB\BSON\ObjectId($id) ],
            [ '$set' => $category ]
        );
        if ($updateOneResult->getModifiedCount() == 1)
            return redirect(route('categories'))->with("mssg", "Category $id edited.")->with("alerttype", "primary");
        else    
            return redirect(route('categories'))->with("mssg", "Category $id was not edited. Try again later")->with("alerttype", "warning");
    }

    public function delete($id) {
        $collection = (new MongoDB\Client)->FiveCStore->Categories;
        $deleteOneResult = $collection->deleteOne([ "_id" => new MongoDB\BSON\ObjectId($id) ]);
        if ($deleteOneResult->getDeletedCount() == 1)
            return redirect(route('categories'))->with("mssg", "Category $id deleted.")->with("alerttype", "danger");
        else
            return redirect(route('categories'))->with("mssg", "Category $id was not deleted. Try again later.")->with("alerttype", "warning");
    }
}
