<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes;

use Admin\Models\Employee;
use Illuminate\Support\Collection;

/**
 * Class StylistPicker
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes
 */
class StylistPicker
{
    private Collection $excludedStylists;

    private Collection $loadedStylists;

    private Collection $filteredStylists;

    private Collection $sortedStylists;

    /**
     * @param Collection $stylists
     *
     * @return $this
     */
    public function setExcludedStylists(Collection $stylists): self
    {
        $this->excludedStylists = $stylists;

        return $this;
    }

    /**
     * @return Employee|null
     */
    public function getTopStylist(): ?Employee
    {
        $this->loadStylists();
        $this->filterStylists();
        $this->sortStylists();

        return $this->sortedStylists->first();
    }

    /**
     * @return void
     */
    private function loadStylists(): void
    {
        $this->loadedStylists = (new StylistLoader)->getActiveStylists();
    }

    /**
     * @return void
     */
    private function filterStylists(): void
    {
        $this->filteredStylists = (new StylistFilterer($this->loadedStylists))
            ->setExcludedStylists($this->excludedStylists)
            ->getFiltered();
    }

    /**
     * @return void
     */
    private function sortStylists(): void
    {
        $this->sortedStylists = (new StylistSorter($this->filteredStylists))->getSorted();
    }
}