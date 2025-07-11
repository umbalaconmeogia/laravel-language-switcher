# CSS Customization Guide

The Laravel Language Switcher Package is designed to be CSS framework independent. This guide explains how to customize the styling to match your application's design.

## CSS Independence

The package uses semantic CSS classes that are not tied to any specific CSS framework:

- **No Tailwind CSS dependency**
- **No Bootstrap dependency**
- **No other framework dependencies**

This allows you to use the package with any CSS framework or custom styling.

## Available CSS Classes

### Main Container
```css
.language-switcher
```
- Main wrapper for the language switcher
- Controls positioning and layout

### Trigger Button
```css
.language-switcher-button
```
- The button that opens the language dropdown
- Contains current language text and arrow

### Current Language
```css
.language-switcher-current
```
- Text showing the currently selected language
- Can be styled independently

### Dropdown Arrow
```css
.language-switcher-arrow
```
- Container for the dropdown arrow icon
- Can be hidden or styled as needed

### Language Options
```css
.language-switcher-item
```
- Individual language option buttons in the dropdown
- Each button represents a language choice

### Form Container
```css
.language-switcher-form
```
- Wrapper for each language option form
- Controls layout of individual options

## Style Variants

The package includes three built-in style variants:

### 1. Default Style
```blade
<x-language-switcher::language-switcher />
```
- Full-featured dropdown with arrow
- Standard padding and sizing
- Hover and focus states

### 2. Minimal Style
```blade
<x-language-switcher::language-switcher style="minimal" />
```
- Compact design
- No arrow icon
- Minimal padding
- Clean, simple appearance

### 3. Compact Style
```blade
<x-language-switcher::language-switcher style="compact" />
```
- Smaller than default
- Reduced padding
- Maintains arrow icon
- Good for space-constrained layouts

## Using the Provided CSS

### 1. Publish the CSS File
```bash
php artisan vendor:publish --provider="Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider" --tag="language-switcher-css"
```

### 2. Include in Your Application
Add the CSS file to your main stylesheet or include it directly:

```html
<link rel="stylesheet" href="{{ asset('css/vendor/language-switcher/language-switcher.css') }}">
```

Or import it in your main CSS file:
```css
@import 'vendor/language-switcher/language-switcher.css';
```

## Custom Styling Examples

### 1. Bootstrap-Style
```css
.language-switcher-button {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.language-switcher-button:hover {
    color: #212529;
    background-color: #f8f9fa;
    border-color: #86b7fe;
}

.language-switcher-item {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: transparent;
    border: 0;
    border-radius: 0.375rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
}

.language-switcher-item:hover {
    color: #212529;
    background-color: #f8f9fa;
}
```

### 2. Material Design Style
```css
.language-switcher-button {
    display: inline-flex;
    align-items: center;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 500;
    color: #1976d2;
    background-color: transparent;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.language-switcher-button:hover {
    background-color: rgba(25, 118, 210, 0.04);
}

.language-switcher-item {
    display: block;
    width: 100%;
    padding: 12px 16px;
    font-size: 14px;
    color: rgba(0, 0, 0, 0.87);
    background-color: transparent;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.language-switcher-item:hover {
    background-color: rgba(0, 0, 0, 0.04);
}
```

### 3. Dark Theme
```css
.language-switcher {
    --bg-color: #1a1a1a;
    --text-color: #ffffff;
    --hover-bg: #333333;
    --border-color: #444444;
}

.language-switcher-button {
    background-color: var(--bg-color);
    color: var(--text-color);
    border: 1px solid var(--border-color);
    border-radius: 4px;
    padding: 8px 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.language-switcher-button:hover {
    background-color: var(--hover-bg);
    border-color: #666666;
}

.language-switcher-menu {
    background-color: var(--bg-color);
    border: 1px solid var(--border-color);
    border-radius: 4px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
}

.language-switcher-item {
    color: var(--text-color);
    background-color: transparent;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.language-switcher-item:hover {
    background-color: var(--hover-bg);
}

.language-switcher-item.active {
    background-color: #1976d2;
    color: white;
}
```

### 4. Minimalist Style
```css
.language-switcher {
    position: relative;
    display: inline-block;
}

.language-switcher-button {
    background: none;
    border: none;
    color: inherit;
    font-size: inherit;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 2px;
    transition: background-color 0.2s ease;
}

.language-switcher-button:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.language-switcher-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    min-width: 120px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-4px);
    transition: all 0.2s ease;
}

.language-switcher:hover .language-switcher-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.language-switcher-item {
    display: block;
    width: 100%;
    padding: 6px 12px;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
    color: #333;
    font-size: 14px;
    transition: background-color 0.2s ease;
}

.language-switcher-item:hover {
    background-color: #f5f5f5;
}

.language-switcher-item.active {
    background-color: #e3f2fd;
    color: #1976d2;
    font-weight: 500;
}
```

### 5. Flag-Based Style
```css
.language-switcher {
    position: relative;
    display: inline-block;
}

.language-switcher-button {
    display: flex;
    align-items: center;
    gap: 8px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 6px 12px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.language-switcher-button:hover {
    border-color: #999;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.language-flag {
    width: 20px;
    height: 15px;
    border-radius: 2px;
    background-size: cover;
    background-position: center;
}

.flag-en {
    background-image: url('/images/flags/en.png');
}

.flag-ja {
    background-image: url('/images/flags/ja.png');
}

.flag-vi {
    background-image: url('/images/flags/vi.png');
}

.language-switcher-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    min-width: 140px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all 0.2s ease;
}

.language-switcher:hover .language-switcher-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.language-switcher-item {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    padding: 8px 12px;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
    color: #333;
    font-size: 14px;
    transition: background-color 0.2s ease;
}

.language-switcher-item:hover {
    background-color: #f8f9fa;
}

.language-switcher-item.active {
    background-color: #e3f2fd;
    color: #1976d2;
    font-weight: 500;
}
```

## Responsive Design

### Mobile-First Approach
```css
.language-switcher {
    position: relative;
    display: inline-block;
}

/* Mobile styles */
@media (max-width: 768px) {
    .language-switcher-button {
        padding: 8px;
        font-size: 14px;
    }
    
    .language-switcher-menu {
        position: fixed;
        top: auto;
        bottom: 20px;
        right: 20px;
        left: 20px;
        min-width: auto;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }
    
    .language-switcher-item {
        padding: 12px 16px;
        font-size: 16px;
    }
}

/* Tablet styles */
@media (min-width: 769px) and (max-width: 1024px) {
    .language-switcher-button {
        padding: 6px 10px;
        font-size: 15px;
    }
}

/* Desktop styles */
@media (min-width: 1025px) {
    .language-switcher-button {
        padding: 8px 12px;
        font-size: 16px;
    }
}
```

## Accessibility

### ARIA Attributes
```css
/* Ensure proper contrast ratios */
.language-switcher-button {
    color: #333;
    background-color: #fff;
    border: 1px solid #ccc;
}

.language-switcher-button:hover,
.language-switcher-button:focus {
    color: #000;
    background-color: #f0f0f0;
    border-color: #999;
}

/* Focus indicators */
.language-switcher-button:focus {
    outline: 2px solid #007acc;
    outline-offset: 2px;
}

.language-switcher-item:focus {
    outline: 2px solid #007acc;
    outline-offset: -2px;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .language-switcher-button {
        border-width: 2px;
    }
    
    .language-switcher-item {
        border-bottom: 1px solid #000;
    }
}
```

## Animation and Transitions

### Smooth Dropdown Animation
```css
.language-switcher-menu {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.language-switcher:hover .language-switcher-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

/* Staggered animation for menu items */
.language-switcher-item {
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.2s ease;
    transition-delay: calc(var(--item-index) * 0.05s);
}

.language-switcher:hover .language-switcher-item {
    opacity: 1;
    transform: translateX(0);
}
```

## Integration with Popular Frameworks

### Tailwind CSS
```css
/* Custom Tailwind classes */
.language-switcher {
    @apply relative inline-block;
}

.language-switcher-button {
    @apply flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
}

.language-switcher-menu {
    @apply absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-md shadow-lg min-w-[120px] z-50;
}

.language-switcher-item {
    @apply block w-full px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:bg-gray-100 focus:outline-none;
}

.language-switcher-item.active {
    @apply bg-indigo-50 text-indigo-700;
}
```

### Bootstrap
```css
/* Bootstrap-compatible styles */
.language-switcher-button {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.language-switcher-button:hover {
    color: #212529;
    background-color: #f8f9fa;
    border-color: #86b7fe;
}

.language-switcher-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.175);
    border-radius: 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    min-width: 120px;
    z-index: 1000;
}

.language-switcher-item {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: transparent;
    border: 0;
    border-radius: 0.375rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
}

.language-switcher-item:hover {
    color: #212529;
    background-color: #f8f9fa;
}

.language-switcher-item.active {
    color: #fff;
    background-color: #0d6efd;
}
```

This comprehensive CSS guide should help you customize the language switcher to match any design system or framework you're using in your Laravel application. 