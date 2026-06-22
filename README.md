# Br*ai*nerd Blocks

ACF-powered Gutenberg block library for the [Brainerd Theme](https://github.com/tanmccuin/brainerd-theme). 13 ready-to-use blocks. Each is a self-contained folder — drop it in, get a block.

> **Pre-alpha** — under active development.

## The ecosystem

| Package | Role | Repo |
|---------|------|------|
| **Brainerd Theme** | FSE shell — tokens, templates, base styles | [brainerd-theme](https://github.com/tanmccuin/brainerd-theme) |
| **Brainerd Blocks** | ACF Gutenberg block library | This repo |
| **Brainerd Companion** | Config system, plugin detection, integrations | [brainerd-companion](https://github.com/tanmccuin/brainerd-companion) |

## Requirements

- WordPress 6.4+
- PHP 8.0+
- [ACF Pro](https://www.advancedcustomfields.com/pro/)

## Blocks (13)

| Block | Slug | Description |
|-------|------|-------------|
| Hero | `brainerd/hero` | Split layout — text + mosaic image grid with parallax |
| Service Pillars | `brainerd/service-pillars` | Icon + heading + body + link cards |
| Portfolio Grid | `brainerd/portfolio-grid` | Dynamic WP_Query grid with contained cards |
| Pricing Grid | `brainerd/pricing-grid` | Tier cards with featured highlight + conditional badge |
| CTA Band | `brainerd/cta-band` | Full-width call-to-action with InnerBlocks |
| Contact Form | `brainerd/contact-form` | Native HTML form with honeypot spam protection |
| Testimonials | `brainerd/testimonials` | Quote cards — grid or single column layout |
| FAQ Accordion | `brainerd/faq-accordion` | Native `<details>`/`<summary>` — zero JavaScript |
| Stats | `brainerd/stats` | Metric cards with prefix/suffix (e.g. "20+ Years") |
| Logo Cloud | `brainerd/logo-cloud` | Grayscale logo grid, color on hover |
| Team Grid | `brainerd/team-grid` | Photo + name + role + social links |
| Feature List | `brainerd/feature-list` | Stacked or alternating icon + text rows with InnerBlocks |
| Feature Grid | `brainerd/feature-grid` | Simple icon + text grid (legacy) |

## Adding a block

```
blocks/my-block/
  block.json       # name: brainerd/my-block, category: brainerd
  render.php       # PHP template — get_field() + escaping
  style.css        # Scoped styles using --tmd-* tokens
```

Plus `acf-json/group_cb_my_block.json` for the field group.

Auto-registered — no plugin code edits needed. See [SYSTEM.md](SYSTEM.md) for the full design system reference.

## Key principles

- **Human editable** — every visible text, image, icon, and link comes from an ACF field. Users maintain content without AI.
- **`mode: auto`** — blocks show a visual preview, click to edit inline fields.
- **InnerBlocks** — hero, CTA band, and feature list support nested core blocks for flexible content.
- **Conditional logic** — fields show/hide based on toggles (e.g., pricing badge text only appears when "Featured" is on).
- **Tokens over hardcoded values** — `var(--tmd-*)` everywhere so blocks adapt to any palette + dark mode.

## Conventions

- **CSS classes:** `cb-<block>`, `cb-<block>__<element>` (BEM)
- **ACF keys:** `field_cb_<abbrev>_<field>`, group `group_cb_<abbrev>`
- **Escaping:** `esc_html` / `esc_url` / `esc_attr` / `wp_kses_post`
- **Icons:** select field → key map in render.php (not raw SVG in content)

## Key docs

| File | Purpose |
|------|---------|
| `SYSTEM.md` | Design system — tokens, patterns, naming, human editability rules, a11y checklist |
| `README.md` | This file |

## License

GPL-2.0-or-later
