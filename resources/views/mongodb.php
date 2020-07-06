<?php
// require_once __DIR__ . "/vendor/autoload.php";
// $collection = (new MongoDB\Client)->FiveCStore->Users;

// $cursor = $collection->find(
//     [],
//     [
//         'limit' => 5,
//         'sort' => ['pop' => -1],
//     ]
// );
// // var_dump($cursor);
// // print_r($cursor);
// foreach ($cursor as $document) {
//     print_r($document);
// }

// $collection = (new MongoDB\Client)->FiveCStore->Categories;
// Create Functions

// $insertResult = $collection->insertOne([
//     "category" => "Cellphones",
//     "description" => "Phones for the on the go use."
// ]);

// printf("Inserted %d document(s)<br />", $insertResult->getInsertedCount());
// var_dump($insertResult->getInsertedID());

// Read Function
// $table = $collection->find();

// foreach ($table as $record) {
//     echo "<br />";
//     echo "ID: ".$record["_id"]."<br />";
//     echo "Category: ".$record->category."<br />";
//     echo "Description: ".$record["description"]."<br />";
// }

// Update Function

// $updateOneResult = $collection->updateOne([
//     "category" => "Cellphones"
// ],[
//     '$set' => ["description" => "Mobile Phones"]
// ]);

// printf("Matched %d Document(s)<br/>", $updateOneResult->getMatchedCount());
// printf("Updated %d Document(s)<br/>", $updateOneResult->getModifiedCount());

// Delete Function
// $delteResult = $collection->deleteOne([
//     "category" => "Cellphones"
// ]);

// printf("Deleted %d Document(s)<br />", $delteResult->getDeletedCount());


// $collection = (new MongoDB\Client)->FiveCStore->Products;
// $id = new \MongoDB\BSON\ObjectId("5ee227ef4250884f6c89c950");
// $product = $collection->findOne([ "_id" => $id]);
// $product = $collection->find();

// var_dump($product);
// print_r($product);

// $collection = (new MongoDB\Client)->FiveCStore->Products;
// $productCount = $collection->count([ "category_id" => "1234"]);

// print_r($productCount);


$collection = (new MongoDB\Client)->FiveCStore->Products;
        $comment = [
            "user_id" => "5ee224c74250884f6c89c94e",
            "comment" => "Works good enough.",
            "date" => date("Y-m-d H:i:s")
        ];
        $product = $collection->findOne([ "_id" => new MongoDB\BSON\ObjectId("5ee227ef4250884f6c89c950") ]);
        $comments = $product->comments;
        if (count($comments) == 0 || $comments == null || empty($comments)) {
            $comments = [$comment];
        } else {
            $comments = [$comment, ...$comments];
        }
        $updateOneResult = $collection->updateOne([
            "_id" => new MongoDB\BSON\ObjectId("5ee227ef4250884f6c89c950")
        ],[
            '$set' => [ "comments" => $comments ]
        ]);

        $product = $collection->findOne([ "_id" => new MongoDB\BSON\ObjectId("5ee227ef4250884f6c89c950") ]);
        print_r($product->comments);
