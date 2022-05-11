<?php namespace Chkilel\Icones\Updates;

use Chkilel\Icones\Models\IconSet;
use Iconify\IconsJSON\Finder;
use Seeder;

class SeedIconSetsTable extends Seeder
{
    public function run(): void
    {
        $this->createIconSets();
    }

    public function createIconSets(): void
    {
        // Load all collections' information from "collections-json" library
        // https://github.com/icones/collections-json/blob/master/collections.json
        $iconSets = Finder::collections();

        foreach ($iconSets as $prefix => $iconSet) {
            $model = new IconSet();

            $model->id = $prefix;
            $model->name = $iconSet['name'];
            $model->total = $iconSet['total'];


            $model->author = $iconSet['author']['name'];
            $model->url = $iconSet['author']['url'] ?? null;
            $model->license = $iconSet['license']['title'];
            $model->license_url = $iconSet['license']['url'] ?? null;
            $model->version = $iconSet['version'] ?? null;
            $model->samples = $iconSet['samples'] ?? null;
            $model->palette = $iconSet['palette'] ?? null;
            $model->category = $iconSet['category'] ?? null;
            $model->height = $iconSet['height'] ?? 16;
            $model->display_height = $iconSet['displayHeight'] ?? 24;

            $model->save();
        }
    }
}
