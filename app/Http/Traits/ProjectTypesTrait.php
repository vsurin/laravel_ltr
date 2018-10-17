<?php

namespace App\Http\Traits;

trait ProjectTypesTrait
{
    /**
     * Get types
     *
     * @return array
     */
    public function getTypes()
    {
        return [
            'Work' => 'Work',
            'Book' => 'Book',
            'Course' => 'Course',
            'Blog' => 'Blog',
            'Other' => 'Other'
        ];
    }
}