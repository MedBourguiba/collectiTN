<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class StarRatingTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return [
            'rating' => $value,
            'stars' => str_repeat('★', $value) . str_repeat('☆', 5 - $value),
        ];
    }

    public function reverseTransform($value)
    {
        return $value['rating'];
    }
}
