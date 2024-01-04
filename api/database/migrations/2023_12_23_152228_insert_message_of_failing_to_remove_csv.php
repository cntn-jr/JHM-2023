<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $content = <<<EOF
        ファイルパス：{{ filepath }}
        操作日時：{{ datetime }}

        CSVファイルの削除に失敗しました。
        EOF;

        DB::table('messages')->insert([
            'message_master_id' => config('mail.message_master.csv.fail_to_remove'),
            'title'             => 'fail to remove CSV',
            'content'           => $content,
            'created_at'        => date('y-m-d h:i:s'),
            'updated_at'        => date('y-m-d h:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::delete('delete from messages where message_master_id = ?', [config('mail.message_master.csv.fail_to_remove')]);
    }
};
