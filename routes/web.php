<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => response()->json(['name' => config('app.name')]));
// NOVAX Health (Render/Cloudflare)
Route::get("/healthz", function () {
    return response()->json(["ok" => true, "service" => "novax-api", "ts" => date("c")], 200);
});
Route::get("/health", function () {
    return response()->json(["ok" => true, "service" => "novax-api", "ts" => date("c")], 200);
});

