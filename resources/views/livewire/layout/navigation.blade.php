<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<flux:header container class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-3" inset="left"/>

    <flux:navbar class="max-lg:hidden ml-6">
        <flux:navbar.item icon="home"
                          :current="request()->routeIs('arrangements.*')"
                          href="{{ route('arrangements.index') }}">
            {{ __('Arrangements')}}
        </flux:navbar.item>
    </flux:navbar>

    <flux:spacer/>

    <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" />

    <flux:dropdown class="max-lg:hidden">
        <flux:navbar.item icon-trailing="chevron-down">
            <span x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                  x-text="name" x-on:profile-updated.window="name = $event.detail.name"></span>
        </flux:navbar.item>
        <flux:navmenu>
            <flux:navmenu.item icon="user" href="{{route('profile')}}" wire:navigate>
                {{__('Profile')}}
            </flux:navmenu.item>
            <flux:navmenu.item icon="arrow-right-end-on-rectangle" wire:click="logout()">
                {{__('Log out')}}
            </flux:navmenu.item>
        </flux:navmenu>
    </flux:dropdown>

    <flux:sidebar stashable sticky
                  class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

        <flux:navlist variant="outline">
            <flux:navlist.item icon="home"
                               :current="request()->routeIs('arrangements.*')"
                               href="{{ route('arrangements.index') }}">
                {{__('Arrangements')}}
            </flux:navlist.item>
        </flux:navlist>

        <flux:spacer/>

        <flux:navlist variant="outline">
            <flux:navlist.item icon="user"
                               :current="request()->routeIs('profile')"
                               href="{{ route('profile') }}" wire:navigate>
                {{__('Profile')}}
            </flux:navlist.item>
            <flux:navlist.item icon="arrow-right-end-on-rectangle" wire:click="logout()">
                {{__('Log out')}}
            </flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>
</flux:header>
