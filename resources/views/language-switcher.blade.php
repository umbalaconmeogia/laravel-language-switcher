<div class="multilingual-language-switcher {{ $style !== 'default' ? $style : '' }}">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="multilingual-trigger">
                <span class="multilingual-current">{{ $currentDisplayName }}</span>
                <span class="multilingual-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </span>
            </button>
        </x-slot>

        <x-slot name="content">
            @foreach($supportedLanguages as $code => $name)
                @if($code !== $currentLanguage)
                    <form method="POST" action="{{ route('language.switch', $code) }}" class="multilingual-form">
                        @csrf
                        <button type="submit" class="multilingual-option">
                            {{ $name }}
                        </button>
                    </form>
                @endif
            @endforeach
        </x-slot>
    </x-dropdown>
</div> 