<?php

namespace App\Livewire\Navigation;

use Livewire\Component;

class Admin extends Component
{
    public string $activeTab = ''; // Initial active tab
    public int $width = 0; // Initial width

    public function render()
    {
        return view('livewire.navigation.admin');
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setActiveTab($tab)
    {
        if (str_contains($tab, 'book'))
            $this->activeTab = 'book';
        else if (str_contains($tab, 'category'))
            $this->activeTab = 'category';
        else if (str_contains($tab, 'customer'))
            $this->activeTab = 'customer';
        else if (str_contains($tab, 'coupon'))
            $this->activeTab = 'coupon';
        else if (str_contains($tab, 'request'))
            $this->activeTab = 'request';
        else if (str_contains($tab, 'statistic'))
            $this->activeTab = 'request';
        else if (str_contains($tab, 'profile'))
            $this->activeTab = 'profile';
        else if (str_contains($tab, 'authentication'))
            $this->activeTab = 'authentication';
        else if (!str_contains($tab, 'about-us') && !str_contains($tab, 'privacy-policy') && !str_contains($tab, 'terms-of-service') && !str_contains($tab, 'discount-program'))
            $this->activeTab = 'home';
    }
}
