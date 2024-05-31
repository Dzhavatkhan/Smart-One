<?php

namespace App\Http\Resources;

use App\Models\ReviewDisike;
use App\Models\ReviewLike;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {

        $date = 1;
        $isYourLike = ReviewLike::where("userId", Auth::id())->where("reviewId", $this->id)->count() > 0;
        $isYourDislike = ReviewDisike::where("userId", Auth::id())->where("reviewId", $this->id)->count() > 0;


        if($this->updated_at->format("d.m.Y") == Carbon::today()->format("d.m.Y")){
            $date =  $this->updated_at->format("H:i");
            $date = "Сегодня в $date";
        }
        else if($this->updated_at->format("d.m.Y") == Carbon::yesterday()->format("d.m.Y")){
            $date =  $this->updated_at->format("H:i");
            $date = "Вчера в $date";
        }
        else if($this->updated_at->format("d.m.Y H:i") == Carbon::now()->format("d.m.Y h:i")){
            $date =  $this->updated_at->format("H:i");
            $date = "Только что";
        }
        else{
            $date =  $this->updated_at->format("d.m.Y");
            $date = "$date";
        }

        return [
            "id" => $this->id,
            "myLike" => $isYourLike,
            "myDislike" => $isYourDislike,
            "advantages" => $this->advantages,
            "comment" => $this->comment,
            "disadvantages" => $this->disadvantages,
            "rate" => $this->rate,
            "date" => $date,
            "updated_at" => $this->updated_at,
            "user" => $this->user,
            "images" => $this->image,
            "likes" => count($this->likes),
            "dislikes" => count($this->dislikes)

        ];
    }
}
