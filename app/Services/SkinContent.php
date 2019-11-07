<?php

namespace App\Services;

use App\Models\Skin;
use Illuminate\Support\Str;

class SkinContent
{
    /**
     * @var Skin
     */
    private $skin;

    /**
     * @var string|null
     */
    protected $content;

    /**
     * ContentHandler constructor.
     *
     * @param Skin $skin
     */
    public function __construct(Skin $skin)
    {
        $this->skin = $skin;
        $this->content = $skin->getIndexFileContent();
    }

    /**
     * @return string|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return bool
     */
    public function hasContent()
    {
        return !is_null($this->getContent());
    }

    /**
     * @return bool
     */
    public function hasDataKey()
    {
        return Str::contains($this->getContent(), $this->skin->getDataKey());
    }

    /**
     * @param mixed $content
     *
     * @return string
     */
    public function injectContainerData($content)
    {
        return Str::replaceFirst($this->skin->getDataKey(), $this->getJSSnippet($content), $this->getContent());
    }

    /**
     * @param mixed $content
     *
     * @return string
     */
    private function getJSSnippet($content)
    {
        $content = json_encode($content);

        return "<script>window.data={$content}</script>";
    }
}
