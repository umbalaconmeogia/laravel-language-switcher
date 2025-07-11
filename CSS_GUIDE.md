# CSS Customization Guide

The Laravel Multilingual Package is designed to be CSS framework independent. This guide explains how to customize the styling to match your application's design.

## CSS Independence

The package uses semantic CSS classes that are not tied to any specific CSS framework:

- **No Tailwind CSS dependency**
- **No Bootstrap dependency**
- **No other framework dependencies**

This allows you to use the package with any CSS framework or custom styling.

## Available CSS Classes

### Main Container
```css
.multilingual-language-switcher
```
- Main wrapper for the language switcher
- Controls positioning and layout

### Trigger Button
```css
.multilingual-trigger
```
- The button that opens the language dropdown
- Contains current language text and arrow

### Current Language
```css
.multilingual-current
```
- Text showing the currently selected language
- Can be styled independently

### Dropdown Arrow
```css
.multilingual-arrow
```
- Container for the dropdown arrow icon
- Can be hidden or styled as needed

### Language Options
```css
.multilingual-option
```
- Individual language option buttons in the dropdown
- Each button represents a language choice

### Form Container
```css
.multilingual-form
```
- Wrapper for each language option form
- Controls layout of individual options

## Style Variants

The package includes three built-in style variants:

### 1. Default Style
```blade
<x-multilingual::language-switcher />
```
- Full-featured dropdown with arrow
- Standard padding and sizing
- Hover and focus states

### 2. Minimal Style
```blade
<x-multilingual::language-switcher style="minimal" />
```
- Compact design
- No arrow icon
- Minimal padding
- Clean, simple appearance

### 3. Compact Style
```blade
<x-multilingual::language-switcher style="compact" />
```
- Smaller than default
- Reduced padding
- Maintains arrow icon
- Good for space-constrained layouts

## Using the Provided CSS

### 1. Publish the CSS File
```bash
php artisan vendor:publish --provider="App\Packages\LaravelMultilingual\MultilingualServiceProvider" --tag=multilingual-css
```

### 2. Include in Your Application
Add the CSS file to your main stylesheet or include it directly:

```html
<link rel="stylesheet" href="{{ asset('css/vendor/multilingual/multilingual.css') }}">
```

Or import it in your main CSS file:
```css
@import 'vendor/multilingual/multilingual.css';
```

## Custom Styling Examples

### 1. Bootstrap-Style
```css
.multilingual-trigger {
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

.multilingual-trigger:hover {
    color: #212529;
    background-color: #f8f9fa;
    border-color: #86b7fe;
}

.multilingual-option {
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

.multilingual-option:hover {
    color: #212529;
    background-color: #f8f9fa;
}
```

### 2. Material Design Style
```css
.multilingual-trigger {
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

.multilingual-trigger:hover {
    background-color: rgba(25, 118, 210, 0.04);
}

.multilingual-option {
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

.multilingual-option:hover {
    background-color: rgba(0, 0, 0, 0.04);
}
```

### 3. Dark Theme
```css
.multilingual-language-switcher {
    --bg-color: #1a1a1a;
    --text-color: #ffffff;
    --hover-bg: #333333;
    --border-color: #444444;
}

.multilingual-trigger {
    background-color: var(--bg-color);
    color: var(--text-color);
    border: 1px solid var(--border-color);
}

.multilingual-trigger:hover {
    background-color: var(--hover-bg);
}

.multilingual-option {
    color: var(--text-color);
    background-color: var(--bg-color);
}

.multilingual-option:hover {
    background-color: var(--hover-bg);
}
```

### 4. Minimalist Style
```css
.multilingual-trigger {
    background: none;
    border: none;
    padding: 4px 8px;
    font-size: 14px;
    color: #666;
    cursor: pointer;
}

.multilingual-trigger:hover {
    color: #333;
}

.multilingual-arrow {
    display: none;
}

.multilingual-option {
    padding: 8px 12px;
    font-size: 14px;
    color: #666;
    background: none;
    border: none;
    cursor: pointer;
    text-align: left;
}

.multilingual-option:hover {
    background-color: #f5f5f5;
    color: #333;
}
```

## Responsive Design

The provided CSS includes responsive design considerations:

```css
/* Mobile Responsive */
@media (max-width: 640px) {
    .multilingual-trigger {
        padding: 0.375rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .multilingual-option {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }
}
```

## Accessibility

The CSS includes accessibility features:

- **Focus states** for keyboard navigation
- **Hover states** for mouse interaction
- **Proper contrast ratios**
- **Touch-friendly sizing** on mobile

## Integration with CSS Frameworks

### Tailwind CSS
If you're using Tailwind CSS, you can apply utility classes:

```blade
<div class="multilingual-language-switcher">
    <x-multilingual::language-switcher />
</div>
```

```css
/* Override with Tailwind utilities */
.multilingual-trigger {
    @apply inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150;
}
```

### Bootstrap
For Bootstrap integration:

```css
.multilingual-trigger {
    @extend .btn;
    @extend .btn-outline-secondary;
}

.multilingual-option {
    @extend .dropdown-item;
}
```

## Best Practices

1. **Use CSS Custom Properties** for easy theming
2. **Maintain accessibility** with proper focus states
3. **Test on mobile devices** for touch-friendly sizing
4. **Consider dark mode** support
5. **Keep styles minimal** to avoid conflicts

## Troubleshooting

### Styles Not Applying
- Ensure the CSS file is properly loaded
- Check for CSS specificity conflicts
- Verify class names are correct

### Layout Issues
- Check if parent containers have proper positioning
- Ensure dropdown positioning works with your layout
- Test responsive behavior

### Framework Conflicts
- Use more specific selectors if needed
- Consider using `!important` sparingly
- Test with your specific CSS framework 