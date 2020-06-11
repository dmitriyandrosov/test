<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes;

use Admin\Models\Employee;
use Illuminate\Support\Collection;

/**
 * Class StylistLoader
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes
 */
class StylistLoader
{
    private Collection $stylists;

    /**
     * StylistLoader constructor.
     */
    public function __construct()
    {
        $this->fetchStylists();
    }

    /**
     * @return Collection
     */
    public function getActiveStylists(): Collection
    {
        return $this->stylists;
    }

    /**
     * @return void
     */
    private function fetchStylists(): void
    {
        $this->stylists = Employee::stylist()
            ->active()
            ->with('members')
            ->get();
    }
}