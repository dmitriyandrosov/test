<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes\Sorting;

use Admin\Models\Employee;
use Illuminate\Support\Collection;

/**
 * Class ByRank
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes\Sorting
 */
class ByRank implements ISortable
{
    private Collection $stylists;

    private Collection $sortedStylists;

    /**
     * ByRank constructor.
     *
     * @param Collection $stylists
     */
    public function __construct(Collection $stylists)
    {
        $this->stylists = $stylists;

        $this->sort();
    }

    /**
     * @return Collection
     */
    public function getSorted(): Collection
    {
        return $this->sortedStylists;
    }

    /**
     * @return void
     */
    private function sort(): void
    {
        $this->sortedStylists = $this->stylists->sort(function (Employee $stylistA, Employee $stylistB) {
            $stylistARank = $stylistA->rank;
            $stylistBRank = $stylistB->rank;

            if ($stylistARank === $stylistBRank) {
                return 0;
            }

            return $stylistARank > $stylistBRank ? 1 : -1;
        });
    }
}