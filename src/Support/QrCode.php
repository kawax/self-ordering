<?php

declare(strict_types=1);

namespace Revolution\Ordering\Support;

use BaconQrCode\Renderer\Color\Gray;
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
     * @return HtmlString
     */
    public static function svg(string $url): HtmlString
    {
        $fill = Fill::uniformColor(
            new Gray(100),
            new Gray(20)
        );

        $svg = (new Writer(new ImageRenderer(
            new RendererStyle(192, 0, null, null, $fill),
            new SvgImageBackEnd()))
        )->writeString($url);

        return new HtmlString(trim($svg));
    }
}
