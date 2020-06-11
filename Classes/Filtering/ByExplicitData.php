<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes\Filtering;

use Admin\Models\Employee;
use Illuminate\Support\Collection;

/**
 * Class ByExplicitData
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes\Filtering
 */
class ByExplicitData implements IFilterable
{
    private Collection $stylists;

    private Collection $filteredStylists;

    private Collection $excludedStylists;

    /**
     * ByExplicitData constructor.
     *
     * @param Collection $stylists
     * @param Collection $excludedStylists
     */
    public function __construct(Collection $stylists, Collection $excludedStylists)
    {
        $this->stylists = $stylists;

        $this->excludedStylists = $excludedStylists;

        $this->filter();
    }

    /**
     * @return Collection
     */
    public function getFiltered(): Collection
    {
        return $this->filteredStylists;
    }

    /**
     * @return void
     */
    private function filter(): void
    {
        $this->filteredStylists = $this->stylists->reject(function (Employee $stylist) {
            return $this->excludedStylists->contains($stylist);
        });
    }
}