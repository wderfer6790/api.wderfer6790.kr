<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File as FileInfo;
use Illuminate\Support\Facades\Storage;
use Exception;
/**
 * @extends Factory<File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        $dir = Storage::disk('public');

        $from = collect($dir->Files('image/sample'))->random();
        $to = 'uploaded' . DIRECTORY_SEPARATOR . uniqid(date("ymdHis_")) . "." . FileInfo::extension($from);
        if (!$dir->copy($from, $to) || !$dir->exists($to)) {
            throw new Exception('file not copied');
        }

        $orgPath = $dir->path($from);
        return [
            'name' => FileInfo::basename($from),
            'path' => 'storage' . DIRECTORY_SEPARATOR . $to,
            'mime_type' => FileInfo::mimeType($orgPath),
            'size' => FileInfo::size($orgPath)
        ];
    }
}
