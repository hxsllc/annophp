<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnnotationPage;
use App\Models\Annotation;
use App\Models\AnnotationSelector;

class AnnotationController extends Controller
{
    //
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function getAllByCanvasId()
    {
        // Get Params
        $canvasId = $this->request["canvasId"];

        // Annotation Object
        $annotObj = array();

        $annotPage =  AnnotationPage::where([
            ["canvas_id", '=', $canvasId]
        ])->first();

        if ($annotPage) {

            $annotObj["id"] = $annotPage->canvas_id;
            $annotObj["items"] = array();
            $annotObj["type"] = "AnnotationPage";
            
            $annotationCnt = 0;
            $annotations = Annotation::where([
                ["annotation_page_id", "=", $annotPage->id]
            ])->get();

            if ($annotations) {
                foreach ($annotations as $annotation) {
                    $annotObj["items"][$annotationCnt] = array();
                    $annotObj["items"][$annotationCnt]["body"] = array();
                    $annotObj["items"][$annotationCnt]["body"]["type"] = $annotation->body_type;
                    $annotObj["items"][$annotationCnt]["body"]["value"] = $annotation->body_value;
                    $annotObj["items"][$annotationCnt]["id"] = $annotation->item_id;
                    $annotObj["items"][$annotationCnt]["motivation"] = $annotation->motivation;
                    $annotObj["items"][$annotationCnt]["type"] = $annotation->type;
                    $annotObj["items"][$annotationCnt]["target"] = array();
    
                    $selectors = AnnotationSelector::where([
                        ["annotation_id", "=", $annotation->id]
                    ])->get();

                    if ($selectors) {
                        $selectorCnt = 0;
                        $annotObj["items"][$annotationCnt]["target"]["source"] = $annotPage->canvas_id;
                        $annotObj["items"][$annotationCnt]["target"]["selector"] = array();
                        foreach ($selectors as $selector) {
                            $annotObj["items"][$annotationCnt]["target"]["selector"][$selectorCnt] = array();
                            $annotObj["items"][$annotationCnt]["target"]["selector"][$selectorCnt]["type"] = $selector->type;
                            $annotObj["items"][$annotationCnt]["target"]["selector"][$selectorCnt]["value"] = $selector->value;
                            $selectorCnt ++;
                        }
                    }

                    $annotationCnt ++;
                }
            }
        }

        return response()->json([
            "annotations" => $annotObj
        ]);
    }

    public function create()
    {
        $annotation = $this->request["annotation"];

        $canvas = $annotation["canvas"];
        $data = json_decode($annotation["data"]);
        $uuid = $annotation["uuid"];
        $bodyType = is_object($data->body) ? $data->body->type : "";
        $bodyValue = is_object($data->body) ? $data->body->value : "";
        $itemId = $data->id;
        $motivation = $data->motivation;
        $target = $data->target;
        $type = $data->type;

        // If annotation page exist then create.
        $page = AnnotationPage::where([
            ['canvas_id', '=', $canvas]
        ])->first();
        if (!$page) {
            $page = AnnotationPage::create([
                "canvas_id" => $canvas,
                "uuid" => $uuid
            ]);
        }

        $annotation = Annotation::create([
            "annotation_page_id" => $page["id"],
            "body_type" => $bodyType,
            "body_value" => $bodyValue,
            "item_id" => $itemId,
            "motivation" => $motivation,
            "type" => $type
        ]);

        // $source = is_object($target) ? $target->source : $target;
        $selectors = is_object($target) ? $target->selector : null;

        if ($selectors) {
            foreach ($selectors as $selector) {
                $annotation->annotationSelectors()->create([
                    "type" => $selector->type,
                    "value" => $selector->value
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
