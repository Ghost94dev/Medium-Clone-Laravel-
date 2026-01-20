@props(['user', 'size' => 'w-12 h-12'])

@if ($user->getFirstMedia('avatar'))
    <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="{{ $size }} rounded-full">
@else
    <img src="https://www.pngitem.com/pimgs/m/581-5813504_avatar-dummy-png-transparent-png.png" alt="Dummy avatar"
        class="{{ $size }} rounded-full">
@endif