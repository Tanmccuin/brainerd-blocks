# Brainerd Blocks — Design System Reference

This document defines the shared conventions, tokens, and patterns used across
all Brainerd blocks. Follow these when building new blocks or extending existing
ones. AI assistants should read this before creating or modifying blocks.

## CSS tokens

### Colors (via `--tmd-*` custom properties)
All colors adapt to dark mode automatically.

| Token | Light mode | Dark mode | Use for |
|-------|-----------|-----------|---------|
| `--tmd-bg` | `#f5f0e6` cream | `#0b0b0d` | Page/section background |
| `--tmd-surf` | `#ffffff` white | `#131318` | Card/input surfaces |
| `--tmd-border` | `#e2d8cc` | `#1e1e28` | Borders, dividers |
| `--tmd-heading` | `#1a1612` ink | `#edeae3` | Headings, strong text |
| `--tmd-body` | `#4a4038` | `#7a7268` | Body text |
| `--tmd-muted` | `#9a8e82` | `#3e3a36` | Captions, labels, meta |
| `--tmd-accent` | `#e84d22` coral | `#e84d22` | CTAs, links, highlights |
| `--tmd-accent-dark` | `#c93d16` | `#ff5f34` | Hover states |
| `--tmd-accent-text` | `#ffffff` | `#ffffff` | Text on accent bg |

### Spacing (via `--wp--preset--spacing--*`)
| Token | Value | Use for |
|-------|-------|---------|
| `--spacing--40` | `1rem` | Inner component gaps |
| `--spacing--50` | `1.5rem` | Field/card spacing |
| `--spacing--60` | `2.5rem` | Section inline padding |
| `--spacing--70` | `4rem` | Section block padding |
| `--spacing--80` | `6rem` | Large section padding |

### Radii
| Token | Value |
|-------|-------|
| `--tmd-radius-sm` | `4px` — buttons, inputs |
| `--tmd-radius-md` | `8px` — small cards, images |
| `--tmd-radius-lg` | `10px` — large cards, panels |

### Typography
| Element | Font | Weight | Size |
|---------|------|--------|------|
| Body | Inter | 400 | `--font-size--base` (1rem) |
| Labels/meta | Inter | 500 | 0.8125rem, uppercase, 0.04em tracking |
| Headings | Fraunces | 700 | Per heading level |
| Buttons | Inter | 500 | 0.875rem–0.9375rem |

### Transitions
Always use `var(--tmd-transition)` (0.25s ease). Never add transitions without
a `prefers-reduced-motion` guard — use the global rule in the theme's style.css
or add per-block `@media (prefers-reduced-motion: reduce)` overrides.

## Block structure

Every block = one folder under `blocks/`:

```
blocks/my-block/
  block.json       # Registration
  render.php       # PHP template
  style.css        # Scoped styles
```

Plus an ACF field group in `acf-json/group_cb_my_block.json`.

### block.json template
```json
{
  "$schema": "https://schemas.wp.org/trunk/block.json",
  "apiVersion": 3,
  "name": "brainerd/my-block",
  "title": "My Block",
  "description": "Short description.",
  "category": "brainerd",
  "icon": "dashicon-name",
  "keywords": ["keyword1", "keyword2"],
  "acf": { "mode": "preview", "renderTemplate": "render.php" },
  "supports": { "align": ["wide", "full"], "anchor": true },
  "style": "file:./style.css",
  "textdomain": "brainerd"
}
```

### render.php template
```php
<?php
// 1. Get all fields into local vars
$heading = get_field('heading');
$items   = get_field('items');

// 2. Block wrapper
$block_id = !empty($block['anchor']) ? $block['anchor'] : 'cb-my-block-' . $block['id'];
$classes  = 'cb-my-block';
if (!empty($block['className'])) $classes .= ' ' . $block['className'];
if (!empty($block['align'])) $classes .= ' align' . $block['align'];

// 3. Preview fallbacks
if ($is_preview && empty($items)) {
    $items = [ /* sensible defaults */ ];
}

// 4. Output with escaping
?>
<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <!-- content -->
</section>
```

## Naming conventions

### CSS classes (BEM)
- Block wrapper: `cb-<block-name>` (e.g., `cb-testimonials`)
- Elements: `cb-<block>__<element>` (e.g., `cb-testimonials__card`)
- Modifiers: `cb-<block>__<element>--<modifier>` (e.g., `cb-testimonials__card--featured`)

### ACF fields
- Field name: snake_case (e.g., `section_heading`)
- Field key: `field_cb_<block-abbrev>_<field>` (e.g., `field_cb_test_section_heading`)
- Group key: `group_cb_<block-abbrev>` (e.g., `group_cb_test`)
- Repeater sub-fields use the same prefix

### Block abbreviations (for ACF keys)
Use 2-4 letter abbreviations to keep keys short:
- hero, sp (service-pillars), pg (portfolio-grid), pg2 (pricing-grid),
  cta (cta-band), cf (contact-form), test (testimonials), faq, stats,
  lc (logo-cloud), team, fl (feature-list)

## Section layout pattern

Most blocks follow this structure:

```css
.cb-my-block {
    background-color: var(--tmd-bg);
    padding-block: var(--wp--preset--spacing--70, 4rem);
    padding-inline: var(--wp--preset--spacing--60, 2.5rem);
}

.cb-my-block__inner {
    max-width: var(--wp--style--global--wide-size, 1200px);
    margin-inline: auto;
}
```

### Section header pattern
When a block has a heading + optional subtext:
```html
<div class="cb-my-block__header">
    <h2 class="cb-my-block__title">...</h2>
    <p class="cb-my-block__subtext">...</p>
</div>
```

### Card pattern
Repeater items rendered as cards:
```css
.cb-my-block__card {
    background: var(--tmd-surf);
    border: 1px solid var(--tmd-border);
    border-radius: var(--tmd-radius-lg);
    padding: 2rem 1.75rem;
    transition: border-color var(--tmd-transition);
}
.cb-my-block__card:hover {
    border-color: var(--tmd-muted);
}
```

### Grid pattern
```css
.cb-my-block__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

@media (max-width: 900px) {
    .cb-my-block__grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 560px) {
    .cb-my-block__grid { grid-template-columns: 1fr; }
}
```

## Human editability (mandatory)

Every block MUST be usable by a non-technical person in the WordPress editor
without AI assistance. The AI builds the block; the human maintains content
after handoff. This is non-negotiable.

### Rules for every block:
- **Every visible text** must come from an ACF field, not hardcoded in render.php.
  If the user can see it on the frontend, they must be able to change it in the editor.
- **Images** must come from ACF image/gallery fields or WordPress featured images.
  Never hardcode image paths in templates.
- **Icons** should use a select field (icon key map) so users can swap them from a
  dropdown, not by editing SVG code.
- **Colors** used as accents or highlights should inherit from theme tokens. If a block
  needs a per-instance color override, add a color picker field.
- **Links/buttons** should use ACF link fields (which give users a UI for URL, text,
  and target) — never hardcode URLs.
- **Conditional content** should use ACF true/false toggles with conditional logic
  to show/hide related fields (e.g., "Featured?" toggle shows badge text field).

### InnerBlocks for flexible areas
For blocks that benefit from freeform content (hero body, CTA extras, feature
descriptions), enable InnerBlocks:

1. Add `"jsx": true` to the block.json `supports` object
2. Add `<InnerBlocks />` in render.php where freeform content should appear
3. Wrap it in a styled container div for consistent spacing

This lets users drop core WordPress blocks (paragraphs, images, buttons, lists)
inside your custom block — without losing the block's structural layout.

Use InnerBlocks for: content-heavy areas, "extra content" zones, flexible body sections.
Do NOT use InnerBlocks for: repeater items, structured data, anything with a fixed schema.

### ACF field UX guidelines
- **Labels**: short, clear, no jargon. "Heading" not "Section H2 Text Override".
- **Instructions**: one sentence max. Use `placeholder` for format examples instead.
- **Wrapper widths**: use 50/50 or 33/33/33 splits to keep fields side-by-side and
  reduce vertical scrolling in the sidebar.
- **Conditional logic**: hide fields that aren't relevant. Don't show badge text if
  the featured toggle is off.
- **Repeater layout**: use `"layout": "block"` for complex sub-fields,
  `"layout": "table"` for simple 2-3 column data.
- **Field group titles**: short. "Hero" not "Block: Hero Section Configuration".

### mode: auto
All blocks use `"mode": "auto"` which shows the rendered preview by default.
Users click the block to switch to edit mode (inline fields). This gives both
a visual preview AND access to the fields without the sidebar cramping.

## Extending a block

When using AI to extend an existing block:

1. **Add fields** — edit the ACF JSON file, add new fields to the group
2. **Update render.php** — add `get_field()` calls and output markup
3. **Update style.css** — follow existing BEM naming, use tokens
4. **Maintain preview fallbacks** — keep the `$is_preview` defaults working
5. **Maintain human editability** — can the user change this value in the editor?
6. **Test dark mode** — if you used tokens, it should work automatically
7. **Test responsive** — check 380px and 1200px
8. **Check accessibility** — semantic HTML, ARIA where needed, focus states

## Accessibility checklist (per block)
- [ ] Semantic wrapper element (`<section>`, `<article>`, `<aside>`)
- [ ] Heading hierarchy makes sense in page context
- [ ] Interactive elements are `<button>` or `<a>`, not `<div>` with click handlers
- [ ] Focus states visible (inherited from theme `:focus-visible` rule)
- [ ] Color contrast meets WCAG AA
- [ ] `aria-hidden="true"` on decorative elements (icons, separators)
- [ ] `prefers-reduced-motion` respected for any animations
- [ ] All visible content editable by the user in the block editor
