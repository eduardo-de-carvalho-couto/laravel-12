<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

test('Testando tempo de consulta', function () {
    // dd('feature');

    $sql = "
        SELECT 
            users.id AS user_id,
            users.name AS user_name,
            COUNT(DISTINCT posts.id) AS total_posts,
            COUNT(comments.id) AS total_comments,
            AVG(LENGTH(comments.body)) AS avg_comment_length,
            GROUP_CONCAT(DISTINCT categories.name SEPARATOR ', ') AS categories_involved,
            MD5(GROUP_CONCAT(comments.body)) AS hash_blob,
            REVERSE(users.name) AS reversed_name
        FROM users
        JOIN posts ON posts.user_id = users.id
        JOIN comments ON comments.post_id = posts.id
        JOIN category_post ON category_post.post_id = posts.id
        JOIN categories ON categories.id = category_post.category_id
        WHERE categories.name IN (
            'tech', 'science', 'news', 'sports', 'music',
            'finance', 'history', 'health', 'games', 'travel'
        )
        GROUP BY users.id, users.name
        ORDER BY total_comments DESC, avg_comment_length DESC";

    $inicio = microtime(true);

    $resultado = DB::select($sql);

    $fim = microtime(true);
    $duracao = round($fim - $inicio, 4); // tempo em segundos, 4 casas decimais

    echo "\nTempo de execução da consulta: {$duracao} segundos\n";
    dump($resultado, $resultado);
})->only();
