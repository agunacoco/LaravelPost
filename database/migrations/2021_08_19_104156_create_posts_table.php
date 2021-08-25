<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // up 메소드는 데이터베이스에 테이블, 컬럼, 인덱스를 추가하는데 사용.
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('content');
            $table->string('image')->nullable();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // down 메소드는 up 메소드의 동작을 취소한다.
    public function down()
    {
        // 이미 존재하는 테이블을 제거하려면 dropIfExists 메소드를 사용.
        Schema::dropIfExists('posts');
    }
}
