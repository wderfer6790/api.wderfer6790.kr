<?php

namespace Database\Factories;

use App\Models\{User, Article, File};
use Illuminate\Database\Eloquent\Factories\Factory;
use Exception;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        $userId = User::take(1)->inRandomOrder()->value('id');
        if(!$userId) {
            throw new Exception('user not found');
        }

        $updated_at = $this->faker->date("Y-m-d H:i:s");
        $views = $this->faker->numberBetween(0, 9999);
        $content = $this->faker->text(1024);
        $divide = (int)(strlen($content)/2);
        $prev = substr($content, 0, $divide);
        $next = substr($content, $divide);


        return [
            'user_id' => $userId,
            'title' => $this->faker->text(64),
            'content' => serialize([
                ['insert' => $prev],
                ['insert' => "\\n"],
                ['insert' => "\\n"],
                ['insert' => $next]
            ]),
            'views' => $views,
            'likes' => $this->faker->numberBetween(0, $views),
            'created_at' => $this->faker->date("Y-m-d H:i:s", $updated_at),
            'updated_at' => $updated_at,
        ];
    }

    /**
     * @return ArticleFactory
     */
    public function configure(): ArticleFactory
    {
        return $this->afterCreating(function(Article $article) {
            // 90% 확률로 이미지 파일 추가
            if (File::count() > 0 && random_int(0, 100) < 90) {
                $file = File::take(1)->inRandomOrder()->first();
                if (!$file) {
                    throw new Exception('user profile image not found');
                }

                $article->files()->attach($file);

                $arr = unserialize($article->content);
                $article->update([
                    'content' => serialize([
                        $arr[0],
                        $arr[1],
                        ['insert' => ['image' => asset($file->path)]],
                        $arr[2],
                        $arr[3],
                    ])
                ]);
            }
        });
    }
}
