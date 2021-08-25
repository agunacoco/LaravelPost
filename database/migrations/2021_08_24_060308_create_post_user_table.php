<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_user', function (Blueprint $table) {
            $table->id();
            // constrained 메소드는 참조되는 테이블 및 컬럼 이름을 판별하기 위해 규칙을 사용.
            // 테이블 이름이 규칙과 일치하지 않는 경우 constrained 메소드에 인수로 전달하여 테이블 이름을 지정할 수 있습니다.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  
            $table->unsignedBigInteger('post_id'); 
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->timestamp('created_at');  //timestamp 시간 - 업데이트 시간이랑 작성 시간을 만들어준다.
            $table->unique(['user_id', 'post_id']); // 중복 저장 안되게 해준다. 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_user');
    }
}
