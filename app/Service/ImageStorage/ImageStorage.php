<?php

namespace App\Service\ImageStorage;

interface ImageStorage
{
    /**
     * @param string $image
     * @return string filename
     */
    public function upload(string $image): string;
}
