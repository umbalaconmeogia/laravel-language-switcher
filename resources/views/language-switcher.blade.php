<style>
/* Base Language Switcher Styles */
.language-switcher {
    position: relative;
    display: inline-block;
    font-family: Arial, sans-serif;
}

.language-switcher-button {
    background-color: #4a5568;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: background-color 0.2s;
}

.language-switcher-button:hover {
    background-color: #2d3748;
}

.language-switcher-arrow {
    font-size: 10px;
    transition: transform 0.2s;
}

.language-switcher:hover .language-switcher-arrow {
    transform: rotate(180deg);
}

.language-switcher-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background-color: white;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    list-style: none;
    padding: 4px 0;
    margin: 0;
    min-width: 120px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all 0.2s;
    z-index: 1000;
}

.language-switcher:hover .language-switcher-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.language-switcher-item {
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    padding: 6px 12px;
    cursor: pointer;
    color: #2d3748;
    font-size: 14px;
    transition: background-color 0.2s;
}

.language-switcher-item:hover {
    background-color: #f7fafc;
}

.language-switcher-item.active {
    background-color: #4299e1;
    color: white;
}

/* Minimal Style Variant */
.language-switcher.minimal .language-switcher-button {
    background: none;
    color: inherit;
    border: none;
    padding: 4px 8px;
    border-radius: 2px;
    font-size: inherit;
    gap: 4px;
}

.language-switcher.minimal .language-switcher-button:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.language-switcher.minimal .language-switcher-arrow {
    font-size: 8px;
}

.language-switcher.minimal .language-switcher-menu {
    min-width: 100px;
    padding: 2px 0;
}

.language-switcher.minimal .language-switcher-item {
    padding: 4px 8px;
    font-size: 13px;
}

/* Compact Style Variant */
.language-switcher.compact .language-switcher-button {
    padding: 6px 10px;
    font-size: 13px;
    gap: 4px;
}

.language-switcher.compact .language-switcher-arrow {
    font-size: 9px;
}

.language-switcher.compact .language-switcher-menu {
    min-width: 110px;
    padding: 3px 0;
}

.language-switcher.compact .language-switcher-item {
    padding: 5px 10px;
    font-size: 13px;
}
</style>

<div class="language-switcher {{ $style !== 'default' ? $style : '' }}">
    <button class="language-switcher-button">
        {{ $currentDisplayName }}
        <span class="language-switcher-arrow">▼</span>
    </button>
    <ul class="language-switcher-menu">
        @foreach($supportedLanguages as $code => $name)
            <li>
                <form method="POST" action="{{ route('language.switch', $code) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="language-switcher-item {{ $currentLanguage === $code ? 'active' : '' }}">
                        {{ $name }}
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
</div> 