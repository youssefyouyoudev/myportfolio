@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-[var(--text-strong)] leading-tight">
        {{ __('Profile') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="shell space-y-6">
            <div class="surface p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="surface p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="surface p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
