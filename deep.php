<?php

/**
 * DeepseekのChat Completion APIを使用して対話を行うシンプルな実装
 * 
 * このスクリプトは以下の機能を提供します：
 * - DeepseekのAPIに直接アクセス
 * - プロンプトの送信と応答の受信
 * - 応答データの整形と表示
 * - エラーハンドリング
 */

// APIの基本設定
// APIキーは本来は環境変数や設定ファイルで管理すべきです
function deep($comment = NULL){
$apiKey = 'sk-2b215a39065f4254be5ec07e63ca6d98';
$apiUrl = 'https://api.deepseek.com/v1/chat/completions';
if ( is_null($comment) ){
#$comment = '20メートル走は5.21秒です。5メートルリアクション走は1.8秒です。5-10-5メートルのアジリティ走は8秒です。私は小学5年生です。アドバイスをお願いします。';
#$comment = '20メートル走は5.21秒です。5メートルリアクション走は1.8秒です。5-10-5メートルのアジリティ走は8秒です。私は小学5年生です。身長160cmで体重50kgです。アドバイスをお願いします。';
$comment = '20メートル走は5.21秒です。平均は5.59秒です。5メートルリアクション走は1.8秒です。平均は2.0秒です。5-10-5メートルのアジリティ走は8秒です。平均は9.01秒です。私は小学5年生です。アドバイスをお願いします。';
}

// APIリクエストのパラメータを設定
$requestData = [
    'messages' => [
        [
            'role' => 'user',           // ユーザーからのメッセージ
            'content' => $comment  // プロンプト内容
        ]
    ],
    'model' => 'deepseek-chat',        // 使用するモデル
    'temperature' => 0.7,              // 応答のランダム性（0.0-1.0）
    'stream' => false                  // ストリーミングモードを無効化
];

try {
    // cURLセッションの初期化
    $ch = curl_init($apiUrl);
    
    // cURLオプションの設定
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,     // レスポンスを文字列として受け取る
        CURLOPT_POST => true,               // POSTリクエストを使用
        CURLOPT_POSTFIELDS => json_encode($requestData),  // リクエストボディをJSON化
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
	    'ClientType: guzzle',
            'Authorization: Bearer ' . $apiKey  // 認証ヘッダー
        ]
    ]);

    
    // APIリクエストの実行
    $response = curl_exec($ch);
    
    // cURLエラーのチェック
    if (curl_errno($ch)) {
        throw new Exception('API呼び出しエラー: ' . curl_error($ch));
    }
    
    // HTTPステータスコードの確認
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) {
        throw new Exception('APIエラー: HTTPステータスコード ' . $httpCode);
    }
    
    // cURLセッションのクリーンアップ
    curl_close($ch);
    
    // JSONレスポンスをデコード
    $result = json_decode($response, true);
    
    // JSONデコードエラーのチェック
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSONデコードエラー: ' . json_last_error_msg());
    }
    
    // 応答の整形表示
    $mess = "\nDeepseek応答:\n";
    $mess .= "----------------------------------------\n";
    $mess .= "メッセージ: " . $result['choices'][0]['message']['content'] . "\n";
    $mess .= "----------------------------------------\n";
    
    // 使用統計の表示
    $mess .= "統計情報:\n";
    $mess .= "- モデル: " . $result['model'] . "\n";
    $mess .= "- トークン使用量:\n";
    $mess .= "  - プロンプト: " . $result['usage']['prompt_tokens'] . " トークン\n";
    $mess .= "  - 応答: " . $result['usage']['completion_tokens'] . " トークン\n";
    $mess .= "  - 合計: " . $result['usage']['total_tokens'] . " トークン\n";
    $mess .= "----------------------------------------\n";

    $res =  $result['choices'][0]['message']['content'];
    
} catch (Exception $e) {
    // エラーメッセージの表示
    $res = $mess = "エラーが発生しました: " . $e->getMessage() . "\n";
}
    return $res;
}
