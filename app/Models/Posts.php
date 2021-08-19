<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    public function imagePath(){
        $path = evn('IMAGE_PATH', '/storage/images/');
        
    }

    public function user()
    {
        return $this->belongsTo(User::class); // function으로 user와 관련된 내용을 가져올 수 있다. 
        //User에게 속한다. 1:n일때
    }

}
