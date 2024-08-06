<div class="modal-content" x-data="{ option: 1 }">
    <div class="modal-header">
        <div>
            <h2 class="modal-title fs-5">Customer Detail</h2>
            <div class='d-flex overflow-x-auto mt-3'>
                <input type="radio" class='btn-check' id='select-personal-info' name='select-tab' x-on:click="option=1">
                <label for='select-personal-info' class="pointer hover-tab text-nowrap"
                    :class="option === 1 ? 'selected' : ''">Personal
                    Information</label>
                <input type="radio" class='btn-check' id='select-purchases' name='select-tab' x-on:click="option=2">
                <label for='select-purchases' class="ms-4 pointer hover-tab text-nowrap"
                    :class="option === 2 ? 'selected' : ''">Purchases</label>
                <input type="radio" class='btn-check' id='select-password' name='select-tab' x-on:click="option=3">
                <label for='select-password' class="ms-4 pointer hover-tab text-nowrap"
                    :class="option === 3 ? 'selected' : ''">Change Password</label>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body d-flex flex-column">
        <div class='d-flex w-100 h-100 flex-column'>
            <div x-show="option===1">
                @livewire('admin.manage.customer.customer-personal-form', ['customerID' => $selectedCustomer])
            </div>
            <div x-show="option===2">
                @livewire('admin.manage.customer.customer-order', ['customerID' => $selectedCustomer])
            </div>
            <div x-show="option===3">
                @livewire('admin.manage.customer.customer-password-form', ['customerID' => $selectedCustomer])
            </div>
        </div>
    </div>
</div>
