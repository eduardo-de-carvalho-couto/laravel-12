<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

test('Testando tempo de consulta', function () {
    // dd('feature');

    $sql = "
        SELECT 
            users.name AS user_name,
            posts.title AS post_title,
            COUNT(comments.id) AS total_comments
        FROM posts
        JOIN users ON users.id = posts.user_id
        JOIN comments ON comments.post_id = posts.id
        JOIN category_post ON category_post.post_id = posts.id
        JOIN categories ON categories.id = category_post.category_id
        GROUP BY posts.id
        ORDER BY total_comments DESC
        LIMIT 10";

    $inicio = microtime(true);

    $resultado = DB::select($sql);

    $fim = microtime(true);
    $duracao = round($fim - $inicio, 4); // tempo em segundos, 4 casas decimais

    echo "\nTempo de execução da consulta: {$duracao} segundos\n";
    dump($resultado, $resultado);
})->only();
