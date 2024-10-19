<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$settings = [
    'driver' => 'sqlite',
    'database' => __DIR__ . '/database.sqlite',
    'prefix' => '',
];

$capsule->addConnection($settings);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Drop existing tables if they exist
Capsule::schema()->dropIfExists('users');
Capsule::schema()->dropIfExists('groups');
Capsule::schema()->dropIfExists('group_user');
Capsule::schema()->dropIfExists('messages');

// Create users table
Capsule::schema()->create('users', function($table) {
    $table->increments('id');
    $table->string('username')->unique();
    $table->string('token')->unique();
    $table->timestamps();
});

// Create groups table
Capsule::schema()->create('groups', function($table) {
    $table->increments('id');
    $table->string('name')->unique();
    $table->timestamps();
});

// Create group_user table (pivot table)
Capsule::schema()->create('group_user', function($table) {
    $table->integer('user_id')->unsigned();
    $table->integer('group_id')->unsigned();
    $table->primary(['user_id', 'group_id']);
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
});

// Create messages table
Capsule::schema()->create('messages', function($table) {
    $table->increments('id');
    $table->integer('user_id')->unsigned();
    $table->integer('group_id')->unsigned();
    $table->text('message');
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
});
