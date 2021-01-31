<?php

namespace Revolution\Ordering\Support;

use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\HtmlString;

class QrCode
{
    /**
     * @param  string  $url
     *
     * @return HtmlString
     */
    public static function svg(string $url): HtmlString
    {
        $svg = (new Writer(
            new ImageRenderer(
                new RendererStyle(192, 0, null, null, Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(45, 55, 72))),
                new SvgImageBackEnd()
            )
        ))->writeString($url);

        $svg = trim(substr($svg, strpos($svg, "\n") + 1));

        return new HtmlString($svg);
    }
}
