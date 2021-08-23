<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 여기서 잘못된 것은 모델명은 복수를 사용안한다. 
class Posts extends Model
{
    use HasFactory;

    public function imagePath(){
        $path = env('IMAGE_PATH', '/storage/images/');
        $imageFile = $this->image ?? 'nono.jpg';
        return $path.$imageFile;
    }

    public function user()
    {
        return $this->belongsTo(User::class); // function으로 user와 관련된 내용을 가져올 수 있다. 
        //User에게 속한다. 1:n일때
    }

}
