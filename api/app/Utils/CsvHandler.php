<?php

namespace App\Utils;

use App\Facades\MailSender;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CsvHandler {

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

        if (!$contents) {
            return '';
        }

        // 改行コードを統一
        $contents = str_replace(array("\r\n","\r"), "\n", $contents);

        // 行単位の配列作成
        $contents = explode("\n", $contents);

        // 1行目を無視する
        array_shift($contents);

        // 各行の値にキーを設定する
        $formattedContents = array();
        foreach ($contents as $row) {

            // 空行や空白のみの行を無視する
            if (!$row || preg_match('/^\s+$/', $row)) {
                continue;
            }

            // 必要カラム数が足りない場合、補完する
            $columns = explode(',', $row);
            $columns = array_pad($columns, count($header), '');

            // キーを設定
            $columns = array_combine($header, $columns);

            $formattedContents[] = $columns;
        }
        return $formattedContents;
    }

    /**
     * ファイルを削除する
     *
     * @param string $filePath
     * @return void
     */
    public function remove(string $filepath)
    {

         // ファイルの削除
        $result = Storage::disk('local')->delete($filepath);

        $result = false;

        // ファイルの削除に失敗
        if (!$result) {

            // メール送信
            $replacement = [
                '{{ filepath }}' => $filepath,
                '{{ datetime }}' => date('y-m-d h:i:s'),
            ];
            MailSender::sendNotification(
                config('mail.message_master.csv.fail_to_remove'),
                $replacement
            );
        }
    }
}