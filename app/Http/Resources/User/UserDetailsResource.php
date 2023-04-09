<?php

namespace App\Http\Resources\User;

use App\TechDiary\Markdown\TDMarkdown;
use Illuminate\Http\Resources\Json\JsonResource;

// https://gist.github.com/hassanazimi/97c00d715fee2ed8b60f876e48b2b27d
//function calculate_profile($profile)
//{
//    if (!$profile) {
//        return 0;
//    }
//    $columns = preg_grep('/(.+ed_at)|(.*id)/', array_keys($profile), PREG_GREP_INVERT);
//    $per_column = 100 / count($columns);
//    $total = 0;
//
//    foreach ($profile as $key => $value) {
//        if ($value !== NULL && $value !== [] && in_array($key, $columns)) {
//            $total += $per_column;
//        }
//    }
//
//    return $total;
//}

class UserDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $md = new TDMarkdown($this->profile_readme);

        return array_merge(parent::toArray($request), [
            'profile_readme_html' => $md->toHTML(),
        ]);
    }
}
