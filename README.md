# Br*ai*nerd Blocks

ACF-powered Gutenberg block library for the [Brainerd Theme](https://github.com/tanmccuin/brainerd-theme). Each block is a self-contained folder — drop it in, get a block. No plugin code edits needed.

> **Status:** Pre-alpha (v0.1.0-alpha). Under active development.

## Requirements

- WordPress 6.4+ (tested up to 7.0)
- PHP 8.0+
- [ACF Pro](https://www.advancedcustomfields.com/pro/)
- [Brainerd Theme](https://github.com/tanmccuin/brainerd-theme) (recommended, works with any theme that defines `--tmd-*` tokens)

## Included blocks

| Block | Slug | Description |
|-------|------|-------------|
| **Hero** | `brainerd/hero` | Split layout — text + overlapping mosaic image grid with parallax |
| **Service Pillars** | `brainerd/service-pillars` | Repeater of icon + heading + body + link cards |
| **Portfolio Grid** | `brainerd/portfolio-grid` | Dynamic WP_Query grid of portfolio CPT entries |
| **Pricing Grid** | `brainerd/pricing-grid` | Responsive pricing tier cards with featured highlight |
| **CTA Band** | `brainerd/cta-band` | Full-width call-to-action section |
| **Contact Form** | `brainerd/contact-form` | Native HTML form with honeypot spam protection |

## Adding a block

Create a folder in `blocks/`:

```
blocks/my-block/
  block.json       # apiVersion 3, name: brainerd/my-block, category: brainerd
  render.php       # PHP render template — get_field() + escaping
  style.css        # Scoped styles using --tmd-* / --wp--preset--* tokens
```

Add an ACF field group in `acf-json/group_cb_my_block.json` with location targeting `block == brainerd/my-block`.

The plugin auto-registers any folder containing a `block.json`. No edits to `plugin.php` needed.

## Conventions

- **Class names:** `cb-<block>`, `cb-<block>__<element>` (BEM)
- **Field keys:** `field_cb_<block>_<field>`, group key `group_cb_<block>`
- **Escaping:** `esc_html` / `esc_url` / `esc_attr` always. Rich text via `wp_kses_post`
- **Preview fallbacks:** provide defaults under `if ( $is_preview )` so blocks look good in the editor
- **Tokens over hardcoded values:** use `var(--tmd-*)` and `var(--wp--preset--*)` so blocks adapt to any theme palette

## Icon map

The service-pillars block uses an icon key system instead of raw SVG in block data. Available keys: `design`, `hosting`, `consult`, `a11y`. Add new icons to the `$icon_map` array in `blocks/service-pillars/render.php`.

## License

GPL-2.0-or-later
