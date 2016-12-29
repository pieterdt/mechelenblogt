<?php

namespace Drupal\mg_scale_filter\Plugin\Filter;

use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\FilterProcessResult;


/**
 * @Filter(
 *   id = "filter_mg_scale",
 *   title = @Translation("Malines Graphique Filter"),
 *   description = @Translation("Scales images identified as MG images with the class malinesgraphique."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class MGScale extends FilterBase {

  public function process($text, $langcode) {
//    $text = $this->mg_scale_filter_rescale_regex($text, "/<img\s+src=\"(?P<src>[^\"]+)\"\s+width=\"(?P<width>\d+)\"\s+height=\"(?P<height>\d+)\"\s+class=\"malinesgraphique\"(\s+alt=\"[^\"]*\")?\s*\/>/");
//    $text = $this->mg_scale_filter_rescale_regex($text, "/<img\s+width=\"(?P<width>\d+)\"\s+height=\"(?P<height>\d+)\"(\s+alt=\"[^\"]*\")?\s+src=\"(?P<src>[^\"]+)\"\s+class=\"malinesgraphique\"(\s+alt=\"[^\"]*\")?\s*\/>/");
//    $text = $this->mg_scale_filter_rescale_regex($text, "/<img\s+width=\"(?P<width>\d+)\"\s+height=\"(?P<height>\d+)\"\s+class=\"malinesgraphique\"\s+src=\"(?P<src>[^\"]+)\"(\s+alt=\"[^\"]*\")?\s*\/>/");
    return new FilterProcessResult($text);
  }  

  /**
   * Callback function for the regular expression preg_replace.
   *
   * Look up the named groups src, widht and height.
   * Use the width to calculate the height of the image at width 180px.
   * Return a full HTML <img> tag using these modified dimensions.
   */
  private function mg_scale_filter_rescale_regex_callback($matches) {
    $src = $matches["src"];
    $width_factor = 180 / ($matches["width"]);
    $height = round($matches["height"]*$width_factor,0);
    return "<img src=\"$src\" width=\"180\" height=\"$height\" class=\"malines-graphique-picture\" />";
  }

  /**
   * Rescale images to 180px wide given the provided regular expression.
   *
   * The regular expression should contain named groups for src, widht and height.
   * Use a callback function to return the altered <img> tag.
   */
  private function mg_scale_filter_rescale_regex($text, $expression) {
    $text = preg_replace_callback(
      $expression,
      mg_scale_filter_rescale_regex_callback,
      $text
    );
    return $text;
  }

}
