<?php

namespace App\TechDiary;

use App\Models\Meta;

/**
 * Model mata data utility
 */
trait HasMetaData
{
    public function meta()
    {
        return $this->morphMany(Meta::class, 'metable');
    }

    /**
     * Get meta value by using unique key
     * @param $key String meta key name
     */
    public function getMetaValue($key)
    {
        $meta = $this->meta()
            ->where('key', $key)
            ->first();

        if(!$meta) return null;

        return $meta->value;
    }

    /**
     * Get meta json data by using unique key
     * @param $key Unique meta key name
     */
    public function getMetaJSON($key)
    {
        $meta = $this->meta()
            ->where('key', $key)
            ->first();

        if(!$meta) return null;

        return json_decode($meta->json_payload);
    }

    /**
     * Set meta value with a key
     * @param $key
     * @param $data
     * return void
     */
    public function setMetaValue($key, $data)
    {
        if (!$data) return null;

        $this->meta()->updateOrCreate(
            ["key" => $key],
            ["value" => $data]
        );
    }

    /**
     * Set meta json payload with a key
     * @param $key
     * @param $data
     * return void
     */
    public function setMetaJSON($key, $data)
    {
        if (!$data) return null;

        $this->meta()->updateOrCreate(
            ["key" => $key],
            ["json_payload" => json_encode($data)]
        );
    }

}
