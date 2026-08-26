# Background images

The home-page hero (`resources/views/home.blade.php`) layers two of these:

- `bg1.jpeg` — base plate, `z-10`, slow Ken Burns zoom-out on load.
- `bg2.jpeg` — reveal plate, `z-30`, visible only inside the soft circular
  spotlight that trails the cursor (`initHeroSpotlight` in `resources/js/app.js`).
- `section2.jpg` — background of the competition-overview panel, behind a dark
  scrim (the photograph is bright daylight and the copy is white).
- `Smartbuildings.jpg` — artwork for the *Smart buildings and connected
  infrastructure* highlight slide.
- `bg3.png` — NSBM campus cutout with a transparent sky. Currently unused.

## Highlight slides

The Smart Green City carousel looks for artwork per pillar in
`public/assets/img/highlights/`, named after the slug of the pillar title —
`smart-energy-and-efficient-resource-use.jpg`, and so on (`.jpg`, `.jpeg`,
`.png` and `.webp` are all checked). Drop a file in and the slide picks it up;
without one the slide falls back to a duotone gradient and its icon. The mapping
lives in `HomeController::highlightImage()`.

All eight files currently in that folder are AI-generated placeholders (Higgsfield
`z_image`, 3:4, resized to 800px wide and saved as JPEG). They are stand-ins for
real NSBM photography, not pictures of the actual campus — replace them before
production. `Smartbuildings.jpg` at the root of this folder's parent is the one
supplied photograph.

Both hero plates are `bg-cover bg-center`, so use large landscape-safe crops
(>= 2000px wide) and keep them roughly the same framing — the spotlight reads as
one image dissolving into another only when the two line up.

Paths are resolved with `asset()` from Blade, not through Vite, so files here are
served straight from `public/` and are not fingerprinted.
