<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes\Sorting;

use Illuminate\Support\Collection;

/**
 * Interface ISortable
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes\Sorting
 */
interface ISortable
{
    /**
     * @return Collection
     */
    public function getSorted(): Collection;
}