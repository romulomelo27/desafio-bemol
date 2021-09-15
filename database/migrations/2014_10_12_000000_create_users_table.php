<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('cpf',13)->unique();
            $table->string('rg',30)->nullable();
            $table->date('nascimento');
            $table->string('cep',8)->nullable();
            $table->string('rua',100)->nullable();
            $table->string('rua',8)->nullable();            
            $table->string('complemento',80)->nullable();            
            $table->string('estado',2)->nullable();            
            $table->string('cidade',80)->nullable();
            $table->string('telefone',15)->nullable();
            $table->string('celular',15)->nullable();
            $table->string('foto',255)->nullable();            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
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
}
