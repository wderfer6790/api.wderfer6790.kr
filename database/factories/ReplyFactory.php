<?php

namespace Database\Factories;

use App\Models\{User, Article, Reply, File};
use Illuminate\Database\Eloquent\Factories\Factory;
use Exception;

/**
 * @extends Factory<Reply>
 */
class ReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        $article_id = Article::take(1)->inRandomOrder()->value('id');
        if (!$article_id) {
            throw new Exception('article empty');
        }

        $user_id = User::take(1)->inRandomOrder()->value('id');
        if (!$user_id) {
            throw new Exception('user not found');
        }

        return [
            'article_id' => $article_id,
            'user_id' => $user_id,
            'content' => $this->faker->text(128)
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Reply $reply) {
            if (File::count() > 0 && random_int(0, 99) > 79) {
                $fileId = File::take(1)->inRandomOrder()->value('id');
                if (!$fileId) {
                    throw new Exception('file not found');
                }
                $reply->files()->attach($fileId);
            }

            if (random_int(0, 99) > 59) {
                $userId = User::take(1)->inRandomOrder()->value('id');
                if (!$userId) {
                    throw new Exception('user not found');
                }

                $child = new Reply([
                    'article_id' => $reply->article_id,
                    'parent_id' => $reply->id,
                    'user_id' => $userId,
                    'content' => $this->faker->text(128),
                ]);
                $child->save();
                $child->refresh();
                if (random_int(0, 99 > 79)) {
                    $fileId = File::take(1)->inRandomOrder()->value('id');
                    if (!$fileId) {
                        throw new Exception('file not found');
                    }
                    $reply->files()->attach($fileId);
                }
            }
        });
    }
}
