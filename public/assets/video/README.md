# Background videos

Two panels on the home page are backed by an ambient loop: `smart-city-highlights.*`
sits behind the "Smart Green City highlights" carousel, and `ready-to-compete.*`
backs the closing panel.

Both supplied sources were far too heavy to ship as autoplaying backgrounds, so
each was re-encoded to 1280px wide with the audio track stripped — a muted
background loop has no use for it, and dropping it also keeps mobile autoplay
policies happy.

## `ready-to-compete.*`

The supplied 1924x1076 source ran to 14 MB at 9.4 Mbps.

| File | Purpose | Size |
|---|---|---|
| `ready-to-compete.webm` | VP9, preferred by browsers that support it | ~870 KB |
| `ready-to-compete.mp4` | H.264 with `+faststart`, universal fallback | ~740 KB |
| `ready-to-compete-poster.jpg` | First frame, shown until the video decodes | ~70 KB |

## `smart-city-highlights.*`

The supplied 1756x1176 source ran 13 s and 13 MB at 8.3 Mbps.

| File | Purpose | Size |
|---|---|---|
| `smart-city-highlights.webm` | VP9, preferred by browsers that support it | ~795 KB |
| `smart-city-highlights.mp4` | H.264 with `+faststart`, universal fallback | ~760 KB |
| `smart-city-highlights-poster.jpg` | First frame, shown until the video decodes | ~42 KB |

## Replacing one

Keep the three filenames for the panel you are replacing and re-run, substituting
the stem (`ready-to-compete` or `smart-city-highlights`):

```bash
ffmpeg -i source.mp4 -an -vf scale=1280:-2 -c:v libx264 -crf 28 -preset slow \
  -pix_fmt yuv420p -movflags +faststart <stem>.mp4
ffmpeg -i source.mp4 -an -vf scale=1280:-2 -c:v libvpx-vp9 -crf 36 -b:v 0 \
  -row-mt 1 <stem>.webm
ffmpeg -ss 0.5 -i source.mp4 -frames:v 1 -vf scale=1280:-2 -q:v 4 \
  <stem>-poster.jpg
```

Playback is handled by `initAmbientVideo()` in `resources/js/app.js`: every
`[data-ambient-video]` element is paused until its panel scrolls into view, and
left on the poster frame entirely when the visitor prefers reduced motion.
