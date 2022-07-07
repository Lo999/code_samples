<div x-data="{editing : false}">
    <div x-show="!editing" x-transition:enter.duration.500ms class="flex flex-col justify-between bg-cream
            border-2 border-orange">
        <div class="flex flex-col justify-center items-center px-8 py-8">
            <div class="flex w-8 h-8">
                <x-application-logo></x-application-logo>
            </div>
            <p class="text-center font-serif text-gray-700">
                {{ $registration->badge_name }}
            </p>
            <p class="text-center font-serif text-gray-700">
                {{ $registration->badge_institution }}
            </p>
        </div>

        <div class="flex justify-end">
            <div x-on:click="editing=true">
                <x-button :color="'orange'" class="mb-2 mx-2">Edit</x-button>
            </div>
        </div>
    </div>

    <div x-cloak x-show="editing" x-transition:enter.duration.500ms>
        <div class="flex flex-col justify-between bg-cream border-2 border-orange">
            <div class="flex flex-col justify-center items-center px-8 py-8">
                <div class="text-center font-serif text-gray-700">
                    <input wire:model="registration.badge_name" type="text" name="badge_name" value="{{
            $registration->badge_name }}">
                </div>
                <div class="text-center font-serif text-gray-700">
                    <input wire:model="registration.badge_institution" type="text" name="badge_institution" value="{{
            $registration->badge_institution }}">
                </div>
            </div>
            <div class="flex justify-end">
                <div wire:click="update" x-on:click="editing=false">
                    <x-button :color="'orange'" class="mb-2 ml-2">Submit</x-button>
                </div>
                <div x-on:click="editing=false">
                    <x-button :color="'orange'" class="mb-2 mx-2">Cancel</x-button>
                </div>
            </div>
        </div>
    </div>
</div>


