@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-[var(--text-strong)] leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="shell">
            <div class="surface overflow-hidden">
                <div class="p-6 text-[var(--text)]">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
@endsection
