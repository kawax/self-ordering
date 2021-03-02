<?php

namespace Revolution\Ordering\Menu;

use Illuminate\Support\Collection;
use Revolution\Ordering\Contracts\Menu\MenuData;

class SampleMenu implements MenuData
{
    /**
     * @return Collection
     */
    public function __invoke(): Collection
    {
        $id = 1;

        return collect([
            [
                'id'       => $id++,
                'name'     => 'テスト1',
                'price'    => 100,
                'category' => 'カテゴリーA',
            ],
            [
                'id'       => $id++,
                'name'     => 'テスト2',
                'text'     => 'あいうえお',
                'price'    => 100,
                'category' => 'カテゴリーA',
            ],
            [
                'id'       => $id++,
                'name'     => 'テスト3',
                'text'     => 'かきくけこさしすせそ',
                'price'    => 200,
                'category' => 'カテゴリーA',
            ],
            [
                'id'       => $id++,
                'name'     => '牛丼',
                'text'     => '',
                'price'    => 200,
                'category' => 'カテゴリーB',
                'image'    => $this->image('food_gyudon.png'),
            ],
            [
                'id'       => $id++,
                'name'     => 'そば',
                'price'    => 200,
                'category' => 'カテゴリーB',
                'image'    => $this->image('soba_kake.png'),
            ],
            [
                'id'       => $id++,
                'name'     => 'モーニングセット',
                'text'     => '★モーニング限定',
                'price'    => 300,
                'category' => 'カテゴリーC',
                'image'    => $this->image('cafe_morning_coffee_set.png'),
            ],
            [
                'id'       => $id++,
                'name'     => 'ビーフステーキ',
                'price'    => 400,
                'category' => 'カテゴリーD',
                'image'    => $this->image('food_beefsteak.png'),
            ],
            [
                'id'       => $id++,
                'name'     => 'ラザニア（ランチ限定）',
                'price'    => 500,
                'category' => 'カテゴリーE',
                'image'    => $this->image('food_lasagna_razania.png'),
            ],
            [
                'id'       => $id++,
                'name'     => 'カツカレー',
                'price'    => 600,
                'category' => 'カテゴリーF',
                'image'    => $this->image('food_katsu_curry.png'),
            ],
            [
                'id'       => $id++,
                'name'     => '店員へのメッセージ',
                'text'     => '追加メモに用件を書いて店員呼び出しの代わりにご利用ください（0円で後払いを選択）',
                'price'    => 0,
                'category' => '店員呼出',
            ],
            [
                'id'       => $id++,
                'name'     => '注文のキャンセル',
                'text'     => '注文直後のキャンセルは近くの店員に声をかけるか、こちからメモを書いてお伝えください。',
                'price'    => 0,
                'category' => '店員呼出',
            ],
        ]);
    }

    /**
     * @param  string  $image
     *
     * @return string
     */
    protected function image(string $image): string
    {
        return asset('images/'.$image);
    }
}
