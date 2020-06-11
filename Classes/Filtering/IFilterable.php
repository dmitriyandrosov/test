<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes\Filtering;

use Illuminate\Support\Collection;

/**
 * Interface IFilterable
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes\Filtering
 */
interface IFilterable
{
    /**
     * @return Collection
     */
    public function getFiltered(): Collection;
}