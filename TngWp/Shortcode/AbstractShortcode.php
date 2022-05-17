<?php

abstract class TngWp_Shortcode_AbstractShortcode
{

    /**
     *
     * @var TngWp_ShortcodeContent
     */
    protected $content;

    /**
     * @var TngWp_Templates
     */
    protected $templates;

    public function init(TngWp_ShortcodeContent $content, $templates)
    {
        $this->content = $content;
        $this->templates = $templates;

        add_shortcode(static::SHORTCODE, array($this, 'show'));
    }

    public function showShortcode()
    {
        //try {
            $this->content->init();
            return $this->show();
       // } catch (TngWp_WpOnlyException $e) {
            //return '<div class="error">You must be a TNG user to use this part of the site, please contact your administrator</div>';
        //}
    }

    abstract public function show();
}
