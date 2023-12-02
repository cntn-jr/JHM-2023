<?php

namespace App\Utils;

use Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Log;

class CsvHandler {

    // TODO: CSV情報をオブジェクトにする

    /**
     * ファイル形式がCSVであることを判定する
     *
     * @param UploadedFile $file
     * @return boolean
     */
    public static function isCsvExtension(UploadedFile $file): bool
    {
        return $file->extension() == "csv";
    }

    /**
     * CSVファイルを保存
     *
     * @param UploadedFile $file
     * @return string | false
     */
    public function save(UploadedFile $file)
    {

        // ファイル名を作成
        $date = date('YmdHis');
        $loginManagerId = Auth::id();
        $fileName = 'teachers_' . $date . '_' . $loginManagerId . '.csv';

        // ファイルを保存
        return $file->storeAs('public/teacher_csv', $fileName);
    }

    /**
     * ファイルデータを整形して配列として取得する
     *
     * @param string $filePath
     * @param array $header
     * @return array
     */
    public function getContents(string $filePath, array $header)
    {

        // ファイル内容を取得
        $contents = Storage::disk('local')->get($filePath);

        // 改行コードを統一
        $contents = str_replace(array("\r\n","\r"), "\n", $contents);

        // 行単位の配列作成
        $contents = explode("\n", $contents);
        array_shift($contents);

        // 各行の値にキーを設定する
        $formattedContents = array();
        foreach ($contents as $row) {
            $formattedContents[] = array_combine($header, explode(',', $row));
        }
        return $formattedContents;
    }

    public function remove(string $filePath)
    {
        // TODO: CSVファイル削除に失敗した場合、メール送信するようにする
        return Storage::disk('local')->delete($filePath);
    }
}