<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // nullable é como se fosse um registro opcional, se não tiver esse elemento, não vai dar erro
            $table->string('type')->default('adm');
            $table->string('cpf');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken()->nullable();
            $table->timestamps();
        }); 

        // Banco de dados alimentado
            DB::table('users')->insert([
            'cpf' => '12345678911',
            'password' => '123456'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
