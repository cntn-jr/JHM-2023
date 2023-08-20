<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currentYear = now()->year();
        $fiscalYear = $currentYear + fake()->numberBetween(-1, 1);
        $courseNames = [
            '工学部情報学科',
            '理学部数学科',
            'ITエンジニア科',
            'ゲームクリエイター科',
            '工学部電子工学科',
            '理学部物理科',
            '経済学部',
            'ITイノベーション科',
            'ICTマネジメント科',
            '工学部建築学科',
            '社会学部',
            'web学科',
            '情報処理学科',
            '専門部IT専門コース',
            'WEBエンジニアコース',
            'ホワイトハッカー',
            'システムエンジニア科',
            'ITシステム科',
            'ゲームWeb科',
            'プログラマーコース',
        ];
        return [
            'name' => fake()->randomElement($courseNames),
            'grade' => fake()->numberBetween(1, 4),
            'fiscal_year' => $fiscalYear,
        ];
    }
}
