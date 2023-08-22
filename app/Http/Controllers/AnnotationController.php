<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Annotation;

class AnnotationController extends Controller
{
    //
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function create() {
        $canvas = $this->request["canvas"];
        $items = $this->request["data"];

        $annotation = Annotation::create([
            "canvas_id" => $canvas,
            "type" => "AnnotationPage"
        ]);

        foreach ($items as $item) {
            $annotationItem = $annotation->annotationItems()->create([
                "body_type" => $item["body"]["type"],
                "body_value" => $item["body"]["value"],
                "item_id" => $ite["id"],
                "motivation" => $item["motivation"],
                "type" => $item["type"]
            ]);

            foreach ($item["target"]["selector"] as $selector) {
                $annotationItem->annotationItemSelectors()->create([
                    "type" => $selector["type"],
                    "value" => $selector["value"]
                ]);
            }
        }

        return response()->json([
            "result" => "success"
        ]);
    }

    public function update() {
        $annotationId = $this->request["id"];

        Annotation::where("id", $annotationId)->update([
            "canvas_id" => $this->request["canvas"],
            "type" => "AnnotationPage"
        ]);

        AnnotationItem::where("annotation_id", $annotationId)->update([
            "body_type" => $item["body"]["type"],
            "body_value" => $item["body"]["value"],
            "item_id" => $item["id"],
            "motivation" => $item["motivation"],
            "type" => $item["type"]
        ]);

        AnnotationItemSelector::where("annotation_item_id", $annotationId)->update([
            "type" => $selector["type"],
            "value" => $selector["value"]
        ]);

        return response()->json([
            "result" => "success"
        ]);
    }

    public function delete() {
        $annotationId = $this->request["id"];

        Annotation::destroy($annotationId);
        AnnotationItem::where("annotation_id", $annotationId)->delete();
        AnnotationItemSelector::where("annotation_item_id", $annotationId)->delete();

        return response()->json([
            "result" => "success"
        ]);
    }
}
