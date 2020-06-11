<?php
declare(strict_types=1);

namespace Admin\Services\StylistDesk\Stylist\Classes;

use Admin\Models\User;
use Admin\Models\Employee;
use Common\Services\Conversation\ConversationService;

/**
 * Class StylistAssigner
 *
 * @package Admin\Services\StylistDesk\Stylist\Classes
 */
class StylistAssigner
{
    private Employee $stylist;

    private User $customer;

    /**
     * StylistAssigner constructor.
     *
     * @param Employee $stylist
     * @param User     $customer
     */
    public function __construct(Employee $stylist, User $customer)
    {
        $this->stylist = $stylist;

        $this->customer = $customer;
    }

    /**
     * @return void
     */
    public function assignActiveStylistToCustomer(): void
    {
        (new ConversationService)->setActiveStylist($this->customer, $this->stylist);
    }
}